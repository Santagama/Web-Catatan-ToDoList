<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder Utama (Master Database Seeder)
 *
 * Titik masuk utama saat perintah 'php artisan db:seed' dijalankan.
 * Hanya memanggil AdminSeeder untuk akun login admin default.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Inisialisasi Akun Admin Default
        $this->call(AdminSeeder::class);
    }
}
