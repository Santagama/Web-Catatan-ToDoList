<?php

// Mengimpor Model ActivityLog dan Portfolio, serta utilitas Scheduler bawaan Laravel
use App\Models\ActivityLog;
use App\Models\Portfolio;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes & Task Scheduler
|--------------------------------------------------------------------------
|
| File ini berisi perintah Artisan berbasis baris perintah (CLI)
| serta tugas otomasi berjadwal (Task Scheduler) yang berjalan otomatis di background.
|
*/

// Perintah bawaan Laravel untuk menampilkan kutipan motivasi (php artisan inspire)
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| TUGAS OTOMATIS: AUTO-DRAFT PAKET KADALUARSA (Task Scheduler)
|--------------------------------------------------------------------------
|
| Tugas otomasi ini berjalan otomatis setiap hari tepat jam 00:00 tengah malam.
| CARA KERJA:
| 1. Sistem mencari portofolio UMKM yang statusnya masih 'publish' tapi
|    tanggal expired_at-nya sudah melewati waktu saat ini.
| 2. Jika ditemukan, sistem otomatis mengubah statusnya menjadi 'draft'
|    sehingga website UMKM tersebut tidak lagi bisa dilihat pengunjung publik.
| 3. Sistem mencatat kejadian penonaktifan ini ke tabel activity_logs secara otomatis.
|
| CARA UJI MANUAL DI TERMINAL:
| Ketik: php artisan schedule:run
|
*/
Schedule::call(function () {
    // 1. Cari semua portofolio yang aktif (publish) namun tanggal masa aktifnya sudah lewat
    $portfolioExpired = Portfolio::where('status', 'publish')
        ->whereNotNull('expired_at')
        ->where('expired_at', '<', now())
        ->get();

    // 2. Looping data yang kadaluarsa untuk dinonaktifkan satu per satu
    foreach ($portfolioExpired as $portfolio) {
        // Ubah status tayang menjadi draft
        $portfolio->update(['status' => 'draft']);

        // Catat otomatis ke tabel riwayat audit
        ActivityLog::create([
            'admin_id' => $portfolio->admin_id,
            'portfolio_id' => $portfolio->id,
            'action' => 'AUTO_DRAFT',
            'description' => 'Paket portofolio "'.$portfolio->nama_umkm
                .'" telah melewati masa aktif dan otomatis dialihkan ke status draft oleh sistem scheduler.',
            'created_at' => now(),
        ]);
    }
})->dailyAt('00:00') // Jadwalkan jalan setiap hari jam 12 malam
    ->description('Memeriksa dan menonaktifkan portofolio yang paketnya sudah kadaluarsa');
