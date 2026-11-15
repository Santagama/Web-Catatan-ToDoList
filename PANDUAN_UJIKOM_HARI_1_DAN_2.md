# 📋 PANDUAN EKSEKUSI UJIKOM HARI KE-1 & HARI KE-2
**Nama Peserta**: Hanan Aria Santagama  
**Kelas / Jurusan**: XII RPL 1 — Rekayasa Perangkat Lunak  
**Judul Proyek**: Platform Web Portofolio UMKM (Done-For-You CMS Builder)

---

## ⚡ 1. JAWABAN RESMI: BISA DI LARAVEL 12?
> **JAWABAN: 100% SANGAT BISA DAN AMAN!**

### Mengapa Kode Ini Pasti Jalan di Laravel 12?
1. **Struktur Identik**: Laravel 11, Laravel 12, dan Laravel 13 menggunakan arsitektur modular yang sama persis:
   - Middleware & redirect dikonfigurasi di `bootstrap/app.php` (tanpa `Kernel.php` kuno).
   - Task Scheduler ditaruh langsung di `routes/console.php`.
   - Casting model menggunakan method `casts(): array`.
2. **Nol Library Pihak Ketiga (Zero External Dependencies)**:
   - Proyek ini **murni Laravel Core + Blade**.
   - Tidak memakai package aneh yang rentan konflik versi (tidak pakai Spatie, Inertia, Livewire, dll).
3. **Standar PSR & PHP 8.2+**:
   - Seluruh kode controller, model, migration, dan routes ditulis dengan standar modern PHP 8 yang didukung penuh oleh Laravel 12.

---

## 📅 2. CHECKLIST HARI KE-1: BASIS DATA & SETUP AWAL

### Langkah 1: Buat Proyek Baru di PC Sekolah
Buka terminal (Git Bash / Command Prompt / Laragon Terminal):
```bash
composer create-project laravel/laravel:^12.0 cms-webbuilder
cd cms-webbuilder
```

### Langkah 2: Konfigurasi Database di `.env`
Buka file `.env` di teks editor, sesuaikan nama database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_cmswebbuilderhanan
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan sudah membuat database `db_cmswebbuilderhanan` di phpMyAdmin / MySQL).*

### Langkah 3: Konfigurasi Guard & Provider di `config/auth.php`
> ⚠️ **SANGAT PENTING**: Jangan lupa langkah ini agar sistem login mencari data ke tabel `admins`, bukan tabel `users`.

Buka file `config/auth.php`, ubah bagian:
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'admins', // ganti 'users' menjadi 'admins'
    ],
],

'providers' => [
    'admins' => [
        'driver' => 'eloquent',
        'model' => env('AUTH_MODEL', App\Models\Admin::class), // arahkan ke Admin::class
    ],
],
```

### Langkah 4: Copy File Migrations
Copy 4 file migration dari proyek ini ke `database/migrations/`:
1. `..._create_admins_table.php` *(Tabel akun admin login)*
2. `..._create_portfolios_table.php` *(Tabel utama UMKM + kolom JSON products + text maps_embed_url)*
3. `..._create_activity_logs_table.php` *(Tabel audit trail aktivitas)*
4. `..._create_slug_histories_table.php` *(Tabel riwayat slug untuk SEO 301)*

### Langkah 5: Copy File Models
Copy 4 file model dari proyek ini ke `app/Models/`:
1. `app/Models/Admin.php` *(Extends Authenticatable + Relasi)*
2. `app/Models/Portfolio.php` *(Casting JSON array products + mapsEmbedUrl sanitizer)*
3. `app/Models/ActivityLog.php` *(Method helper ActivityLog::record())*
4. `app/Models/SlugHistory.php` *(Pencatat perubahan slug)*

### Langkah 6: Copy File Seeders
Copy 2 file seeder dari proyek ini ke `database/seeders/`:
1. `database/seeders/AdminSeeder.php` *(Akun default: username `hanan`, password `hanan123`)*
2. `database/seeders/DatabaseSeeder.php` *(Master seeder pemanggil AdminSeeder)*

### Langkah 7: Jalankan Migrasi, Seeder, dan Storage Link di Terminal
```bash
php artisan migrate --seed
php artisan storage:link
```
*Hasil:* Database langsung terbentuk lengkap dan akun admin siap digunakan.

---

## 📅 3. CHECKLIST HARI KE-2: BACKEND LOGIC & CONTROLLER

### Langkah 1: Copy Middleware Anti-Cache
Copy file:
`app/Http/Middleware/PreventBackHistory.php`

### Langkah 2: Daftarkan Middleware di `bootstrap/app.php`
Buka `bootstrap/app.php`, sesuaikan blok middleware:
```php
<?php

use App\Http\Middleware\PreventBackHistory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect otomatis
        $middleware->redirectTo(
            guests: '/admin/login',
            users: '/admin/dashboard',
        );

        // Mencegah cache browser setelah logout (Back-Button Protection)
        $middleware->web(append: [
            PreventBackHistory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
```

### Langkah 3: Copy Seluruh Controller Backend
Buat folder `app/Http/Controllers/Admin/` lalu copy file-file berikut:
1. `app/Http/Controllers/Admin/AuthController.php` *(Login, session regenerate, logout invalidate)*
2. `app/Http/Controllers/Admin/DashboardController.php` *(Statistik card & recent logs)*
3. `app/Http/Controllers/Admin/PortfolioController.php` *(CRUD, upload logo/banner/produk, AJAX check slug)*
4. `app/Http/Controllers/Admin/ActivityLogController.php` *(Audit trail log viewer)*
5. `app/Http/Controllers/Admin/SettingsController.php` *(Profil admin & ganti password)*
6. `app/Http/Controllers/PublicController.php` *(Penyaji landing & router slug publik + SEO 301)*

### Langkah 4: Copy File Routing & Scheduler
1. `routes/web.php` *(Seluruh rute admin terproteksi auth & rute publik /{slug})*
2. `routes/console.php` *(Task Scheduler otomatis auto-draft portofolio kadaluarsa)*

### Langkah 5: Uji Rute & Scheduler di Terminal
Jalankan perintah ini untuk memastikan tidak ada syntax error:
```bash
php artisan route:list
php artisan schedule:run
```
Jika daftar rute muncul dengan rapi, backend Hari 1-2 sudah **100% SUKSES!**

---

## 🗂️ 4. TABEL DAFTAR FILE YANG HARUS DICOPIKAN (HARI 1 & 2)

| Kategori | Lokasi File Asal | Lokasi Tujuan di PC Sekolah |
| :--- | :--- | :--- |
| **Konfigurasi** | `config/auth.php` | `config/auth.php` |
| **Bootstrap** | `bootstrap/app.php` | `bootstrap/app.php` |
| **Migrations** | `database/migrations/2026_11_12_134027_create_admins_table.php` | `database/migrations/` |
| | `database/migrations/2026_11_12_134034_create_portfolios_table.php` | `database/migrations/` |
| | `database/migrations/2026_11_12_134035_create_activity_logs_table.php` | `database/migrations/` |
| | `database/migrations/2026_11_12_134036_create_slug_histories_table.php` | `database/migrations/` |
| **Models** | `app/Models/Admin.php` | `app/Models/Admin.php` |
| | `app/Models/Portfolio.php` | `app/Models/Portfolio.php` |
| | `app/Models/ActivityLog.php` | `app/Models/ActivityLog.php` |
| | `app/Models/SlugHistory.php` | `app/Models/SlugHistory.php` |
| **Seeders** | `database/seeders/AdminSeeder.php` | `database/seeders/AdminSeeder.php` |
| | `database/seeders/DatabaseSeeder.php` | `database/seeders/DatabaseSeeder.php` |
| **Middleware**| `app/Http/Middleware/PreventBackHistory.php` | `app/Http/Middleware/` |
| **Controllers**| `app/Http/Controllers/Admin/AuthController.php` | `app/Http/Controllers/Admin/` |
| | `app/Http/Controllers/Admin/DashboardController.php` | `app/Http/Controllers/Admin/` |
| | `app/Http/Controllers/Admin/PortfolioController.php` | `app/Http/Controllers/Admin/` |
| | `app/Http/Controllers/Admin/ActivityLogController.php` | `app/Http/Controllers/Admin/` |
| | `app/Http/Controllers/Admin/SettingsController.php` | `app/Http/Controllers/Admin/` |
| | `app/Http/Controllers/PublicController.php` | `app/Http/Controllers/PublicController.php` |
| **Routing** | `routes/web.php` | `routes/web.php` |
| | `routes/console.php` | `routes/console.php` |

---

## 🎯 5. KUNCI JAWABAN & KISI-KISI TANYA JAWAB PENGUJI

### Q1: *"Mengapa menggunakan `Hash::make()` untuk password?"*
> **Jawaban Hanan**: *"Untuk menerapkan prinsip one-way hashing algoritma Bcrypt dengan salt acak. Password tidak disimpan dalam teks biasa (plain text), sehingga jika database bocor, password tetap aman dan tidak dapat dibaca oleh siapa pun."*

### Q2: *"Mengapa kolom `products` disimpan dalam format JSON di database?"*
> **Jawaban Hanan**: *"Karena jumlah produk UMKM bersifat dinamis (ada yang 1 produk, ada yang 5). Menggunakan tipe data JSON di MySQL yang dipadukan dengan fitur Attribute Casting Laravel (`'products' => 'array'`) memungkinkan kita menyimpan dan memanggil data array secara instan tanpa perlu query JOIN ke tabel tambahan, sehingga proses memuat halaman jauh lebih cepat dan efisien."*

### Q3: *"Apa kegunaan tabel `slug_histories` dan status HTTP 301?"*
> **Jawaban Hanan**: *"Ketika UMKM mengganti nama usaha atau URL slug-nya, tautan lama yang sudah tersebar di media sosial atau Google tidak akan rusak (tidak error 404). Sistem mencatat slug lama di tabel `slug_histories` dan otomatis mengalihkan pengunjung ke slug baru menggunakan HTTP 301 Permanent Redirect demi menjaga performa SEO."*

### Q4: *"Bagaimana Anda mencegah celah keamanan Back Button setelah Logout?"*
> **Jawaban Hanan**: *"Dengan membuat custom middleware `PreventBackHistory`. Middleware ini mengirimkan header HTTP `Cache-Control: no-cache, no-store, must-revalidate` ke browser. Hasilnya, browser tidak menyimpan salinan halaman admin di memori cache lokal (Bfcache), sehingga jika ada yang menekan tombol Back di browser setelah logout, server langsung menolak dan mengembalikannya ke halaman login."*

### Q5: *"Bagaimana sistem menangani input peta Google Maps dari admin?"*
> **Jawaban Hanan**: *"Di Model `Portfolio`, saya membuat mutator dan accessor `mapsEmbedUrl`. Jika admin menempelkan seluruh kode sematan HTML `<iframe src='...'>` dari Google Maps, sistem otomatis mengekstrak link URL murninya menggunakan Regular Expression (`preg_match`). Hal ini mencegah terjadinya error 404 atau tampilan web yang bertumpuk di dalam template."*

### Q6: *"Bagaimana cara kerja sistem penonaktifan portofolio yang sudah kadaluarsa?"*
> **Jawaban Hanan**: *"Saya membuat Task Scheduler di `routes/console.php`. Scheduler berjalan otomatis memeriksa kolom `expired_at`. Jika portofolio sudah melewati tanggal kadaluarsa, sistem mengubah statusnya menjadi `draft` dan mencatat peristiwa tersebut secara otomatis ke tabel `activity_logs`."*
