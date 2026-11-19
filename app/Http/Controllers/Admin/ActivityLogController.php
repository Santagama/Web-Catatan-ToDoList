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

        // 3. HITUNG RINGKASAN AKSI DINAMIS SESUAI FILTER (Untuk 4 kartu metrik di atas):
        // Query dasar kartu ringkasan otomatis mengikuti filter bulan dan tahun yang sedang dipilih admin
        $summaryQuery = ActivityLog::query();

        // Jika admin memilih filter bulan tertentu (1 - 12)
        if ($request->filled('bulan')) {
            $summaryQuery->whereMonth('created_at', $request->input('bulan'));
        }

        // Jika admin memilih filter tahun tertentu (misal: 2026)
        if ($request->filled('tahun')) {
            $summaryQuery->whereYear('created_at', $request->input('tahun'));
        }

        $summaryBulanIni = [
            // Total seluruh aksi apapun pada periode filter yang dipilih
            'total' => (clone $summaryQuery)->count(),

            // Total aksi tambah portofolio pada periode filter yang dipilih
            'tambah' => (clone $summaryQuery)->where(function ($q) {
                $q->where('action', 'TAMBAH_PORTFOLIO')
                    ->orWhere('action', 'like', '%TAMBAH%');
            })->count(),

            // Total aksi edit portofolio pada periode filter yang dipilih
            'edit' => (clone $summaryQuery)->where(function ($q) {
                $q->where('action', 'EDIT_PORTFOLIO')
                    ->orWhere('action', 'like', '%EDIT%');
            })->count(),

            // Total aksi hapus portofolio pada periode filter yang dipilih
            'hapus' => (clone $summaryQuery)->where(function ($q) {
                $q->where('action', 'HAPUS_PORTFOLIO')
                    ->orWhere('action', 'like', '%HAPUS%');
            })->count(),
        ];

        // 4. Kirim data ke view Blade 'resources/views/admin/logs/index.blade.php'
        return view('admin.logs.index', compact('logs', 'summaryBulanIni'));
    }
}
