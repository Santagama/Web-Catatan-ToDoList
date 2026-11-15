<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware PreventBackHistory
 *
 * Mencegah browser menyimpan cache halaman admin ke memori (Back-Forward Cache).
 * Masalah umum web: Saat admin sudah logout, jika tombol 'Back' di browser ditekan,
 * browser bisa menampilkan halaman dashboard dari memori cache lokal.
 *
 * Dengan header HTTP Cache-Control 'no-store, no-cache, must-revalidate',
 * browser dipaksa untuk selalu meminta ulang ke server. Server kemudian mendeteksi
 * bahwa sesi login sudah mati (invalidated), dan otomatis menolak akses
 * serta mengembalikan pengguna ke halaman login.
 */
class PreventBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Pasang header pelindung cache pada respon HTTP
        $response->headers->set('Cache-Control', 'no-cache, private, no-store, must-revalidate, max-stale=0, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
