# Catatan Dokumentasi: Folder Admin Controllers (`app/Http/Controllers/Admin/`)

---

## [FUNGSI]
Folder ini khusus menampung controller untuk **Area Panel Administrasi (Dashboard Admin)**. Semua controller di dalam folder ini (kecuali form login) dilindungi oleh middleware keamanan session `auth` agar tidak dapat diakses oleh pihak luar tanpa login resmi.

---

## [ALUR SISTEM / USER FLOW]
```
Admin mengakses URL /admin/*
           │
           ▼
Middleware auth memeriksa apakah session login valid
├── Jika Belum Login: Dialihkan otomatis ke /admin/login
└── Jika Sudah Login: Diizinkan masuk ke Controller terkait
           │
           ▼
1. Login/Logout     => Diproses oleh AuthController
2. Ringkasan Angka  => Diproses oleh DashboardController
3. Kelola Portofolio=> Diproses oleh PortfolioController
4. Audit Trail Log  => Diproses oleh ActivityLogController
5. Ganti Password   => Diproses oleh SettingsController
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `AuthController.php`
*   **Fungsi**: Mengelola alur masuk (*login*) dan keluar (*logout*) akun admin.
*   **Method Utama**:
    *   `showLoginForm()`: Menampilkan view `admin.auth.login`. Jika admin sudah terotentikasi, otomatis dialihkan ke dashboard.
    *   `login()`: Memvalidasi input, memverifikasi kecocokan username dan hash Bcrypt via `Auth::attempt()`, meregenerasi session ID (`$request->session()->regenerate()`), dan mencatat aksi ke tabel `activity_logs`.
    *   `logout()`: Mencatat log keluar, memanggil `Auth::logout()`, mematikan session (`invalidate()`), dan membuat CSRF token baru.

### 2. `DashboardController.php`
*   **Fungsi**: Menghitung dan menyajikan data statistik ke halaman beranda admin.
*   **Method Utama**:
    *   `index()`: Menghitung total portofolio, portofolio publish, portofolio draft, dan mendeteksi portofolio yang sudah kadaluarsa (`expired_at < now()`). Mengambil 5 portofolio teranyar dan 5 rekam aktivitas audit terbaru.

### 3. `PortfolioController.php`
*   **Fungsi**: Pusat logika CRUD (Create, Read, Update, Delete) portofolio UMKM.
*   **Method Utama**:
    *   `index()`: Menampilkan daftar seluruh portofolio dengan fitur pencarian nama/slug, filter tab status (Semua, Publish, Draft), dan pagination.
    *   `create()`: Menampilkan form tambah website portofolio baru beserta 5 pilihan template.
    *   `store()`: Memvalidasi input (keaslian slug, tipe gambar, max size), mengunggah logo, banner, serta array dinamis foto produk ke `public/storage`, menghitung masa aktif paket (3 bulan, 1 tahun, tanpa batas), mencatat riwayat ke `activity_logs`, dan menyimpan data.
    *   `edit()`: Menampilkan form edit yang telah terisi data portofolio lama via `old()`.
    *   `update()`: Memperbarui data portofolio. Jika slug diubah, secara cerdas mendeteksi perubahan lalu mencatatnya ke tabel `slug_histories` agar URL lama otomatis dialihkan (HTTP 301 Permanent Redirect).
    *   `destroy()`: Menghapus data portofolio dan otomatis menghapus seluruh file logo, banner, dan foto produk terkait dari folder storage agar server tidak penuh sampah (*disk cleanup*).
    *   `extend()`: Memperpanjang masa aktif paket portofolio yang kadaluarsa.
    *   `checkSlug()`: API endpoint AJAX untuk mengecek ketersediaan slug secara realtime saat admin mengetik nama usaha di form.

### 4. `ActivityLogController.php`
*   **Fungsi**: Menampilkan riwayat log audit seluruh aktivitas perubahan sistem (Login, Logout, Tambah, Edit, Hapus, Auto-Draft).
*   **Method Utama**:
    *   `index()`: Menampilkan data log aktivitas dengan filter berdasarkan aksi atau bulan/tahun.

### 5. `SettingsController.php`
*   **Fungsi**: Mengelola pengaturan akun login admin pengelola sistem.
*   **Method Utama**:
    *   `index()`: Menampilkan profil admin yang sedang login dan status koneksi sistem (Database, Storage, Engine).
    *   `update()`: Memperbarui nama admin, username unik, dan opsional mengganti password baru dengan enkripsi Bcrypt hash.

