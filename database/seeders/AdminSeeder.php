<?php

namespace Database\Seeders;

// Mengimpor Model Admin, class Seeder bawaan, dan utilitas Hash
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * AdminSeeder (Penyuntik Data Akun Admin Default)
 *
 * Bertugas memasukkan data akun admin pengelola utama pertama kali ke database.
 * Sangat berguna agar saat aplikasi baru diinstal di komputer penguji,
 * kita tidak perlu repot membuat akun secara manual dari phpMyAdmin.
 */
class AdminSeeder extends Seeder
{
    /**
     * Menjalankan proses pengisian data database (Seed).
     */
    public function run(): void
    {
        // Menggunakan method updateOrCreate()
        // Keuntungan: Mencegah error duplikasi jika seeder tidak sengaja dijalankan 2x atau lebih!
        Admin::updateOrCreate(
            [
                // Kunci pencarian: Cari apakah admin dengan username 'hanan' sudah ada di database?
                'username' => 'hanan',
            ],
            [
                // Jika belum ada, buatkan data baru berikut ini:
                'name' => 'Hanan Aria Santagama',
                // Password di-hash menggunakan algoritma Bcrypt yang aman
                'password' => Hash::make('hanan123'),
            ]
        );
    }
}
