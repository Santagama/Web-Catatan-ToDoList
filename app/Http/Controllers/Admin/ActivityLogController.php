<?php

namespace App\Http\Controllers\Admin;

// Mengimpor controller dasar, model ActivityLog, dan utilitas HTTP Request
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * ActivityLogController (Pengontrol Halaman Jejak Audit Aktivitas)
 *
 * Menampilkan catatan sejarah lengkap seluruh aktivitas yang pernah dilakukan admin:
 * - Siapa yang login atau logout.
 * - Siapa yang menambah, mengedit, atau menghapus website portofolio UMKM.
 * - Dilengkapi fitur filter berdasarkan bulan dan tahun serta ringkasan angka aksi bulan ini.
 */
class ActivityLogController extends Controller
{
    /**
     * Menampilkan daftar riwayat log aktivitas dalam bentuk linimasa (timeline).
     */
    public function index(Request $request): View
    {
        // 1. Siapkan query Eloquent dengan Eager Loading relasi 'admin' dan 'portfolio'
        // agar tidak terkena masalah performa N+1 Query
        $query = ActivityLog::with('admin', 'portfolio');

        // FITUR FILTER 1: Berdasarkan Bulan (1 - 12)
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->input('bulan'));
        }

        // FITUR FILTER 2: Berdasarkan Tahun (contoh: 2026)
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->input('tahun'));
        }

        // 2. Ambil data dengan urutan waktu terbaru dan batasi 15 per halaman (Pagination)
        $logs = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        // 3. HITUNG RINGKASAN AKSI BULAN INI (Untuk kartu statistik di bagian atas halaman):
        $summaryBulanIni = [
            // Total seluruh aksi apapun di bulan ini
            'total' => ActivityLog::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            // Total berapa portofolio baru yang dibuat bulan ini
            'tambah' => ActivityLog::where('action', 'TAMBAH_PORTFOLIO')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            // Total berapa kali portofolio diedit bulan ini
            'edit' => ActivityLog::where('action', 'EDIT_PORTFOLIO')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            // Total berapa portofolio yang dihapus bulan ini
            'hapus' => ActivityLog::where('action', 'HAPUS_PORTFOLIO')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        // 4. Kirim data ke view Blade 'resources/views/admin/logs/index.blade.php'
        return view('admin.logs.index', compact('logs', 'summaryBulanIni'));
    }
}
