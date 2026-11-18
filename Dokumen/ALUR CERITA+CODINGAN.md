# Panduan Bedah Kodingan (Trace Code) & Contekan Live Coding Ujikom

**Nama Siswa**: Hanan Aria Santagama  
**Kelas**: XII RPL 1 — SMKN 1 Majalengka  
**Aplikasi**: CMS Web Builder Platform Portofolio UMKM  
**Tujuan Dokumen**: Panduan praktis saat wawancara dan demonstrasi sistem di depan penguji UKK. Dokumen ini memandu kamu mendemonstrasikan fitur di browser sambil membuka file dan baris kodingannya di VS Code, disertai skrip kata-kata penjelasan yang mudah diucapkan dan contekan live coding instan!

---

## 🌟 Cara Menggunakan Panduan Ini Saat Ujian

Saat penguji meminta kamu mendemonstrasikan sistem:
1. **Langkah 1 (Tunjukkan di Layar Web)**: Buka fitur yang diminta di layar browser (`http://localhost:8000`).
2. **Langkah 2 (Buka Kodingannya di VS Code)**: Buka file dan baris yang tertulis di panduan ini.
3. **Langkah 3 (Ucapkan Skrip Penjelasan)**: Gunakan kalimat contekan yang sudah disiapkan di bawah. Penjelasanmu akan terdengar sangat profesional, terstruktur, dan paham alur kerja Laravel secara menyeluruh (Route $\rightarrow$ Middleware $\rightarrow$ Controller $\rightarrow$ Model $\rightarrow$ View).

```
[Browser Pengguna]
       │ (1. Klik tombol / Buka URL)
       ▼
[routes/web.php] (2. Menentukan URL diarahkan ke Controller mana)
       │
       ▼
[Middleware] (3. Satpam pemeriksa: auth, guest, prevent-back)
       │
       ▼
[Controller] (4. Otak logika bisnis: validasi form, hitung expired, olah data)
       │
       ▼
[Model (Eloquent)] (5. Berkomunikasi dengan Database MySQL)
       │
       ▼
[View (Blade HTML)] (6. Tampilan disuntik data dengan Tailwind CSS)
       │
       ▼
[Layar Browser] (7. Halaman website selesai dirender dan tampil rapi)
```

---

## 🧭 Bab 1: Demonstrasi Halaman Landing Page Publik (`/`)

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/`
- Tunjukkan Hero Section, 5 Katalog Desain Template, Showcase UMKM terdaftar, dan 2 Paket Layanan (Starter Rp 75.000 / 3 Bulan & Pro Bisnis Rp 200.000 / 1 Tahun).

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Pak Penguji, saat pengunjung membuka halaman utama `/`, rute ditangkap oleh file `routes/web.php` baris 29 yang mengarahkan ke `PublicController` method `landing()`. Di dalam Controller, sistem mengambil maksimal 6 data UMKM terbaru yang statusnya sudah 'publish' dari database melalui Model `Portfolio`, lalu mengirimkan datanya ke view Blade `resources/views/public/landing.blade.php` untuk ditampilkan secara responsif menggunakan Tailwind CSS."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L28-L29) (Baris 28–29)
   ```php
   Route::get('/', [PublicController::class, 'landing'])->name('home');
   ```
2. 📍 **Controller**: [app/Http/Controllers/PublicController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/PublicController.php#L26-L37) (Baris 26–37, method `landing()`)
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
3. 📍 **View Blade**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php) (Looping data kartu showcase dan tombol CTA WhatsApp)

---

## 🔐 Bab 2: Demonstrasi Login Admin & Keamanan Sesi

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/admin/login`
- Ketik Username: `admin`, Password: `password`, lalu tekan tombol **"Masuk ke Dashboard"**.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Untuk keamanan area admin, kami memisahkan rutenya dengan middleware `guest`. Ketika tombol login ditekan, data dikirim lewat HTTP POST ke `AuthController` method `login()`. Sistem memvalidasi input, lalu mengecek kecocokan password menggunakan `Auth::guard('web')->attempt()`. Begitu berhasil, sesi diregenerasi dengan `session()->regenerate()` untuk mencegah serangan Session Fixation, dan aktivitas login otomatis dicatat ke tabel `activity_logs`."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L38-L44) (Baris 38–44, dalam grup middleware `guest`)
2. 📍 **Controller**: [app/Http/Controllers/Admin/AuthController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/AuthController.php#L45-L98) (Baris 45–98, method `login()`)
   - **Validasi Input**: Baris 49–53 (`$request->validate(...)`)
   - **Cek Password Enkripsi Hash**: Baris 57 (`if (Auth::guard('web')->attempt($credentials, $remember))`)
   - **Regenerasi Session**: Baris 60 (`$request->session()->regenerate()`)
   - **Catat Log Audit**: Baris 63–68 (`ActivityLog::create(['action' => 'LOGIN'])`)

---

## 📊 Bab 3: Demonstrasi Dashboard & Peringatan Kedaluwarsa

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/admin/dashboard`
- Tunjukkan 4 kartu statistik (Total, Publish, Draft, Expired) dan Banner Kuning Peringatan Kedaluwarsa $\le 3$ hari.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Di halaman Dashboard, seluruh metrik dihitung secara real-time oleh `DashboardController`. Salah satu fitur penting di sini adalah pendeteksi otomatis untuk portofolio yang masa aktifnya tersisa $\le 3$ hari. Sistem langsung memunculkan banner peringatan kuning di atas layar agar admin bisa segera menghubungi pemilik UMKM untuk konfirmasi perpanjangan paket."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L58-L59) (Baris 58–59, dalam grup middleware `auth`)
2. 📍 **Controller**: [app/Http/Controllers/Admin/DashboardController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/DashboardController.php#L26-L68) (Baris 26–68)
   - **Hitung Status**: Baris 30–36 (`Portfolio::where('status', 'publish')->count()`)
   - **Deteksi Expired**: Baris 39–41 (`Portfolio::whereNotNull('expired_at')->where('expired_at', '<', now())->count()`)
   - **Eager Loading Log**: Baris 53–56 (`ActivityLog::with('admin')->orderByDesc('created_at')->take(5)->get()`)
3. 📍 **View Blade**: [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/dashboard.blade.php)

---

## ✍️ Bab 4: Demonstrasi Form Input & API Cek Slug Realtime

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/admin/portfolios/create`
- Ketik Nama UMKM: misal `Kopi Sejahtera`.
- Tunjukkan kolom **Slug** otomatis terisi `kopi-sejahtera` dan muncul centang hijau *"✓ Slug tersedia dan siap digunakan"*.
- Pilih template, upload foto logo/banner (tunjukkan live preview gambar).
- Klik tombol **"+ Tambah Produk"** 2 kali untuk membuktikan produk dinamis bertambah tanpa refresh.
- Pilih paket "3 Bulan (Trial 90 Hari)" dan status "Publish", lalu klik **"Simpan Portofolio"**.

### 2. Kalimat yang Kamu Ucapkan ke Penguji (Termasuk Penjelasan Rute API):
> *"Pada form input ini ada 3 fitur unggulan Pak:*
> 1. *Fitur **Auto-Slug Realtime**: Saat saya mengetik nama UMKM, JavaScript di browser otomatis mengirim pertanyaan ke rute `/api/check-slug`. Ini adalah **Internal API Endpoint** lokal buatan saya sendiri untuk mengecek ke database apakah URL tersebut sudah dipakai atau belum. Jika tersedia, langsung keluar centang hijau tanpa reload halaman.*
> 2. *Fitur **Live Image Preview** untuk logo dan banner.*
> 3. *Fitur **Daftar Produk Dinamis**: Admin bebas menambah produk sebanyak apapun. Di backend, data produk ini disimpan ke dalam satu kolom **JSON `products`**, sehingga struktur database tetap bersih dan kueri sangat cepat.*
> *Saat tombol simpan diklik, `PortfolioController` method `store()` meng-upload gambar, mengemas produk ke format JSON, menghitung tanggal expired sesuai paket yang dipilih, dan mencatat log audit."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route Cek Slug**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L69) (Baris 69, rute API internal)
2. 📍 **Controller Method Cek Slug**: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L389-L415) (Baris 389–415)
   ```php
   public function checkSlug(Request $request): JsonResponse
   {
       $slug = Str::slug($request->query('title', ''));
       $exists = Portfolio::where('slug', $slug)->exists();

       return response()->json([
           'slug' => $slug,
           'available' => ! $exists,
       ]);
   }
   ```
3. 📍 **Controller Method Simpan**: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L102-L185) (Baris 102–185, method `store()`)
   - **Upload File Gambar**: Baris 126–134
   - **Kalkulasi Tanggal Expired**: Baris 454–462 (`match ($paket) { '3_bulan' => now()->addMonths(3), '1_tahun' => now()->addYear(), ... }`)
   - **Simpan Data**: Baris 157–170 (`Portfolio::create([...])`)
   - **Catat Log**: Baris 173–179 (`ActivityLog::create(['action' => 'TAMBAH_PORTOFOLIO'])`)
4. 📍 **Model JSON Casting**: [app/Models/Portfolio.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Models/Portfolio.php#L45-L53) (Baris 48, `'products' => 'array'`)

---

## 🚀 Bab 5: Demonstrasi Halaman Publik UMKM & Fitur SEO 301 Redirect

### 1. Aksi di Layar Browser:
- Buka: `http://localhost:8000/kopi-sejahtera`
- Tunjukkan tampilan template minuman yang responsif, katalog menu, dan klik tombol **"Pesan via WhatsApp"** di salah satu produk (pesan chat WA otomatis terisi rapi).
- **Demo Fitur Canggih SEO 301 Redirect**:
  1. Di panel admin, klik Edit Kopi Sejahtera, ubah slug-nya menjadi `kopi-sejahtera-baru`, lalu simpan.
  2. Buka tab baru di browser, ketik link lama: `http://localhost:8000/kopi-sejahtera`.
  3. Tunjukkan ke penguji: Browser **TIDAK menampilkan 404**, melainkan otomatis mengalihkan (redirect 301) ke link baru `http://localhost:8000/kopi-sejahtera-baru`!

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Di bagian rute publik, rute wildcard `/{slug}` diletakkan di baris paling bawah file `routes/web.php` agar tidak memakan rute admin di atasnya. Di `PublicController` method `show()`, sistem mencari slug di tabel utama `portfolios`. Jika tidak ada, sistem mencari ke tabel riwayat `slug_histories`. Jika ditemukan riwayat ganti nama, sistem langsung melakukan HTTP 301 Moved Permanently ke URL baru. Ini menjaga ranking SEO di Google dan memastikan link lama yang tercetak di kemasan/stiker UMKM tidak pernah mati."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Route Dinamis Wildcard**: [routes/web.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/routes/web.php#L88-L90) (Baris 88–90, paling bawah)
2. 📍 **Controller**: [app/Http/Controllers/PublicController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/PublicController.php#L49-L90) (Baris 49–90, method `show($slug)`)
   - **Cek Portofolio Aktif**: Baris 52–65
   - **Pemilihan Template Blade**: Baris 67–75 (`$viewName = 'public.templates.'.$portfolio->template_id`)
   - **Logika Cerdas SEO 301 Redirect**: Baris 79–85
     ```php
     $history = SlugHistory::where('slug_lama', $slug)->latest('created_at')->first();
     if ($history) {
         return redirect()->to('/'.$history->slug_baru, 301);
     }
     ```
   - **Lempar 404**: Baris 89 (`abort(404);`)

---

## ⏰ Bab 6: Demonstrasi Perpanjangan Paket & Task Scheduler

### 1. Aksi di Layar Browser & Kodingan:
- Buka detail portofolio: `http://localhost:8000/admin/portfolios/1`
- Tunjukkan kartu perpanjangan paket: pilih opsi **"1 Tahun"**, klik **"Perpanjang Paket Sekarang"**.
- Tunjukkan tanggal `expired_at` bertambah 1 tahun ke depan dan statusnya otomatis tetap Publish.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Untuk manajemen langganan, kami menyediakan method `extend()` di `PortfolioController` yang menghitung penambahan masa aktif menggunakan library Carbon bawaan Laravel. Selain itu, di file `routes/console.php`, kami memiliki Task Scheduler otomatis yang dijalankan server setiap jam 00:00 tengah malam. Scheduler ini mencari semua toko yang tanggal kedaluwarsanya sudah lewat, lalu otomatis mengubah statusnya menjadi 'draft' agar tidak bisa diakses publik dan mencatatnya ke audit log."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Controller Extend**: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L348-L380) (Baris 348–380)
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

## 🛡️ Bab 7: Demonstrasi Multi-Admin & Proteksi Anti-Kudeta

### 1. Aksi di Layar Browser:
- Buka menu Pengaturan: `http://localhost:8000/admin/settings`
- Tunjukkan tabel daftar admin. Pada baris akun Hanan (ID: 1), tunjukkan tombol hapus terkunci dengan badge *"Super Admin (Akun Utama)"*.

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Aplikasi ini mendukung multi-user admin untuk membantu pembagian tugas input data. Namun untuk keamanan sistem, di `SettingsController` method `destroyAdmin()` kami memasang proteksi Anti-Kudeta. Akun dengan ID 1 dikunci dan tidak bisa dihapus oleh siapapun agar pemilik sistem selalu memiliki akses penuh."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Controller**: [app/Http/Controllers/Admin/SettingsController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/SettingsController.php#L129-L145) (Baris 129–145, method `destroyAdmin()`)
   ```php
   public function destroyAdmin(Admin $admin): RedirectResponse
   {
       if ($admin->id === 1) {
           return back()->with('error', 'Akun Utama tidak boleh dihapus!');
       }
       ...
   }
   ```

---

## 🚪 Bab 8: Demonstrasi Logout & Anti-Back History (PreventBackHistory)

### 1. Aksi di Layar Browser:
- Klik tombol **"Keluar (Logout)"**.
- Begitu berada di halaman login, tekan tombol **"Back" (Panah Kembali)** di browser.
- Tunjukkan ke penguji: Layar **TIDAK** kembali ke dashboard, melainkan tetap di halaman login!

### 2. Kalimat yang Kamu Ucapkan ke Penguji:
> *"Untuk mencegah data sensitif diintip orang lain setelah admin logout, kami membuat middleware khusus `PreventBackHistory`. Middleware ini menyuntikkan header HTTP `Cache-Control: no-cache, no-store, must-revalidate` ke seluruh respon admin, sehingga browser dipaksa meminta data baru ke server. Karena sesinya sudah dihapus, akses langsung ditolak."*

### 3. File yang Dibuka di VS Code:
1. 📍 **Controller Logout**: [app/Http/Controllers/Admin/AuthController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/AuthController.php#L104-L123) (Baris 104–123)
2. 📍 **Middleware**: [app/Http/Middleware/PreventBackHistory.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Middleware/PreventBackHistory.php#L32-L50) (Baris 32–50)

---

# ⚡ CONTEKAN LIVE CODING INSTAN (SAAT UJI PETIK PENGUJI)

Gunakan bagian ini jika penguji tiba-tiba meminta revisi kodingan langsung di tempat:

---

### 🎨 Trik 1: Mengubah Warna Tombol dalam 5 Detik

Seluruh file tampilan di `resources/views/` sudah kita pasangi komentar penanda mencolok `{{-- // UBAH WARNA TOMBOL INI... // --}}`. Kamu cukup tekan `Ctrl + F` di file tersebut, ketik **`UBAH WARNA`**, lalu ganti kodenya!

#### Tabel Kode Warna Tailwind CSS v4:
| Warna yang Diminta | Class Warna Latar (Background) | Class Hover |
| :--- | :--- | :--- |
| **Teal (Warna Asli Web)** | `bg-teal-600` | `hover:bg-teal-700` |
| **Biru (Blue)** | `bg-blue-600` | `hover:bg-blue-700` |
| **Merah (Rose / Red)** | `bg-rose-600` | `hover:bg-rose-700` |
| **Hijau (Emerald / Green)** | `bg-emerald-600` | `hover:bg-emerald-700` |
| **Ungu (Purple)** | `bg-purple-600` | `hover:bg-purple-700` |
| **Kuning / Oranye (Amber)** | `bg-amber-600` | `hover:bg-amber-700` |

#### Daftar Letak File Tombol Utama:
1. **Tombol "Login Admin" di Navbar Landing Page**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L54) (~Baris 54)
2. **Tombol "Pesan Website via WhatsApp" di Hero**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L114) (~Baris 114)
3. **Tombol Submit Login**: [resources/views/admin/auth/login.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/auth/login.blade.php#L68) (~Baris 68)
4. **Tombol "+ Buat Web Baru" di Dashboard**: [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/dashboard.blade.php#L19) (~Baris 19)
5. **Tombol "+ Tambah Produk" di Form Input**: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L210) (~Baris 210)
6. **Tombol "Simpan Portofolio"**: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L274) (~Baris 274)
7. **Tombol "Kembali ke Beranda" di Halaman 404**: [resources/views/errors/404.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/errors/404.blade.php#L35) (~Baris 35)

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
4. Tekan `Ctrl + S`. Selesai!

---

### ⏱️ Trik 3: Menambah Pilihan Paket Baru (Misal: Paket 2 Tahun)

Jika penguji meminta: *"Coba tambahkan pilihan paket baru: Paket 2 Tahun!"*

1. **Langkah A (Tambah Opsi di View Form)**:
   - Buka: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L256)
   - Di dalam tag `<select name="paket">`, tambahkan:
     ```html
     <option value="2_tahun" {{ old('paket') === '2_tahun' ? 'selected' : '' }}>2 Tahun (730 Hari)</option>
     ```
2. **Langkah B (Tambah Logika Hitung di Controller)**:
   - Buka: [app/Http/Controllers/Admin/PortfolioController.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/app/Http/Controllers/Admin/PortfolioController.php#L457-L461)
   - Pada baris `match ($paket)`, tambahkan baris `'2_tahun'`:
     ```php
     return match ($paket) {
         '3_bulan' => now()->addMonths(3),
         '1_tahun' => now()->addYear(),
         '2_tahun' => now()->addYears(2), // <-- Tambahan baru
         default => null,
     };
     ```
3. Selesai!

---

### 🚨 Trik 4: Menjawab Jebakan Soal "Popup Konfirmasi Hapus"

Jika penguji berkata: *"Kenapa pas klik hapus langsung kehapus? Coba pasang popup konfirmasi dulu!"*

Cukup tambahkan atribut `onsubmit="return confirm('Apakah Anda yakin?');"` pada tag `<form>` hapus atau logout tersebut:
```html
<form action="..." method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
    @csrf
    @method('DELETE')
    <button type="submit">Hapus</button>
</form>
```
*(Lokasi penanda komentar sudah disiapkan di file `index.blade.php`, `show.blade.php`, dan `settings/index.blade.php`)*.
