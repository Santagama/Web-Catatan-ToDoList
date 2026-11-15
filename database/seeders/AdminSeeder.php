<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder Akun Admin Default
 *
 * Bertugas menyuntikkan (inject) data akun pengelola utama ke tabel 'admins'
 * agar aplikasi langsung memiliki kredensial siap pakai untuk login pertama kali.
 */
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate untuk mencegah duplikasi jika seeder dijalankan lebih dari satu kali
        Admin::updateOrCreate(
            ['username' => 'hanan'], // Kunci pencarian unik
            [
                'name' => 'Hanan Aria Santagama',
                'password' => Hash::make('hanan123'), // Password di-hash menggunakan algoritma Bcrypt
            ]
        );
    }
}
