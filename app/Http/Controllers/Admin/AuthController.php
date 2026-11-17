<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * AuthController (Pengontrol Autentikasi Admin)
 *
 * Bertanggung jawab menangani alur otentikasi login dan logout pengelola platform,
 * mencatat jejak audit login ke activity_logs, serta mengamankan session ID.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan formulir login admin.
     * Jika admin sudah login sebelumnya, otomatis dialihkan langsung ke dashboard.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        // Pengecekan status login: Cegah admin yang sudah login melihat form login lagi
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Memproses verifikasi kredensial login admin.
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. Validasi data input form
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Proteksi Brute-Force: Batasi maksimal 5 percobaan login gagal per menit
        $throttleKey = Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi dalam '.$seconds.' detik.',
                ]);
        }

        // 3. Verifikasi kecocokan username dan enkripsi hash password
        if (Auth::attempt($credentials)) {
            // Bersihkan pencatat kegagalan rate limiter saat sukses login
            RateLimiter::clear($throttleKey);

            // Mencegah serangan Session Fixation dengan meregenerasi session ID baru
            $request->session()->regenerate();

            // Catat log aktivitas bahwa admin berhasil login
            ActivityLog::record(
                'LOGIN',
                'Admin '.Auth::user()->name.' berhasil masuk ke dashboard sistem.'
            );

            // Redirect ke halaman yang semula dituju, atau default ke dashboard
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        // Catat satu kali kegagalan login (kunci 60 detik jika mencapai 5 kegagalan berturut-turut)
        RateLimiter::hit($throttleKey, 60);

        // 4. Jika gagal, kembalikan ke form login dengan pesan error
        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    /**
     * Memproses logout, membersihkan session, dan mencatat log aktivitas.
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            // Catat log sebelum sesi dihapus
            ActivityLog::record(
                'LOGOUT',
                'Admin '.Auth::user()->name.' logout dari sistem.'
            );
        }

        // Hapus status otentikasi pengguna
        Auth::logout();

        // Hancurkan session lama dan buat token CSRF baru demi keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('info', 'Berhasil logout.');
    }
}
