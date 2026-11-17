<?php

namespace App\Http\Controllers;

// Mengimpor Model Portfolio dan SlugHistory untuk query data ke database
use App\Models\Portfolio;
use App\Models\SlugHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * PublicController (Pengontrol Halaman Publik / Pengunjung Umum)
 *
 * Controller ini menangani halaman yang dapat diakses oleh siapa saja tanpa perlu login:
 * 1. Landing Page utama promosi jasa web builder kami.
 * 2. Halaman portofolio website UMKM berdasarkan alamat URL / slug.
 * 3. Fitur cerdas SEO 301 Redirect jika alamat slug pernah diganti.
 * 4. Penanganan halaman Error 404 jika alamat web tidak ditemukan atau sudah expired.
 */
class PublicController extends Controller
{
    /**
     * Menampilkan Landing Page promosi utama.
     * Siapapun yang membuka alamat web utama (root '/') akan diarahkan ke sini.
     */
    public function landing(): View
    {
        // 1. Ambil maksimal 6 data portofolio UMKM yang statusnya sudah 'publish'
        // Diurutkan dari yang paling baru diupdate untuk dipamerkan di section showcase
        $showcasePortfolios = Portfolio::where('status', 'publish')
            ->latest('updated_at')
            ->take(6)
            ->get();

        // 2. Kirim data portofolio tersebut ke file tampilan 'resources/views/public/landing.blade.php'
        return view('public.landing', compact('showcasePortfolios'));
    }

    /**
     * Menampilkan halaman website UMKM berdasarkan slug URL unik (misal: /kopi-kenangan).
     *
     * ALUR LOGIKA PENTING (Bagus banget untuk dijelaskan saat Ujikom):
     * Langkah 1: Cari slug di tabel 'portfolios'.
     *             - Jika ketemu & status publish & belum expired -> Tampilkan template websitenya!
     * Langkah 2: Jika tidak ketemu, cari slug di tabel riwayat 'slug_histories'.
     *             - Jika ketemu -> Berarti slug ini pernah diganti! Langsung Redirect 301 ke slug baru!
     * Langkah 3: Jika di tabel riwayat pun tidak ada -> Lempar error 404 (Halaman Tidak Ditemukan).
     */
    public function show(string $slug): View|RedirectResponse
    {
        // --- LANGKAH 1: Cari data portofolio berdasarkan slug di tabel utama ---
        $portfolio = Portfolio::where('slug', $slug)->first();

        // Jika data UMKM ditemukan di tabel utama:
        if ($portfolio) {
            // Cek 1A: Apakah statusnya sudah publish? Kalau masih draft, jangan boleh dilihat orang luar!
            if ($portfolio->status !== 'publish') {
                abort(404); // Tampilkan halaman 404 Not Found
            }

            // Cek 1B: Apakah masa aktif paketnya sudah habis (kadaluarsa)?
            if ($portfolio->isExpired()) {
                abort(404); // Jika paket habis, sembunyikan dari publik
            }

            // Tentukan nama file Blade template berdasarkan template_id yang dipilih UMKM (minuman/makanan/barang/tokoh/jasa)
            $viewName = 'public.templates.'.$portfolio->template_id;

            // Jika template tidak ditemukan di folder, gunakan template 'minuman' sebagai cadangan aman (fallback)
            if (! view()->exists($viewName)) {
                $viewName = 'public.templates.minuman';
            }

            // Tampilkan halaman website UMKM kepada pengunjung
            return view($viewName, compact('portfolio'));
        }

        // --- LANGKAH 2: Cek apakah slug ini adalah SLUG LAMA yang pernah diganti nama ---
        $history = SlugHistory::where('slug_lama', $slug)->latest('created_at')->first();

        // Jika riwayat slug lama ditemukan:
        if ($history) {
            // Lakukan pengalihan permanen (HTTP Status Code 301 Moved Permanently) ke slug yang baru!
            // Ini sangat penting untuk menjaga nilai SEO Google agar link lama tidak rusak/mati
            return redirect()->to('/'.$history->slug_baru, 301);
        }

        // --- LANGKAH 3: Jika dicari ke mana-mana memang tidak ada, tampilkan halaman 404 ---
        abort(404);
    }
}
