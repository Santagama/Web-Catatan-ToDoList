<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Portfolio
 *
 * Merepresentasikan data satu entitas website portofolio UMKM.
 * Menggunakan fitur Attribute Casting untuk mengubah kolom JSON 'products'
 * menjadi array PHP secara otomatis saat dipanggil di Controller maupun View Blade.
 */
class Portfolio extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database MySQL.
     */
    protected $table = 'portfolios';

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'admin_id',
        'template_id',
        'business_name',
        'slug',
        'bio',
        'alamat',
        'whatsapp',
        'maps_embed_url',
        'logo_path',
        'banner_path',
        'products',
        'paket',
        'expired_at',
        'status',
    ];

    /**
     * Pengaturan casting tipe data otomatis bawaan Laravel.
     */
    protected function casts(): array
    {
        return [
            // Sangat Penting: Mengubah string JSON di MySQL menjadi Array PHP secara otomatis,
            // dan sebaliknya mengubah Array PHP menjadi string JSON saat disimpan ke database.
            'products' => 'array',
            'expired_at' => 'datetime',
        ];
    }

    /**
     * Accessor & Mutator untuk maps_embed_url:
     * - Mutator (set): Otomatis mengekstrak URL dari tag <iframe src="..."> jika pengguna menempelkan kode sematan lengkap.
     * - Accessor (get): Memastikan URL yang dikembalikan ke view selalu URL bersih (bukan tag <iframe>),
     *   sehingga aman untuk data lama di database dan mencegah error 404 pada template.
     */
    protected function mapsEmbedUrl(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => self::sanitizeMapsUrl($value),
            set: fn (?string $value) => self::sanitizeMapsUrl($value),
        );
    }

    /**
     * Ekstraksi URL bersih Google Maps Embed.
     * Menerima:
     * 1. Tag HTML <iframe src="..."></iframe>
     * 2. URL embed langsung (https://www.google.com/maps/embed?...)
     * 3. Link share Google Maps (maps.google.com/?q=... dll)
     */
    public static function sanitizeMapsUrl(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $trimmed = trim($value);

        // 1. Ekstrak src dari tag <iframe ... src="...">
        if (preg_match('/<iframe\b[^>]*\bsrc=["\']([^"\']+)["\']/i', $trimmed, $matches)) {
            return html_entity_decode($matches[1]);
        }

        // 2. Ekstrak jika berawalan src="..."
        if (preg_match('/^src=["\']([^"\']+)["\']/i', $trimmed, $matches)) {
            return html_entity_decode($matches[1]);
        }

        // 3. Pastikan string adalah URL valid berawalan http:// atau https://
        if (preg_match('/^https?:\/\//i', $trimmed)) {
            return html_entity_decode($trimmed);
        }

        // 4. Jika bukan URL dan bukan iframe, ubah menjadi query embed Google Maps
        return 'https://maps.google.com/maps?q='.urlencode($trimmed).'&output=embed';
    }

    /**
     * Relasi Many-to-One: Setiap portofolio dimiliki oleh satu Admin pengelola.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relasi One-to-Many: Setiap portofolio memiliki rekam jejak aktivitas terkait.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'portfolio_id');
    }

    /**
     * Relasi One-to-Many: Setiap portofolio memiliki riwayat perubahan URL / slug.
     */
    public function slugHistories(): HasMany
    {
        return $this->hasMany(SlugHistory::class, 'portfolio_id');
    }

    /**
     * Helper Method: Memeriksa apakah masa aktif paket portofolio sudah kadaluarsa.
     */
    public function isExpired(): bool
    {
        if ($this->expired_at === null) {
            return false;
        }

        return $this->expired_at->isPast();
    }

    /**
     * Helper Method: Menghitung sisa hari aktif paket portofolio.
     */
    public function remainingDays(): ?int
    {
        if ($this->expired_at === null) {
            return null; // Tanpa batas waktu
        }

        if ($this->isExpired()) {
            return 0;
        }

        return (int) Carbon::now()->diffInDays($this->expired_at, false);
    }
}
