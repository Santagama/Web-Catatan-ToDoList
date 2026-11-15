<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Portfolio;
use Illuminate\View\View;

/**
 * DashboardController (Pengontrol Halaman Utama Admin)
 *
 * Bertanggung jawab menghitung dan menyajikan data metrik ringkasan
 * (Total Portofolio, Status Publish/Draft, Paket Kadaluarsa) serta 5 data terbaru.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama admin.
     */
    public function index(): View
    {
        // 1. Menghitung statistik portofolio
        $totalPortfolios = Portfolio::count();
        $publishedPortfolios = Portfolio::where('status', 'publish')->count();
        $draftPortfolios = Portfolio::where('status', 'draft')->count();

        // Menghitung portofolio yang sudah lewat dari tanggal expired_at
        $expiredPortfolios = Portfolio::whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->count();

        // Menghitung jumlah template yang sedang aktif terpakai
        $usedTemplates = Portfolio::distinct('template_id')->count('template_id');

        // 2. Mengambil 5 portofolio yang baru saja dibuat/diupdate
        $recentPortfolios = Portfolio::latest('updated_at')
            ->take(5)
            ->get();

        // 3. Mengambil 5 rekam jejak aktivitas terakhir beserta nama adminnya
        $recentActivities = ActivityLog::with('admin')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPortfolios',
            'publishedPortfolios',
            'draftPortfolios',
            'expiredPortfolios',
            'usedTemplates',
            'recentPortfolios',
            'recentActivities'
        ));
    }
}
