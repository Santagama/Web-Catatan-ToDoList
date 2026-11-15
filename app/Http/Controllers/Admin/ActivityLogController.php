<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * ActivityLogController (Pengontrol Halaman Jejak Audit)
 *
 * Menampilkan riwayat lengkap seluruh aktivitas admin di sistem
 * dengan fitur filter berdasarkan bulan dan tahun.
 */
class ActivityLogController extends Controller
{
    /**
     * Menampilkan halaman timeline jejak audit aktivitas admin.
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::with('admin', 'portfolio');

        // Filter berdasarkan bulan dan tahun jika diminta
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->input('bulan'));
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->input('tahun'));
        }

        // Ambil data dengan urutan terbaru
        $logs = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        // Hitung ringkasan total aksi bulan ini
        $summaryBulanIni = [
            'total' => ActivityLog::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'tambah' => ActivityLog::where('action', 'TAMBAH_PORTFOLIO')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'edit' => ActivityLog::where('action', 'EDIT_PORTFOLIO')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'hapus' => ActivityLog::where('action', 'HAPUS_PORTFOLIO')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('admin.logs.index', compact('logs', 'summaryBulanIni'));
    }
}
