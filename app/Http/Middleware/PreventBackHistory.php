<?php

namespace App\Http\Middleware;

// Mengimpor Closure dan class Request & Response bawaan HTTP
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware PreventBackHistory
 *
 * Mencegah browser menyimpan halaman dashboard admin ke dalam memori cache lokal (Back-Forward Cache).
 *
 * MASALAH UMUM KEAMANAN WEB:
 * Setelah admin menekan tombol "Logout", jika seseorang menekan tombol "Back" (panah kembali) di browser,
 * browser biasa akan menampilkan kembali halaman dashboard dari memori cache RAM komputer!
 * Ini sangat berbahaya karena data sensitif masih bisa diintip orang lain di warnet/lab sekolah.
 *
 * SOLUSI DENGAN MIDDLEWARE INI:
 * Kita memasang header HTTP Cache-Control: 'no-store, no-cache, must-revalidate'.
 * Header ini memaksa browser agar SELALU meminta data ulang ke server setiap kali halaman dibuka.
 * Saat browser meminta ke server, Laravel mendeteksi session sudah mati (invalidated),
 * sehingga akses langsung ditolak dan otomatis dilempar kembali ke halaman login!
 */
class PreventBackHistory
{
    /**
     * Memproses setiap request HTTP yang masuk ke aplikasi.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jalankan dulu request hingga menghasilkan respon halaman dari Controller
        $response = $next($request);

        // 2. Suntikkan 3 header keamanan HTTP pada respon sebelum dikirim ke browser:

        // Header 1: Melarang keras browser menyimpan halaman ini ke cache disk maupun memori RAM
        $response->headers->set('Cache-Control', 'no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0');

        // Header 2: Kompatibilitas untuk browser versi lama (protokol HTTP/1.0)
        $response->headers->set('Pragma', 'no-cache');

        // Header 3: Membuat tanggal kedaluwarsa halaman langsung ke masa lalu (tahun 1990)
        // sehingga browser menganggap data ini sudah basi sejak detik pertama diterima
        $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        // 3. Kembalikan respon yang sudah aman ke browser pengguna
        return $response;
    }
}
