# Catatan Dokumentasi: Folder Admin Controllers (`app/Http/Controllers/Admin/`)

---

## 1. Apa Fungsi Folder Ini? (Bahasa Santai)
Folder ini adalah markas besarnya para Controller yang mengurus **Area Panel Administrasi (Dashboard Admin)**. 
Semua controller di sini (kecuali halaman form login) dijaga ketat oleh satpam keamanan (*Middleware Auth*). Jadi orang luar yang belum login tidak akan bisa mengintip atau mengotak-atik data di dalamnya.

---

## 2. Alur Keamanan Saat Admin Masuk
```
Admin mengakses URL: /admin/...
           │
           ▼
Satpam (Middleware 'auth') memeriksa:
- Apakah admin sudah login?
  ├── BELUM: Ditendang otomatis ke /admin/login
  └── SUDAH: Dipersilakan masuk ke Controller yang dituju:
           │
           ├── AuthController      => Urusan Login & Logout
           ├── DashboardController => Urusan Angka Statistik & Metrik
           ├── PortfolioController => Urusan CRUD Website Portofolio UMKM
           ├── SettingsController  => Urusan Ganti Password & Manajemen Admin
           └── ActivityLogController=> Urusan Rekam Jejak Audit (Log Aktivitas)
```

---

## 3. Penjelasan Tiap Controller & Contekan Ujikom

### A. `AuthController.php` (Pengontrol Login & Logout)
*   **Fungsinya**: Mengurus pintu gerbang masuk dan keluar admin.
*   **Fitur Keamanan Keren**:
    1.  *Proteksi Brute-Force*: Batasi maksimal 5x salah ketik password. Jika lebih, dikunci sementara selama 60 detik menggunakan `RateLimiter`.
    2.  *Anti-Session Fixation*: Setiap kali login berhasil, ID sesi browser diganti baru (`$request->session()->regenerate()`) agar tidak bisa dibajak hacker.
    3.  *Auto-Audit Log*: Saat login dan logout, sistem otomatis mencatat nama admin dan jam kejadiannya ke tabel `activity_logs`.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"AuthController kami lengkapi dengan Rate Limiting 5 percobaan untuk menangkal serangan Brute-Force, serta Session ID Regeneration untuk mencegah ancaman Session Hijacking."*

---

### B. `DashboardController.php` (Pengontrol Statistik)
*   **Fungsinya**: Menghitung dan menyajikan data metrik ringkasan di halaman beranda admin.
*   **Data yang Dihitung**:
    *   Total UMKM, jumlah yang Publish vs Draft.
    *   Jumlah UMKM yang masa aktif paketnya sudah kadaluarsa (`expired_at < now()`).
    *   5 portofolio yang baru saja dibuat/diupdate.
    *   5 aktivitas admin terbaru menggunakan Eager Loading `with('admin')` agar hemat query database.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Dashboard kami menyajikan metrik operasional secara realtime, termasuk sistem peringatan otomatis untuk paket UMKM yang telah melewati batas kedaluwarsa."*

---

### C. `PortfolioController.php` (Jantung Aplikasi - CRUD Portofolio)
*   **Fungsinya**: Pusat segala urusan Create, Read, Update, Delete portofolio UMKM.
*   **Fitur-Fitur Andalan**:
    1.  *Validasi Ketat*: Cek slug unik, batasan ukuran logo maksimal 2MB, banner maksimal 5MB.
    2.  *Array Produk JSON*: Mengunggah banyak foto produk sekaligus dan menyimpannya rapi dalam satu kolom JSON `products`.
    3.  *SEO 301 Permanent Redirect*: Kalau nama/slug UMKM diganti saat diedit, slug lama otomatis dicatat ke tabel `slug_histories` agar pelanggan lama tidak nyasar ke 404!
    4.  *Pembersihan File Otomatis*: Saat portofolio atau foto diganti/dihapus, file lama di folder storage langsung dihapus permanen (`Storage::disk('public')->delete(...)`) agar harddisk server tidak penuh sampah.
    5.  *Perpanjang Paket*: Fitur `extend()` untuk menambah durasi aktif 3 bulan atau 1 tahun.
    6.  *Cek Slug Realtime*: API `checkSlug()` berbasis AJAX, sehingga saat admin mengetik nama usaha, ketersediaan slug langsung dicek tanpa perlu reload halaman!
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"PortfolioController ini mengintegrasikan upload multimedia dengan fitur pembersihan storage otomatis, serta mendukung fitur SEO 301 Redirect yang merekam riwayat perubahan URL secara otomatis ke tabel slug_histories."*

---

### D. `SettingsController.php` (Pengaturan & Multi-User Admin)
*   **Fungsinya**: Mengatur profil admin aktif, ganti kata sandi lama ke baru, serta menambah atau menghapus user admin.
*   **2 Lapis Proteksi Istimewa**:
    1.  *Anti-Kudeta*: Akun Admin Utama ID 1 (Founder / Hanan) dikunci permanen di level codingan (`if ($admin->id === 1)`), tidak bisa dihapus oleh siapapun!
    2.  *Anti-Self Delete*: Admin yang sedang aktif login tidak boleh menghapus akunnya sendiri.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Di SettingsController kami terapkan prinsip keamanan RBAC dengan proteksi anti-kudeta untuk Admin Utama (ID 1) dan larangan self-delete agar sistem tidak pernah kehilangan akun pengelola aktif."*

---

### E. `ActivityLogController.php` (Jejak Audit Aktivitas)
*   **Fungsinya**: Menampilkan catatan sejarah seluruh aktivitas sistem dalam bentuk linimasa (*timeline*).
*   **Fitur**:
    *   Bisa difilter berdasarkan bulan dan tahun.
    *   Tersedia kartu ringkasan total aksi tambah, edit, dan hapus di bulan berjalan.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Modul Activity Log ini kami sediakan untuk menjamin akuntabilitas dan transparansi, sehingga setiap perubahan data dapat dilacak sampai ke level admin pelakunya."*
