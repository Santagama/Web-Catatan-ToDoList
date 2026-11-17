<?php

// Mengimpor seluruh Controller yang menangani alur rute aplikasi
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Peta Rute URL Website Portofolio UMKM
|--------------------------------------------------------------------------
|
| File ini adalah peta navigasi utama aplikasi web.
| Setiap kali ada URL yang dibuka di browser (misal: /admin/dashboard atau /kopi-kita),
| file inilah yang bertugas mengarahkan URL tersebut ke Controller dan Method yang tepat.
|
*/

/*
|--------------------------------------------------------------------------
| 1. RUTE HALAMAN PUBLIK (Bebas Diakses Siapapun Tanpa Login)
|--------------------------------------------------------------------------
*/
// Halaman utama / Landing Page promosi jasa web builder
Route::get('/', [PublicController::class, 'landing'])->name('home');

/*
|--------------------------------------------------------------------------
| 2. RUTE TAMU / BELUM LOGIN (Middleware 'guest')
|--------------------------------------------------------------------------
| Khusus untuk admin yang BELUM login. Jika sudah login, otomatis dilarang masuk
| ke rute ini dan langsung dilempar ke dashboard.
*/
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    // Menampilkan halaman formulir login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Menerima submit data form login (POST)
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| 3. RUTE AREA TERPROTEKSI ADMIN (Middleware 'auth')
|--------------------------------------------------------------------------
| Seluruh rute di bawah ini dijaga ketat oleh satpam middleware 'auth'.
| Siapapun yang belum login jika mencoba membuka URL ini akan otomatis
| ditolak dan dialihkan ke halaman /admin/login.
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Keluar sistem (Logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Beranda Dashboard Admin (Menampilkan metrik ringkasan & 5 data terbaru)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // MANAJEMEN PORTOFOLIO UMKM (CRUD LENGKAP 7 RUTE OTOMATIS):
    // index (GET), create (GET), store (POST), show (GET), edit (GET), update (PUT/PATCH), destroy (DELETE)
    Route::resource('portfolios', PortfolioController::class);

    // Perpanjang masa aktif paket portofolio yang sudah habis (PUT)
    Route::put('/portfolios/{portfolio}/extend', [PortfolioController::class, 'extend'])->name('portfolios.extend');

    // API Cek Ketersediaan Slug secara Realtime via AJAX (GET)
    Route::get('/api/check-slug', [PortfolioController::class, 'checkSlug'])->name('api.check-slug');

    // Jejak Audit Log Aktivitas Admin (GET)
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

    // Pengaturan Akun Admin & Multi-User Admin:
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/admins', [SettingsController::class, 'storeAdmin'])->name('settings.admins.store');
    Route::delete('/settings/admins/{admin}', [SettingsController::class, 'destroyAdmin'])->name('settings.admins.destroy');
});

/*
|--------------------------------------------------------------------------
| 4. RUTE DINAMIS SLUG PORTOFOLIO UMKM (WAJIB DITARUH DI PALING BAWAH!)
|--------------------------------------------------------------------------
| Rute wildcard ini menangkap semua URL seperti "/nama-toko" atau "/kopi-kenangan".
| PENTING: Harus diletakkan di paling bawah agar tidak memakan/menabrak URL /admin di atasnya!
*/
Route::get('/{slug}', [PublicController::class, 'show'])
    ->name('portfolio.public')
    ->where('slug', '[a-z0-9\-]+'); // Regex: Hanya boleh huruf kecil, angka, dan tanda strip
