<?php

namespace App\Http\Controllers\Admin;

// Mengimpor class Controller dasar, Model ActivityLog, dan fasilitas Auth Laravel
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * AuthController (Pengontrol Autentikasi Masuk & Keluar Admin)
 *
 * Bertanggung jawab menangani alur keamanan login dan logout:
 * - Menampilkan formulir login admin.
 * - Memverifikasi username dan password terenkripsi.
 * - Melindungi sistem dari serangan Brute-Force (penebakan password berulang).
 * - Mencegah serangan Session Fixation dengan regenerasi Session ID.
 * - Mencatat otomatis log audit masuk/keluar ke tabel activity_logs.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan halaman formulir login admin.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        // Pengecekan awal: Jika admin ternyata SUDAH dalam posisi login,
        // jangan biarkan dia membuka form login lagi, langsung lempar ke dashboard!
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Tampilkan halaman view resources/views/admin/auth/login.blade.php
        return view('admin.auth.login');
    }

    /**
     * Memproses verifikasi username dan password saat tombol Login ditekan.
     */
    public function login(Request $request): RedirectResponse
    {
        // 1. VALIDASI INPUT FORM: Pastikan input username dan password tidak dibiarkan kosong
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. PROTEKSI BRUTE-FORCE: Batasi maksimal 5 kali percobaan login gagal dari 1 IP per menit
        $throttleKey = Str::transliterate(Str::lower($request->input('username')).'|'.$request->ip());

        // Cek apakah user ini sudah gagal mencoba lebih dari 5 kali?
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            // Hitung sisa berapa detik lagi dia harus menunggu hukuman selesai
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('username')) // Ingat username yang diketik
                ->withErrors([
                    'username' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi dalam '.$seconds.' detik.',
                ]);
        }

        // 3. PROSES AUTENTIKASI: Cocokkan username dan hash password dengan data di tabel admins
        if (Auth::attempt($credentials)) {
            // Kalau login berhasil, reset/bersihkan pencatat hukuman rate limiter
            RateLimiter::clear($throttleKey);

            // KEAMANAN SIBER: Mencegah Session Fixation dengan membuat ID sesi baru yang segar
            $request->session()->regenerate();

            // Catat ke tabel riwayat audit bahwa admin ini berhasil login
            ActivityLog::record(
                'LOGIN',
                'Admin '.Auth::user()->name.' berhasil masuk ke dashboard sistem.'
            );

            // Alihkan admin ke halaman yang ingin dituju sebelumnya, atau default ke dashboard
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        // 4. JIKA LOGIN GAGAL: Tambah 1 catatan kegagalan (kunci selama 60 detik jika sudah 5x)
        RateLimiter::hit($throttleKey, 60);

        // Kembalikan ke form login dengan pesan kesalahan
        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    /**
     * Memproses keluar sistem (Logout) dan membersihkan seluruh sesi.
     */
    public function logout(Request $request): RedirectResponse
    {
        // 1. Jika masih ada data admin yang aktif, catat log dulu sebelum sesinya dihancurkan
        if (Auth::check()) {
            ActivityLog::record(
                'LOGOUT',
                'Admin '.Auth::user()->name.' logout dari sistem.'
            );
        }

        // 2. Cabut status otentikasi login admin dari Laravel Auth Guard
        Auth::logout();

        // 3. KEAMANAN SESSION: Hancurkan seluruh data sesi di memori server
        $request->session()->invalidate();

        // 4. KEAMANAN CSRF: Buat token keamanan CSRF baru agar token lama tidak bisa dibajak
        $request->session()->regenerateToken();

        // 5. Kembalikan admin ke halaman login dengan pesan informasi
        return redirect()->route('admin.login')
            ->with('info', 'Berhasil logout.');
    }
}
