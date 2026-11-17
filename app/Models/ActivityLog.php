<?php

namespace App\Models;

// Mengimpor class Model dan Relasi Eloquent
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model ActivityLog
 *
 * Ini adalah model untuk mencatat seluruh jejak audit (Audit Trail) aktivitas admin di sistem.
 * Setiap ada login, logout, tambah UMKM, ubah data, atau hapus data, otomatis dicatat di sini.
 */
class ActivityLog extends Model
{
    use HasFactory;

    // 1. Menentukan nama tabel di database MySQL
    protected $table = 'activity_logs';

    // 2. Kita matikan updated_at karena log aktivitas sifatnya permanen (hanya butuh waktu dibuat: created_at)
    public $timestamps = false;

    // 3. Kolom-kolom yang boleh diisi langsung (Mass Assignment)
    protected $fillable = [
        'admin_id',     // ID admin pelaku yang melakukan aksi
        'portfolio_id', // ID portofolio yang terpengaruh (opsional, boleh kosong jika aksi login/logout)
        'action',       // Kode aksi singkat (contoh: 'LOGIN', 'TAMBAH_PORTFOLIO', 'HAPUS_PORTFOLIO')
        'description',  // Penjelasan detail kalimat yang mudah dibaca manusia
        'created_at',   // Waktu kejadian aksi
    ];

    // 4. Casting tipe data otomatis dari Laravel
    protected function casts(): array
    {
        return [
            // Mengubah created_at menjadi objek Carbon (tanggal & jam) agar mudah diformat di tampilan
            'created_at' => 'datetime',
        ];
    }

    // 5. RELASI: Log aktivitas dicatat oleh satu orang Admin (Many-to-One)
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // 6. RELASI: Log aktivitas dapat terkait dengan satu Portofolio UMKM tertentu (Many-to-One, opsional)
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }

    // 7. FUNGSI PEMBANTU (Helper Praktis): Mempermudah pencatatan log hanya dengan 1 baris di Controller
    // Contoh pemakaian di Controller: ActivityLog::record('LOGIN', 'Admin Hanan berhasil login.');
    public static function record(string $action, string $description, ?int $portfolioId = null): self
    {
        return self::create([
            'admin_id' => auth()->id() ?? 1, // Mengambil ID admin yang sedang login (default 1 jika sesi cron/seeder)
            'portfolio_id' => $portfolioId,      // ID portofolio terkait (bisa null)
            'action' => $action,            // Jenis aksi
            'description' => $description,       // Deskripsi lengkap kejadian
            'created_at' => now(),               // Waktu sekarang
        ]);
    }
}
