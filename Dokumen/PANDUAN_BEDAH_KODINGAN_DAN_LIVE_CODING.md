# Panduan Bedah Kodingan (Trace Code) & Contekan Live Coding Ujikom

**Nama Siswa**: Hanan Aria Santagama  
**Kelas**: XII RPL 1 — SMKN 1 Majalengka  
**Aplikasi**: CMS Web Builder Platform Portofolio UMKM  
**Tujuan Dokumen**: Panduan praktis saat wawancara dan demonstrasi sistem di depan penguji UKK. Dokumen ini memandu kamu mendemonstrasikan fitur di browser sambil membuka file dan baris kodingannya di VS Code, disertai skrip kata-kata penjelasan dan contekan live coding instan!

---

## 🌟 Cara Menggunakan Panduan Ini Saat Ujian

Saat penguji meminta kamu mendemonstrasikan sistem:
1. **Langkah 1 (Tampilkan di Browser)**: Buka fitur yang diminta di layar browser (`http://localhost:8000`).
2. **Langkah 2 (Buka Kodingannya di VS Code)**: Buka file dan baris yang tertulis di panduan ini.
3. **Langkah 3 (Ucapkan Kalimat Penjelas)**: Gunakan kalimat contekan yang sudah disiapkan di bawah. Penjelasanmu akan terdengar sangat profesional, terstruktur, dan paham alur kerja Laravel secara menyeluruh (Route $\rightarrow$ Middleware $\rightarrow$ Controller $\rightarrow$ Model $\rightarrow$ View).

```
[Browser Pengguna]
       │ (1. Klik / Request URL)
       ▼
[routes/web.php] (2. Menentukan URL mengarah ke Controller mana)
       │
       ▼
[Middleware] (3. Satpam pemeriksa: auth, guest, prevent-back)
       │
       ▼
[Controller] (4. Otak logika bisnis: validasi, hitungan, olah data)
       │
       ▼
[Model (Eloquent)] (5. Berkomunikasi dengan Database MySQL)
       │
       ▼
[View (Blade HTML)] (6. Desain tampilan Tailwind CSS disuntik data)
       │
       ▼
[Kembali ke Layar Browser Pengguna] (7. Tampilan interaktif selesai dirender)
```

---

## 🧭 Bab 1: Demonstrasi Halaman Landing Page Publik (`/`)

### 1. Aksi di Layar Browser:
- Buka alamat: `http://localhost:8000/`
- Tunjukkan Hero Section, kartu 6 contoh portofolio UMKM, 5 katalog template visual, dan tabel harga paket.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Pak Penguji, saat pengunjung membuka alamat root `/`, request pertama kali ditangkap oleh file rute `routes/web.php`. Di sana rute diarahkan ke `PublicController` method `landing()`. Controller mengambil data 6 UMKM terbaru yang statusnya sudah 'publish' dari database melalui Model `Portfolio`, lalu mengopernya ke file view Blade `landing.blade.php` untuk ditampilkan dengan rapi menggunakan Tailwind CSS."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L28-L29) (Baris 28–29)
   ```php
   Route::get('/', [PublicController::class, 'landing'])->name('home');
   ```
2. 📍 **Controller**: [app/Http/Controllers/PublicController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/PublicController.php#L26-L37) (Baris 26–37)
   ```php
   public function landing(): View
   {
       $showcasePortfolios = Portfolio::where('status', 'publish')
           ->latest('updated_at')
           ->take(6)
           ->get();

       return view('public.landing', compact('showcasePortfolios'));
   }
   ```
3. 📍 **View Blade**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L95-L130) (Looping data dengan `@foreach($showcasePortfolios as $item)`)

---

## 🔐 Bab 2: Demonstrasi Login Admin & Keamanan Sesi

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/admin/login`
- Ketik Username: `admin`, Password: `password`, lalu tekan tombol **"Masuk ke Dashboard"**.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Untuk masuk ke panel admin, kami memisahkan rutenya dengan middleware `guest`. Ketika admin submit form login, data dikirim lewat HTTP POST ke `AuthController` method `login()`. Sistem memvalidasi input, lalu mengecek kecocokan password dengan `Auth::attempt()` yang otomatis menggunakan enkripsi Hash Bcrypt. Setelah berhasil, sesi diregenerasi dengan `session()->regenerate()` untuk mencegah serangan Session Fixation, dan aktivitas login otomatis dicatat ke tabel `activity_logs`."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L38-L44) (Baris 38–44, dilindungi middleware `guest`)
2. 📍 **Controller**: [app/Http/Controllers/Admin/AuthController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/AuthController.php#L45-L98) (Baris 45–98, method `login()`)
   - **Validasi Input**: Baris 49–53 (`$request->validate(...)`)
   - **Pengecekan Kredensial**: Baris 57 (`if (Auth::guard('web')->attempt($credentials, $remember))`)
   - **Regenerasi Session**: Baris 60 (`$request->session()->regenerate()`)
   - **Catat Log Audit**: Baris 63–68 (`ActivityLog::create(['action' => 'LOGIN'])`)
3. 📍 **Model Admin**: [app/Models/Admin.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Models/Admin.php) (Mengimplementasikan `Authenticatable`)

---

## 📊 Bab 3: Demonstrasi Dashboard & Monitoring Kedaluwarsa

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/admin/dashboard`
- Tunjukkan 4 kartu statistik (Total, Publish, Draft, Expired) dan Banner Kuning Peringatan Kedaluwarsa $\le 3$ hari.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Di halaman Dashboard, seluruh metrik dihitung secara real-time oleh `DashboardController`. Menariknya, sistem ini memiliki fitur pendeteksi otomatis untuk portofolio yang masa aktifnya tersisa kurang dari atau sama dengan 3 hari. Data ini langsung dipicu ke kartu banner kuning di Blade agar admin tidak lupa mengingatkan klien untuk perpanjangan paket."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L58-L59) (Baris 58–59, dalam grup middleware `auth`)
2. 📍 **Controller**: [app/Http/Controllers/Admin/DashboardController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/DashboardController.php#L26-L68) (Baris 26–68)
   - **Hitung Status**: Baris 30–36 (`Portfolio::where('status', 'publish')->count()`)
   - **Deteksi Expired**: Baris 39–41 (`Portfolio::whereNotNull('expired_at')->where('expired_at', '<', now())->count()`)
   - **Eager Loading Log**: Baris 53–56 (`ActivityLog::with('admin')->orderByDesc('created_at')->take(5)->get()`)
3. 📍 **View Blade**: [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/dashboard.blade.php#L35-L65) (Bagian banner alert kuning dan grid kartu metrik)

---

## ✍️ Bab 4: Demonstrasi Form Input, Cek Slug AJAX & Penerbitan

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/admin/portfolios/create`
- Ketik Nama UMKM: misal `Kopi Sejahtera Majalengka`.
- Tunjukkan bahwa kolom **Slug** otomatis terisi `kopi-sejahtera-majalengka` dan muncul centang hijau *"Slug tersedia"*.
- Pilih template kartu, pilih file foto logo/banner (muncul live preview).
- Klik tombol **"+ Tambah Produk"** dua kali untuk membuktikan produk dinamis bisa ditambah tanpa reload halaman.
- Simpan portofolio.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Pada form input ini ada 3 fitur unggulan: Pertama, Auto-Slug berbasis JavaScript yang secara asinkron (AJAX) memeriksa ketersediaan URL ke rute `/admin/api/check-slug`. Kedua, live preview upload gambar. Ketiga, penambahan daftar produk secara dinamis. Saat tombol simpan diklik, `PortfolioController` method `store()` memproses upload file ke disk public, mengemas data array produk menjadi format JSON di database, dan mencatat aksi ke tabel audit log."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L63) (Baris 63 rute resource & Baris 69 rute API check-slug)
2. 📍 **Controller AJAX**: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L389-L415) (Baris 389–415, method `checkSlug()`)
   ```php
   public function checkSlug(Request $request): JsonResponse
   {
       $slug = Str::slug($request->query('title', ''));
       $exists = Portfolio::where('slug', $slug)->exists();
       return response()->json(['slug' => $slug, 'available' => ! $exists]);
   }
   ```
3. 📍 **Controller Simpan**: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L102-L185) (Baris 102–185, method `store()`)
   - **Validasi**: Baris 104–119
   - **Upload File**: Baris 126–134 (`$request->file('logo')->store('portfolios/logos', 'public')`)
   - **Kalkulasi Tanggal Expired**: Baris 144–154 (`match($paket)`)
   - **Simpan Data**: Baris 157–170 (`Portfolio::create([...])`)
   - **Catat Log**: Baris 173–179 (`ActivityLog::create(['action' => 'TAMBAH_PORTOFOLIO'])`)
4. 📍 **Model JSON Casting**: [app/Models/Portfolio.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Models/Portfolio.php#L45-L53) (Baris 45–53, casting otomatis JSON ke Array: `'products' => 'array'`)
5. 📍 **View Blade**: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php)

---

## 🚀 Bab 5: Demonstrasi Halaman Publik UMKM & Fitur SEO 301 Redirect

### 1. Aksi di Layar Browser:
- Buka salah satu portofolio: `http://localhost:8000/kopi-sejahtera`
- Tunjukkan tampilan template yang responsif, kartu produk, dan coba klik tombol **"Pesan via WhatsApp"** (format pesan chat WA langsung terisi otomatis).
- **Uji Coba SEO 301 Redirect**:
  - Di admin, ubah slug dari `kopi-sejahtera` menjadi `kopi-sejahtera-baru`.
  - Sekarang di tab baru, ketik slug lama: `http://localhost:8000/kopi-sejahtera`.
  - Tunjukkan ke penguji: Browser otomatis melakukan redirect permanen (301) ke alamat baru `http://localhost:8000/kopi-sejahtera-baru` tanpa error 404!

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Di bagian rute publik, kami menerapkan rute dinamis wildcard `/{slug}` yang diletakkan di baris paling bawah file `routes/web.php` agar tidak bentrok dengan rute admin. Di `PublicController`, sistem mengecek slug ke tabel `portfolios`. Jika tidak ditemukan, sistem tidak langsung melempar 404, melainkan mencari ke tabel riwayat `slug_histories`. Jika ditemukan riwayat pergantian nama, sistem langsung melakukan HTTP 301 Permanent Redirect ke URL baru. Ini menjaga skor SEO Google dan memastikan tautan lama di brosur/kemasan klien tidak pernah mati!"*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L88-L90) (Baris 88–90, rute paling bawah dengan regex `where('slug', '[a-z0-9\-]+')`)
2. 📍 **Controller**: [app/Http/Controllers/PublicController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/PublicController.php#L49-L90) (Baris 49–90, method `show($slug)`)
   - **Cek Tabel Utama**: Baris 52–76
   - **Pemilihan Template Fleksibel**: Baris 67–72 (`$viewName = 'public.templates.'.$portfolio->template_id`)
   - **Logika SEO 301 Redirect**: Baris 79–85
     ```php
     $history = SlugHistory::where('slug_lama', $slug)->latest('created_at')->first();
     if ($history) {
         return redirect()->to('/'.$history->slug_baru, 301);
     }
     ```
   - **Lempar 404**: Baris 89 (`abort(404);`)
3. 📍 **Template View**: [resources/views/public/templates/minuman.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/templates/minuman.blade.php) (dan template lainnya: `makanan`, `barang`, `tokoh`, `jasa`)

---

## ⏰ Bab 6: Demonstrasi Perpanjangan Paket & Auto-Drafting (Scheduler)

### 1. Aksi di Layar Browser & Terminal:
- Buka detail portofolio: `http://localhost:8000/admin/portfolios/1`
- Tunjukkan kartu perpanjangan paket, pilih "6 Bulan", klik **"Perpanjang Paket"**.
- Tunjukkan tanggal `expired_at` bertambah secara akurat.
- Buka terminal, jelaskan scheduler Laravel yang berjalan otomatis jam 00:00.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Untuk manajemen siklus hidup paket, kami memiliki method `extend()` di `PortfolioController` yang menghitung penambahan bulan dari tanggal kedaluwarsa terakhir menggunakan library Carbon. Selain itu, di file `routes/console.php`, kami membuat Task Scheduler otomatis yang dijalankan server setiap pukul 00:00 tengah malam. Scheduler ini mencari semua web yang tanggal expired-nya sudah terlewati, lalu secara otomatis mengubah statusnya dari 'publish' menjadi 'draft' dan mencatatnya ke audit log."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Controller Extend**: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L348-L380) (Baris 348–380, method `extend()`)
2. 📍 **Scheduler Otomatis**: [routes/console.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/console.php#L42-L65) (Baris 42–65)
   ```php
   Schedule::call(function () {
       $portfolioExpired = Portfolio::where('status', 'publish')
           ->whereNotNull('expired_at')
           ->where('expired_at', '<', now())
           ->get();

       foreach ($portfolioExpired as $portfolio) {
           $portfolio->update(['status' => 'draft']);
           ActivityLog::create([
               'admin_id' => $portfolio->admin_id,
               'portfolio_id' => $portfolio->id,
               'action' => 'AUTO_DRAFT',
               'description' => 'Paket portofolio "'.$portfolio->nama_umkm.'" otomatis dialihkan ke status draft oleh sistem scheduler.',
               'created_at' => now(),
           ]);
       }
   })->dailyAt('00:00');
   ```

---

## 🛡️ Bab 7: Demonstrasi Multi-Admin & Fitur Anti-Kudeta Super Admin

### 1. Aksi di Layar Browser:
- Buka menu Pengaturan: `http://localhost:8000/admin/settings`
- Tunjukkan tabel daftar admin. Pada baris akun Hanan (ID: 1), tunjukkan bahwa tombol hapusnya terkunci dengan badge *"Super Admin (Akun Utama)"*.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Aplikasi ini mendukung multi-user admin. Namun untuk mencegah kudeta akun atau ketidaksengajaan terhapusnya akun pemilik sistem, di `SettingsController` method `destroyAdmin()` kami memasang validasi proteksi ganda. Jika parameter ID admin bernilai 1, sistem akan memblokir aksi tersebut dan mengembalikan pesan error bahwa akun utama tidak boleh dihapus."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Controller**: [app/Http/Controllers/Admin/SettingsController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/SettingsController.php#L129-L145) (Baris 129–145, method `destroyAdmin()`)
   ```php
   public function destroyAdmin(Admin $admin): RedirectResponse
   {
       // Proteksi Anti-Kudeta: Akun ID 1 tidak boleh dihapus!
       if ($admin->id === 1) {
           return back()->with('error', 'Akun Utama tidak boleh dihapus!');
       }
       ...
   }
   ```
2. 📍 **View Blade**: [resources/views/admin/settings/index.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/settings/index.blade.php#L310-L340) (Kondisional `@if($adminItem->id === 1)` untuk mengunci tombol hapus)

---

## 🚪 Bab 8: Demonstrasi Logout & Pencegahan Tombol Back (PreventBackHistory)

### 1. Aksi di Layar Browser:
- Klik tombol merah **"Keluar (Logout)"**.
- Begitu berada di halaman login, tekan tombol **"Back" (Panah Kiri)** pada browser.
- Tunjukkan ke penguji: Layar **TIDAK** membuka kembali dashboard, melainkan tetap di halaman login!

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Kebanyakan aplikasi web rentan terhadap isu Back-Forward Cache (BFCache), di mana setelah logout, orang lain bisa menekan tombol panah 'Back' di browser dan melihat kembali data sensitif dashboard. Di aplikasi ini, kami mengamankannya dengan membuat middleware khusus `PreventBackHistory`. Middleware ini menyuntikkan header HTTP `Cache-Control: no-cache, no-store, must-revalidate` ke seluruh respon admin, sehingga browser dipaksa selalu meminta data baru ke server. Karena sesinya sudah dihapus, akses langsung ditolak."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Controller Logout**: [app/Http/Controllers/Admin/AuthController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/AuthController.php#L104-L123) (Baris 104–123, `invalidate()` & `regenerateToken()`)
2. 📍 **Middleware**: [app/Http/Middleware/PreventBackHistory.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Middleware/PreventBackHistory.php#L32-L50) (Baris 32–50, injeksi header HTTP No-Store)

---

# ⚡ CONTEKAN LIVE CODING INSTAN (SAAT UJI PETIK PENGUJI)

Gunakan bagian ini jika penguji tiba-tiba berkata:  
*"Coba Hanan, ganti warna tombol ini jadi biru/merah!"* atau *"Coba ubah batas upload-nya!"*

---

### 🎨 Trik 1: Mengubah Warna Tombol dalam 5 Detik

Seluruh file tampilan di `resources/views/` sudah kita pasangi komentar penanda mencolok `{{-- // UBAH WARNA TOMBOL INI... // --}}`. Kamu cukup tekan `Ctrl + F` di VS Code, ketik kata **`UBAH WARNA`**, lalu ganti kode warnanya!

#### Tabel Palet Warna Tailwind CSS v4:
| Warna yang Diminta | Class Latar Belakang (Background) | Class Hover | Class Shadow |
| :--- | :--- | :--- | :--- |
| **Teal (Default Web Kamu)** | `bg-teal-600` | `hover:bg-teal-700` | `shadow-teal-950/40` |
| **Biru (Blue)** | `bg-blue-600` | `hover:bg-blue-700` | `shadow-blue-950/40` |
| **Merah (Rose / Red)** | `bg-rose-600` | `hover:bg-rose-700` | `shadow-rose-950/40` |
| **Hijau (Emerald / Green)** | `bg-emerald-600` | `hover:bg-emerald-700` | `shadow-emerald-950/40` |
| **Ungu (Purple)** | `bg-purple-600` | `hover:bg-purple-700` | `shadow-purple-950/40` |
| **Kuning / Oranye (Amber)** | `bg-amber-600` | `hover:bg-amber-700` | `shadow-amber-950/40` |

#### Daftar Lokasi Tombol Penting:
1. **Tombol "Login Admin" di Navbar Landing Page**:
   - File: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L35) (~Baris 35)
2. **Tombol "Konsultasi & Buat Web" di Hero Landing Page**:
   - File: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L90) (~Baris 90)
3. **Tombol Submit Form Login Admin**:
   - File: [resources/views/admin/auth/login.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/auth/login.blade.php#L68) (~Baris 68)
4. **Tombol "+ Buat Web Baru" di Dashboard**:
   - File: [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/dashboard.blade.php#L19) (~Baris 19)
5. **Tombol "+ Tambah Produk" di Form Input**:
   - File: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L148) (~Baris 148)
6. **Tombol "Simpan Portofolio" di Form Input**:
   - File: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L246) (~Baris 246)
7. **Tombol "Simpan Perubahan" di Form Edit**:
   - File: [resources/views/admin/portfolios/edit.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/edit.blade.php#L249) (~Baris 249)
8. **Tombol "Perpanjang Paket" di Halaman Detail**:
   - File: [resources/views/admin/portfolios/show.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/show.blade.php#L142) (~Baris 142)
9. **Tombol "Kembali ke Beranda" di Halaman 404**:
   - File: [resources/views/errors/404.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/errors/404.blade.php#L35) (~Baris 35)

---

### 📦 Trik 2: Mengubah Batas Maksimal Upload Gambar

Jika penguji meminta: *"Batas upload gambar logo terlalu kecil (2MB), coba ubah jadi 5MB!"*

1. Buka file: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L106-L108) (di method `store()` baris 106–108 dan method `update()` baris 214–216).
2. Temukan aturan validasi gambar:
   ```php
   // Kode Asli (Maksimal 2048 KB = 2 Megabyte):
   'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
   'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
   ```
3. Ubah angkanya menjadi:
   ```php
   // Kode Baru (Maksimal 5120 KB = 5 Megabyte):
   'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
   'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
   ```
4. Simpan file (`Ctrl + S`). Langsung selesai!

---

### ⏱️ Trik 3: Menambah Pilihan Paket Baru (Misal: Paket 2 Tahun)

Jika penguji meminta: *"Coba tambahkan pilihan paket baru: Paket 2 Tahun!"*

1. **Langkah A (Tambahkan Opsi di View Create & Edit)**:
   - Buka: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L225)
   - Di dalam tag `<select name="paket">`, tambahkan satu baris `<option>`:
     ```html
     <option value="2_tahun" {{ old('paket') == '2_tahun' ? 'selected' : '' }}>Paket 2 Tahun (24 Bulan)</option>
     ```
2. **Langkah B (Tambahkan Logika Hitung di Controller)**:
   - Buka: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L145-L153)
   - Pada baris `match ($paket)`, tambahkan baris `'2_tahun'`:
     ```php
     $expiredAt = match ($paket) {
         '1_bulan' => $baseDate->copy()->addMonth(),
         '6_bulan' => $baseDate->copy()->addMonths(6),
         '1_tahun' => $baseDate->copy()->addYear(),
         '2_tahun' => $baseDate->copy()->addYears(2), // <-- Tambahan baru
         default => null,
     };
     ```
3. Selesai! Saat admin memilih paket 2 tahun, tanggal expired otomatis dihitung 24 bulan ke depan.

---

### 🚨 Trik 4: Menjawab Jebakan Soal "Popup Konfirmasi Hapus"

Jika penguji memintamu: *"Kenapa pas klik hapus langsung kehapus? Coba pasang popup konfirmasi dulu!"*

Jangan panik! Kita sudah menyiapkan 4 lokasi penanda khusus di mana kode popup konfirmasi siap dipasang:
1. **Konfirmasi Hapus di Tabel Portofolio**: [resources/views/admin/portfolios/index.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/index.blade.php#L181)
2. **Konfirmasi Hapus di Detail Portofolio**: [resources/views/admin/portfolios/show.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/show.blade.php#L80)
3. **Konfirmasi Hapus Admin di Pengaturan**: [resources/views/admin/settings/index.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/settings/index.blade.php#L330)
4. **Konfirmasi Logout di Sidebar**: [resources/views/layouts/admin.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/layouts/admin.blade.php#L110)

**Cara Cepat Menambahkannya (Solusi 1 Baris JavaScript Standar)**:
Tambahkan atribut `onsubmit="return confirm('Apakah Anda yakin?');"` pada tag `<form>`:
```html
<form action="..." method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```
*(Panduan lengkap popup desain modal Tailwind juga sudah tersedia di file [Dokumen/PANDUAN_DAN_CONTEKAN_POPUP_UJIKOM.md](file:///c:/laragon/www/CMSWebBuilder_Hanan/Dokumen/PANDUAN_DAN_CONTEKAN_POPUP_UJIKOM.md))*.

---

### 💡 Trik 5: Jawaban Cerdas untuk Pertanyaan Teori Penguji

| Pertanyaan Penguji | Jawaban Cerdas & Mantap Hanan |
| :--- | :--- |
| **"Kenapa pakai Tailwind CSS v4, apa kelebihannya?"** | *"Tailwind CSS v4 menggunakan engine performa tinggi berbasis Rust (Oxide) yang membuat proses build 10x lebih cepat, serta konfigurasi tema modern langsung di file CSS tanpa memerlukan file `tailwind.config.js` yang rumit."* |
| **"Di database tidak ada tabel `products`, tapi kok bisa simpan banyak produk?"** | *"Kami memanfaatkan fitur modern **JSON Column Casting** pada MySQL dan Laravel Eloquent (`'products' => 'array'`). Fitur ini memungkinkan data produk dinamis disimpan dalam 1 kolom JSON tanpa perlu query JOIN tabel anak yang membebani server, sangat ideal untuk katalog UMKM."* |
| **"Apa itu serangan CSRF dan bagaimana Laravel melindunginya?"** | *"CSRF (Cross-Site Request Forgery) adalah manipulasi request palsu dari pihak ketiga yang memanfaatkan sesi login pengguna. Laravel melindunginya secara otomatis melalui directive `@csrf` yang memverifikasi token rahasia sekali pakai pada setiap form POST."* |
| **"Kenapa rute `/{slug}` harus ditaruh paling bawah di `web.php`?"** | *"Karena `/{slug}` adalah rute dinamis wildcard. Jika diletakkan di atas, maka URL `/admin/dashboard` atau `/admin/login` akan dikira sebagai slug UMKM bernama 'admin', sehingga menu admin tidak akan bisa dibuka."* |
