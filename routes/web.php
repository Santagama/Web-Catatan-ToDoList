<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Platform Web Portofolio UMKM
|--------------------------------------------------------------------------
|
| File ini mengatur pemetaan alamat URL yang diakses browser ke Controller
| yang sesuai, lengkap dengan proteksi middleware autentikasi session.
|
*/

/*
|--------------------------------------------------------------------------
| RUTE HALAMAN PUBLIK (DAPAT DIAKSES TANPA LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'landing'])->name('home');

/*
|--------------------------------------------------------------------------
| RUTE AUTENTIKASI ADMIN (TAMU / BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| RUTE TERPROTEKSI ADMIN (WAJIB LOGIN SESSION)
|--------------------------------------------------------------------------
| Seluruh rute di bawah ini dilindungi oleh middleware 'auth'.
| Pengunjung yang belum login otomatis dialihkan ke /admin/login.
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Portofolio UMKM (CRUD Lengkap)
    Route::resource('portfolios', PortfolioController::class);

    // Perpanjang masa aktif paket portofolio
    Route::put('/portfolios/{portfolio}/extend', [PortfolioController::class, 'extend'])->name('portfolios.extend');

    // API cek ketersediaan slug secara realtime (AJAX)
    Route::get('/api/check-slug', [PortfolioController::class, 'checkSlug'])->name('api.check-slug');

    // Log Aktivitas Audit
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

    // Pengaturan Akun Admin & Manajemen Admin Multi-User
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/admins', [SettingsController::class, 'storeAdmin'])->name('settings.admins.store');
    Route::delete('/settings/admins/{admin}', [SettingsController::class, 'destroyAdmin'])->name('settings.admins.destroy');
});

/*
|--------------------------------------------------------------------------
| RUTE DINAMIS SLUG PORTOFOLIO PUBLIK (HARUS DI PALING BAWAH!)
|--------------------------------------------------------------------------
| Rute ini menangkap semua URL /{slug} untuk menampilkan portofolio UMKM.
| PENTING: Taruh paling bawah agar tidak menimpa rute admin di atas!
*/
Route::get('/{slug}', [PublicController::class, 'show'])
    ->name('portfolio.public')
    ->where('slug', '[a-z0-9\-]+');
