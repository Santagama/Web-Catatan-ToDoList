<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model ActivityLog
 *
 * Merepresentasikan pencatatan audit log segala aktivitas penting admin di sistem
 * (Login, Tambah UMKM, Edit UMKM, Hapus UMKM, Auto Draft, dll).
 */
class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database MySQL.
     */
    protected $table = 'activity_logs';

    /**
     * Menonaktifkan updated_at bawaan Laravel karena tabel ini hanya mencatat kapan aksi dibuat (created_at).
     */
    public $timestamps = false;

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'admin_id',
        'portfolio_id',
        'action',
        'description',
        'created_at',
    ];

    /**
     * Pengaturan casting tipe data otomatis bawaan Laravel.
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    /**
     * Relasi Many-to-One: Log aktivitas dicatat oleh satu Admin tertentu.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relasi Many-to-One: Log aktivitas dapat terkait dengan satu Portofolio tertentu (bersifat opsional/nullable).
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }

    /**
     * Static Helper Method: Mempermudah pencatatan log dari controller manapun.
     *
     * Contoh pemanggilan:
     * ActivityLog::record('TAMBAH_PORTFOLIO', 'Admin Hanan menambahkan UMKM Kopi Kita', $portfolio->id);
     */
    public static function record(string $action, string $description, ?int $portfolioId = null): self
    {
        return self::create([
            'admin_id' => auth()->id() ?? 1,
            'portfolio_id' => $portfolioId,
            'action' => $action,
            'description' => $description,
            'created_at' => now(),
        ]);
    }
}
