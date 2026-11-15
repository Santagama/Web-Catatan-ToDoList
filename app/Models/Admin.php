<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model Admin
 *
 * Mewarisi Authenticatable agar dapat digunakan oleh sistem autentikasi Laravel (Session Auth)
 * untuk menangani proses login dan proteksi route dashboard.
 */
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel di database MySQL.
     */
    protected $table = 'admins';

    /**
     * Kolom-kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    /**
     * Kolom yang disembunyikan saat data diubah menjadi array atau JSON demi keamanan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Pengaturan casting tipe data otomatis bawaan Laravel.
     */
    protected function casts(): array
    {
        return [
            // Otomatis mengenkripsi password dengan Bcrypt saat di-assign
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi One-to-Many: Satu admin dapat mengelola banyak portofolio UMKM.
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class, 'admin_id');
    }

    /**
     * Relasi One-to-Many: Satu admin memiliki banyak catatan riwayat aktivitas.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'admin_id');
    }
}
