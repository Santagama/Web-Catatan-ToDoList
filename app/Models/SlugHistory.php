<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model SlugHistory
 *
 * Merepresentasikan pencatatan riwayat perubahan slug URL portofolio UMKM
 * untuk mendukung fitur SEO HTTP 301 Permanent Redirect.
 */
class SlugHistory extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database MySQL.
     */
    protected $table = 'slug_histories';

    /**
     * Menonaktifkan updated_at karena tabel ini hanya mencatat kapan riwayat terjadi (created_at).
     */
    public $timestamps = false;

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'portfolio_id',
        'slug_lama',
        'slug_baru',
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
     * Relasi Many-to-One: Riwayat slug dimiliki oleh satu Portofolio.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }
}
