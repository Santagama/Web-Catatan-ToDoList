<?php

namespace App\Models;

// Mengimpor trait dan class bawaan Laravel yang kita butuhkan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable; // Agar model ini bisa dipakai login (Auth Laravel)
use Illuminate\Notifications\Notifiable;

/**
 * Model Admin
 *
 * Ini adalah model untuk mengelola data akun Admin (pengelola sistem).
 * Model ini mewarisi (extends) Authenticatable agar dikenali sistem Auth bawaan Laravel.
 */
class Admin extends Authenticatable
{
    // Mengaktifkan fitur factory (untuk data uji coba) dan notifikasi bawaan Laravel
    use HasFactory, Notifiable;

    // 1. Menentukan nama tabel di database MySQL kita
    protected $table = 'admins';

    // 2. Kolom-kolom yang boleh diisi langsung dari form (Mass Assignment)
    protected $fillable = [
        'name',     // Menyimpan nama lengkap admin (contoh: "Hanan Aria Santagama")
        'username', // Menyimpan username unik untuk login (contoh: "hanan")
        'password', // Menyimpan kata sandi yang akan otomatis di-hash
    ];

    // 3. Kolom rahasia yang disembunyikan agar password tidak pernah bocor ke tampilan JSON / API
    protected $hidden = [
        'password',
    ];

    // 4. Pengaturan tipe data (Casting) otomatis dari Laravel
    protected function casts(): array
    {
        return [
            // Setiap kali kita mengisi password baru, Laravel otomatis mengubahnya jadi hash Bcrypt yang aman
            'password' => 'hashed',
        ];
    }

    // 5. RELASI: Satu admin bisa membuat atau mengelola BANYAK data portofolio UMKM (One-to-Many)
    public function portfolios(): HasMany
    {
        // Hubungkan foreign key 'admin_id' di tabel portfolios dengan 'id' admin ini
        return $this->hasMany(Portfolio::class, 'admin_id');
    }

    // 6. RELASI: Satu admin memiliki BANYAK catatan log aktivitas (One-to-Many)
    public function activityLogs(): HasMany
    {
        // Hubungkan foreign key 'admin_id' di tabel activity_logs dengan 'id' admin ini
        return $this->hasMany(ActivityLog::class, 'admin_id');
    }
}
