<?php

namespace App\Http\Controllers\Admin;

// Mengimpor controller dasar serta model Portfolio dan ActivityLog
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Portfolio;
use Illuminate\View\View;

/**
 * DashboardController (Pengontrol Halaman Beranda Utama Admin)
 *
 * Bertanggung jawab mengumpulkan data statistik metrik dan ringkasan aktivitas:
 * - Menghitung jumlah total portofolio UMKM yang terdaftar.
 * - Memisahkan berapa yang berstatus Publish dan Draft.
 * - Mendeteksi berapa website UMKM yang paketnya sudah kadaluarsa (Expired).
 * - Menghitung berapa varian tema/template yang sedang dipakai.
 * - Mengambil 5 portofolio terbaru dan 5 log aktivitas terakhir.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama admin beserta seluruh metrik statistik.
     */
    public function index(): View
    {
        // 1. HITUNG STATISTIK METRIK:
        // Hitung total seluruh portofolio UMKM di database
        $totalPortfolios = Portfolio::count();

        // Hitung portofolio yang aktif tayang (status = 'publish')
        $publishedPortfolios = Portfolio::where('status', 'publish')->count();

        // Hitung portofolio yang masih dalam konsep (status = 'draft')
        $draftPortfolios = Portfolio::where('status', 'draft')->count();

        // Hitung portofolio yang tanggal expired_at-nya sudah lewat dari waktu saat ini
        $expiredPortfolios = Portfolio::whereNotNull('expired_at')
            ->where('expired_at', '<', now())
            ->count();

        // Hitung berapa jenis template berbeda yang sedang dipakai oleh UMKM
        $usedTemplates = Portfolio::distinct('template_id')->count('template_id');

        // 2. AMBIL DATA TERBARU:
        // Ambil 5 website portofolio yang baru saja dibuat atau diedit terakhir kali
        $recentPortfolios = Portfolio::latest('updated_at')
            ->take(5)
            ->get();

        // Ambil 5 catatan jejak audit aktivitas terakhir beserta data nama adminnya (Eager Loading 'with')
        $recentActivities = ActivityLog::with('admin')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // 3. KIRIM SEMUA DATA KE VIEW BLADE:
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
