<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\SlugHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * PublicController (Pengontrol Halaman Publik / Pengunjung)
 *
 * Menangani halaman yang dapat diakses tanpa login:
 * - Landing page promosi jasa web builder
 * - Halaman portofolio UMKM berdasarkan slug URL
 * - Pengalihan SEO 301 Redirect jika slug pernah diubah
 * - Penanganan error 404 untuk slug yang tidak ditemukan
 */
class PublicController extends Controller
{
    /**
     * Menampilkan landing page utama perusahaan jasa web builder.
     */
    public function landing(): View
    {
        // Ambil portofolio yang sudah publish untuk ditampilkan di section showcase
        $showcasePortfolios = Portfolio::where('status', 'publish')
            ->latest('updated_at')
            ->take(6)
            ->get();

        return view('public.landing', compact('showcasePortfolios'));
    }

    /**
     * Menampilkan halaman portofolio UMKM berdasarkan slug URL unik.
     *
     * Alur kerja (sangat penting untuk dijelaskan ke penguji):
     * 1. Cari slug di tabel portfolios -> jika ditemukan & publish -> tampilkan template
     * 2. Cari slug di tabel slug_histories -> jika ditemukan -> redirect 301 ke slug baru
     * 3. Jika tidak ditemukan di mana pun -> tampilkan halaman 404
     */
    public function show(string $slug): View|RedirectResponse
    {
        // Langkah 1: Cari portofolio berdasarkan slug di tabel utama
        $portfolio = Portfolio::where('slug', $slug)->first();

        // Jika ditemukan
        if ($portfolio) {
            // Periksa apakah statusnya sudah publish
            if ($portfolio->status !== 'publish') {
                abort(404); // Portofolio masih draft, tidak bisa diakses publik
            }

            // Periksa apakah paket sudah kadaluarsa
            if ($portfolio->isExpired()) {
                abort(404); // Paket sudah kadaluarsa
            }

            // Render template yang sesuai dengan pilihan template_id
            $viewName = 'public.templates.'.$portfolio->template_id;

            // Cek apakah file template Blade-nya ada
            if (! view()->exists($viewName)) {
                $viewName = 'public.templates.minuman'; // Fallback ke template default
            }

            return view($viewName, compact('portfolio'));
        }

        // Langkah 2: Cek apakah slug ini adalah slug LAMA yang pernah diubah
        $history = SlugHistory::where('slug_lama', $slug)->latest('created_at')->first();

        if ($history) {
            // Redirect permanen (HTTP 301) ke slug baru untuk menjaga SEO
            return redirect()->to('/'.$history->slug_baru, 301);
        }

        // Langkah 3: Slug tidak ditemukan di mana pun -> tampilkan 404
        abort(404);
    }
}
