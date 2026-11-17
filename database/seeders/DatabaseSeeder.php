<?php

namespace Database\Seeders;

// Mengimpor trait dan class Seeder bawaan Laravel
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder (Master Seeder / Titik Masuk Utama)
 *
 * Ini adalah konduktor utama yang pertama kali dipanggil saat kita mengetik:
 * php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Menjalankan seluruh proses seeder aplikasi.
     */
    public function run(): void
    {
        // Panggil AdminSeeder untuk membuat akun login admin default ('hanan' / 'hanan123')
        $this->call(AdminSeeder::class);
    }
}
