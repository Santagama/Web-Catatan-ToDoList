<?php

use App\Models\ActivityLog;
use App\Models\Portfolio;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Task Scheduler: Auto-Draft Paket Kadaluarsa
|--------------------------------------------------------------------------
|
| Tugas otomatis ini berjalan setiap hari tepat jam 00:00 tengah malam.
| Sistem mencari portofolio UMKM yang statusnya 'publish' tapi masa aktif
| paketnya (expired_at) sudah lewat dari waktu sekarang. Jika ditemukan,
| statusnya otomatis diubah menjadi 'draft' dan dicatat ke activity_logs.
|
| Untuk menguji manual: php artisan schedule:run
*/
Schedule::call(function () {
    // Cari semua portofolio yang publish tapi sudah melewati tanggal kadaluarsa
    $portfolioExpired = Portfolio::where('status', 'publish')
        ->whereNotNull('expired_at')
        ->where('expired_at', '<', now())
        ->get();

    foreach ($portfolioExpired as $portfolio) {
        // Ubah status menjadi draft
        $portfolio->update(['status' => 'draft']);

        // Catat ke tabel activity_logs secara otomatis
        ActivityLog::create([
            'admin_id' => $portfolio->admin_id,
            'portfolio_id' => $portfolio->id,
            'action' => 'AUTO_DRAFT',
            'description' => 'Paket portofolio "'.$portfolio->business_name
                .'" telah melewati masa aktif dan otomatis dialihkan ke status draft oleh sistem scheduler.',
            'created_at' => now(),
        ]);
    }
})->dailyAt('00:00')
    ->description('Memeriksa dan menonaktifkan portofolio yang paketnya sudah kadaluarsa');
