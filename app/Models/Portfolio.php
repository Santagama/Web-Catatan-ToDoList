<?php

namespace App\Models;

// Mengimpor class pembantu untuk waktu (Carbon), accessor/mutator, dan relasi database
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Portfolio
 *
 * Ini adalah model inti aplikasi, merepresentasikan 1 data website portofolio UMKM.
 * Berisi informasi profil bisnis, paket langganan, gambar logo/banner, hingga produk dalam format JSON.
 */
class Portfolio extends Model
{
    use HasFactory;

    // 1. Menentukan nama tabel di database MySQL
    protected $table = 'portfolios';

    // 2. Kolom-kolom yang boleh diisi langsung saat insert/update (Mass Assignment)
    protected $fillable = [
        'admin_id',       // ID admin yang membuat/mengelola data ini
        'template_id',    // Pilihan tema tampilan (minuman, makanan, barang, tokoh, jasa)
        'nama_umkm',      // Nama bisnis / toko UMKM
        'slug',           // Alamat URL unik (contoh: /kopi-kita)
        'bio',            // Deskripsi singkat profil usaha
        'alamat',         // Alamat lokasi fisik toko
        'whatsapp',       // Nomor WhatsApp untuk order langsung
        'instagram',      // Akun Instagram UMKM
        'maps_embed_url', // Link sematan Google Maps (sudah otomatis dibersihkan)
        'logo_path',      // Lokasi simpan file foto logo di storage
        'banner_path',    // Lokasi simpan file foto banner di storage
        'products',       // Daftar produk berupa array (disimpan sebagai JSON di MySQL)
        'paket',          // Durasi langganan (3_bulan, 1_tahun, tanpa_batas)
        'expired_at',     // Tanggal kedaluwarsa paket
        'status',         // Status tayang (publish atau draft)
    ];

    // 3. Casting tipe data otomatis dari Laravel (FITUR UNGGULAN UNTUK PENGUJI)
    protected function casts(): array
    {
        return [
            // Kolom 'products' di MySQL tersimpan sebagai teks JSON.
            // Fitur casting ini otomatis mengubahnya menjadi Array PHP murni saat dibaca di Controller/Blade,
            // dan mengubah Array menjadi JSON lagi saat disimpan ke database. Kita tidak perlu json_decode() manual!
            'products' => 'array',

            // Otomatis mengubah tanggal expired menjadi objek Carbon agar mudah dimanipulasi (hitung sisa hari, dll)
            'expired_at' => 'datetime',
        ];
    }

    // 4. ACCESSOR & MUTATOR: Pembersih URL Google Maps otomatis
    // Jika admin tidak sengaja paste kode <iframe src="..."> lengkap, sistem otomatis mengambil URL bersihnya saja.
    protected function mapsEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => self::sanitizeMapsUrl($value), // Saat data diambil
            set: fn (?string $value) => self::sanitizeMapsUrl($value), // Saat data disimpan
        );
    }

    // Fungsi pembantu untuk membersihkan link Google Maps
    public static function sanitizeMapsUrl(?string $value): ?string
    {
        // Kalau kolom maps kosong, ya biarkan null
        if (empty($value)) {
            return null;
        }

        $trimmed = trim($value);

        // Kasus 1: Kalau admin menempelkan tag HTML iframe lengkap <iframe src="https://..."></iframe>
        if (preg_match('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/i', $trimmed, $matches)) {
            return html_entity_decode($matches[1]); // Ambil link di dalam src nya saja
        }

        // Kasus 2: Kalau berawalan src="..."
        if (preg_match('/^src=["\']([^"\']+)["\']/i', $trimmed, $matches)) {
            return html_entity_decode($matches[1]);
        }

        // Kasus 3: Kalau sudah berupa URL langsung berawalan http:// atau https://
        if (preg_match('/^https?:\/\//i', $trimmed)) {
            return html_entity_decode($trimmed);
        }

        // Kasus 4: Kalau hanya nama tempat/alamat teks biasa, bungkus jadi query embed Google Maps resmi
        return 'https://maps.google.com/maps?q='.urlencode($trimmed).'&output=embed';
    }

    // 5. RELASI: Setiap portofolio dimiliki oleh satu Admin (Many-to-One)
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // 6. RELASI: Satu portofolio punya riwayat catatan log aktivitas (One-to-Many)
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'portfolio_id');
    }

    // 7. RELASI: Satu portofolio punya catatan riwayat pergantian URL slug (One-to-Many)
    public function slugHistories(): HasMany
    {
        return $this->hasMany(SlugHistory::class, 'portfolio_id');
    }

    // 8. FUNGSI PEMBANTU: Mengecek apakah paket sudah kedaluwarsa
    public function isExpired(): bool
    {
        // Kalau tidak ada batas waktu (paket tanpa batas), berarti tidak pernah expired
        if ($this->expired_at === null) {
            return false;
        }

        // Cek apakah tanggal expired sudah lewat dari waktu saat ini
        return $this->expired_at->isPast();
    }

    // 9. FUNGSI PEMBANTU: Menghitung sisa berapa hari paket masih aktif
    public function remainingDays(): ?int
    {
        // Jika tanpa batas waktu, kembalikan null
        if ($this->expired_at === null) {
            return null;
        }

        // Jika sudah lewat kedaluwarsa, sisa harinya 0
        if ($this->isExpired()) {
            return 0;
        }

        // Hitung selisih hari antara hari ini dengan tanggal kedaluwarsa
        return (int) Carbon::now()->diffInDays($this->expired_at, false);
    }

    // 10. FUNGSI PEMBANTU: Menghasilkan URL Instagram yang siap diklik pengunjung
    public function getInstagramUrlAttribute(): ?string
    {
        if (blank($this->instagram)) {
            return null;
        }

        $ig = trim($this->instagram);

        // Kalau admin sudah mengetikkan link lengkap https://instagram.com/nama, pakai langsung
        if (str_starts_with($ig, 'http://') || str_starts_with($ig, 'https://')) {
            return $ig;
        }

        // Kalau hanya ketik @nama_toko atau nama_toko, bersihkan tanda @ dan sambung ke URL resmi
        return 'https://instagram.com/'.ltrim($ig, '@');
    }
}
