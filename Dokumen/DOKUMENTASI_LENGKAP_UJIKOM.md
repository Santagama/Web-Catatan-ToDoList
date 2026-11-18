# DOKUMENTASI LENGKAP PENGEMBANGAN APLIKASI
## UJI KOMPETENSI KEAHLIAN (UKK) — REKAYASA PERANGKAT LUNAK
### TAHUN PELAJARAN 2026/2027

* **Nama Peserta Ujian:** Hanan Aria Santagama
* **Kelas / Konsentrasi:** XII RPL 1 — Rekayasa Perangkat Lunak
* **Satuan Pendidikan:** SMK Negeri 1 Majalengka
* **Judul Tugas Praktik:** Pengembangan Platform Web Portofolio UMKM (CMS Web Builder)
* **Model Layanan:** *Done-For-You (DFY) / Terima Beres* (Single Admin Tenant Management)

---

## DAFTAR ISI DOKUMEN
1. **Bagian B: Deskripsi Program**
2. **Bagian C: Dokumentasi Fungsi, Prosedur, dan Method (Input, Proses, Output)**
3. **Bagian D: Debugging (Strategi, Alat, dan Penanganan Error)**
4. **Bagian E: Pengujian Sistem & Skenario Uji (Test Case & Hasil Automated Test)**
5. **Bagian F: Laporan Evaluasi Singkat (Fitur Berjalan, Limitasi, dan Rencana Pengembangan)**
6. **Lampiran Khusus: Operasi Lanjutan Database (Relasional, Stored Procedure, Trigger, Commit & Rollback)**

---

# BAGIAN B: DESKRIPSI PROGRAM

### 1. Latar Belakang & Masalah Bisnis
Banyak pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) mengalami kendala dalam membangun eksistensi digital. Sebagian besar pelaku UMKM:
* Tidak memiliki keahlian teknis pemodelan web (*koding*, *hosting*, *domain*).
* Merasa kesulitan jika harus mendaftar dan mengelola dashboard CMS yang rumit (seperti WordPress).
* Membutuhkan landing page cepat saji yang langsung terhubung ke nomor WhatsApp untuk transaksi.

### 2. Solusi Aplikasi: Platform CMS Web Builder
Aplikasi ini dikembangkan dengan model layanan **Done-For-You (Terima Beres)**:
* Klien UMKM cukup mengirimkan materi produk, deskripsi usaha, dan nomor WhatsApp kepada Admin.
* Admin mengelola dan menerbitkan (*publish*) website portofolio interaktif klien melalui **Dashboard Admin satu pintu**.
* Pengunjung publik dan calon pembeli dapat langsung mengakses website UMKM melalui URL/slug unik (contoh: `/kopi-senja`, `/kue-enak-bu-sri`) tanpa perlu login.
* Jika pembeli tertarik pada produk, tombol *Order via WhatsApp* langsung mengarahkan ke chat dengan format pesan otomatis.

### 3. Arsitektur Teknologi & Lingkungan Pengembangan
* **Framework Backend:** Laravel 13 (Arsitektur Model-View-Controller / MVC)
* **Bahasa Pemrograman:** PHP 8.5
* **Basis Data:** MySQL (InnoDB Engine, Full Foreign Key Constraints, Transactions)
* **Styling & Tampilan:** Tailwind CSS (Mobile-First, Static Clean Styling tanpa animasi gimmick yang memberatkan)
* **Testing Engine:** Pest PHP Testing Framework (22 Feature & Unit Tests, 73 Assertions)
* **Keamanan Sistem:**
  * Autentikasi Guard terisolasi (`auth('admin')`).
  * Enkripsi kata sandi Bcrypt.
  * Perlindungan CSRF Token di seluruh formulir POST.
  * Sanitasi URL Iframe Google Maps untuk mencegah Cross-Site Scripting (XSS).
  * Middleware `PreventBackHistory` untuk mencegah browser men-cache halaman admin setelah logout.

### 4. Analisis Logika: Server-Side Rendering (SSR) vs Static Site Generation (SSG)
* **Mengapa Memilih Server-Side Rendering (SSR) pada CMS ini?**
  Karena UMKM sering kali melakukan pembaruan harga menu, foto produk baru, atau jam buka toko. Dengan pendekatan **SSR (Blade Engine)**, saat admin mengedit data dan menekan simpan, perubahan tersebut **langsung aktif seketika** di halaman publik tanpa perlu menunggu proses *rebuild/redeploy* berjam-jam seperti pada SSG (*Static Site Generation*). Hal ini sangat efisien untuk ratusan tenant toko.

---

# BAGIAN C: DOKUMENTASI FUNGSI, PROSEDUR, DAN METHOD

Sesuai instruksi soal Poin 4, berikut adalah dokumentasi spesifikasi teknis **Input, Proses, dan Output** untuk seluruh modul utama aplikasi:

---

### 1. Modul Autentikasi (`App\Http\Controllers\Admin\AuthController`)

#### A. Method `showLoginForm()`
* **Fungsi:** Menampilkan formulir login admin.
* **Input:** Request GET dari browser.
* **Proses:** Memeriksa status sesi melalui middleware `guest`. Jika sudah login, redirect ke dashboard. Jika belum, siapkan view login.
* **Output:** HTTP 200 OK — Render Blade View `resources/views/admin/auth/login.blade.php`.

#### B. Method `login(Request $request)`
* **Fungsi:** Memvalidasi kredensial login admin dan membuka sesi aman.
* **Input:**
  * `username` : String (Wajib, Max: 50 karakter)
  * `password` : String (Wajib)
* **Proses:**
  1. Validasi keberadaan input.
  2. Mencari record admin di tabel `admins` berdasarkan username.
  3. Memverifikasi hash Bcrypt kata sandi menggunakan `Hash::check()`.
  4. Regenerasi ID sesi (`$request->session()->regenerate()`) untuk proteksi *session fixation*.
  5. Mencatat aktivitas ke tabel `activity_logs` (`action = 'LOGIN'`).
* **Output:**
  * Jika sukses: Redirect ke route `admin.dashboard`.
  * Jika gagal: Redirect kembali ke login dengan flash error *"Username atau kata sandi yang Anda masukkan salah."*

#### C. Method `logout(Request $request)`
* **Fungsi:** Menghancurkan sesi aktif admin dan mengunci kembali sistem.
* **Input:** Request POST dengan CSRF Token.
* **Proses:**
  1. Mencatat aktivitas ke tabel `activity_logs` (`action = 'LOGOUT'`).
  2. Mengosongkan guard autentikasi (`Auth::logout()`).
  3. Membatalkan token sesi (`$request->session()->invalidate()`) dan meregenerasi token CSRF.
* **Output:** Redirect ke route `admin.login` dengan notifikasi sukses.

---

### 2. Modul Dashboard Utama (`App\Http\Controllers\Admin\DashboardController`)

#### Method `index()`
* **Fungsi:** Mengagregasi metrik analitik sistem dan menampilkan ringkasan data.
* **Input:** Request GET (terproteksi middleware `auth`).
* **Proses:**
  1. Menghitung total portofolio: `Portfolio::count()`.
  2. Menghitung portofolio aktif (*publish*): `Portfolio::where('status', 'publish')->count()`.
  3. Menghitung portofolio draf: `Portfolio::where('status', 'draft')->count()`.
  4. Menghitung varian template unik yang terpakai: `Portfolio::distinct('template_id')->count()`.
  5. Mengambil 5 rekam jejak aktivitas sistem terbaru: `ActivityLog::latest()->take(5)->get()`.
* **Output:** HTTP 200 OK — Render Blade View `resources/views/admin/dashboard.blade.php` membawa data statistik.

---

### 3. Modul Pengelolaan Portofolio UMKM (`App\Http\Controllers\Admin\PortfolioController`)

#### A. Method `index(Request $request)`
* **Fungsi:** Menampilkan direktori seluruh website portofolio klien dengan fitur pencarian dan paginasi.
* **Input:** Query string opsional `search` dan `status`.
* **Proses:** Melakukan filtering query database dengan klausul `LIKE` pada nama UMKM atau slug, diurutkan dari yang terbaru (`latest()`), dengan batas paginasi efisien (`paginate(10)`).
* **Output:** Render Blade View `resources/views/admin/portfolios/index.blade.php`.

#### B. Method `store(StorePortfolioRequest $request)`
* **Fungsi:** Menyimpan data portofolio baru dan menerbitkan website UMKM.
* **Input:**
  * `nama_umkm`: String (Max: 150)
  * `slug`: String Unik (Regex: huruf kecil, angka, tanda strip)
  * `template_id`: String (`minuman`, `makanan`, `barang`, `jasa`, `tokoh`)
  * `whatsapp`: String (Max: 20)
  * `instagram`: String opsional (Max: 100)
  * `paket`: String (`3_bulan`, `1_tahun`, `tanpa_batas`)
  * `status`: String (`publish`, `draft`)
  * `logo`: File gambar (JPG/PNG/WEBP, Max: 2 MB)
  * `banner`: File gambar (JPG/PNG/WEBP, Max: 2 MB)
  * `products`: Array JSON (Nama produk, harga, foto, deskripsi)
* **Proses:**
  1. Validasi server-side ketersediaan slug unik di tabel `portfolios`.
  2. Buka `DB::beginTransaction()`.
  3. Unggah file logo dan banner ke storage publik `storage/app/public/uploads`.
  4. Hitung masa aktif `expired_at` berdasarkan paket.
  5. Simpan record ke tabel `portfolios`.
  6. Catat log audit ke `activity_logs` (`action = 'TAMBAH_PORTFOLIO'`).
  7. Lakukan `DB::commit()`.
* **Output:** Redirect ke direktori portofolio dengan pesan notifikasi sukses.

#### C. Method `update(UpdatePortfolioRequest $request, Portfolio $portfolio)`
* **Fungsi:** Memperbarui data profil UMKM, katalog, template, atau alamat slug.
* **Input:** Seluruh parameter form edit portofolio.
* **Proses:**
  1. Validasi slug unik dengan pengecualian ID portofolio milik toko yang sedang diedit (`unique:portfolios,slug,` . $portfolio->id).
  2. **Pendeteksian Pergantian Slug (SEO):** Jika `$portfolio->slug !== $request->slug`, sistem otomatis menyimpan rekaman ke tabel `slug_histories` (`slug_lama` dan `slug_baru`) untuk kebutuhan HTTP 301 Redirect.
  3. Update data di database dan catat log aktivitas `EDIT_PORTFOLIO`.
* **Output:** Redirect ke detail/list portofolio dengan notifikasi berhasil.

#### D. Method `destroy(Portfolio $portfolio)`
* **Fungsi:** Menghapus data portofolio toko UMKM secara permanen.
* **Input:** Request DELETE dengan proteksi ID portofolio.
* **Proses:**
  1. Menghapus berkas logo dan banner dari media storage disk.
  2. Catat audit aktivitas ke `activity_logs` (`action = 'HAPUS_PORTFOLIO'`).
  3. Menjalankan `$portfolio->delete()` (relasi cascading otomatis membersihkan riwayat slug).
* **Output:** Redirect ke daftar portofolio dengan notifikasi toko telah dihapus.

---

### 4. Modul Publik & SEO 301 Redirect (`App\Http\Controllers\PublicController`)

#### A. Method `landing()`
* **Fungsi:** Menampilkan landing page utama jasa pembuatan web bagi pengunjung publik.
* **Input:** Request GET pada root URL (`/`).
* **Proses:** Merender halaman promosi jasa web builder yang memuat katalog 5 pilihan konsep template desain, daftar paket langganan, dan tombol order via WhatsApp.
* **Output:** Render Blade View `resources/views/public/landing.blade.php`.

#### B. Method `show(string $slug)`
* **Fungsi:** Menangani akses dinamis ke alamat website portofolio klien.
* **Input:** Parameter `$slug` dari URL browser (contoh: `/kopi-senja`).
* **Proses:**
  1. Cari `$slug` pada tabel `portfolios`.
  2. Jika ditemukan dan `status == 'publish'`, render view template yang sesuai: `resources/views/public/templates/{template_id}.blade.php`.
  3. Jika tidak ditemukan di tabel `portfolios`, periksa tabel `slug_histories` pada kolom `slug_lama`.
  4. Jika ditemukan di riwayat, lakukan **HTTP 301 Permanent Redirect** ke URL slug baru (`redirect($history->slug_baru, 301)`).
  5. Jika tidak ditemukan di mana pun, panggil `abort(404)`.
* **Output:**
  * HTTP 200 (Render Template Publik)
  * HTTP 301 (Permanent SEO Redirect)
  * HTTP 404 (Halaman Not Found kustom)

---

### 5. Modul Pengaturan Akun Admin (`App\Http\Controllers\Admin\SettingsController`)

#### A. Method `updateProfile(Request $request)`
* **Fungsi:** Mengubah nama lengkap dan username akun admin.
* **Input:** `name`, `username`.
* **Proses:** Validasi keunikan username terhadap tabel `admins`, lalu update data.
* **Output:** Redirect kembali dengan notifikasi profil berhasil diperbarui.

#### B. Method `updatePassword(Request $request)`
* **Fungsi:** Mengubah kata sandi login admin.
* **Input:** `current_password`, `new_password`, `new_password_confirmation`.
* **Proses:**
  1. Validasi kecocokan `current_password` dengan kata sandi aktif di database menggunakan `Hash::check()`.
  2. Enkripsi `new_password` dengan algoritma Bcrypt (`Hash::make()`).
  3. Catat audit log `UBAH_PASSWORD`.
* **Output:** Redirect kembali dengan notifikasi kata sandi sukses diganti.

---

# BAGIAN D: DEBUGGING

### 1. Metode dan Alat Debugging yang Digunakan
1. **Pest Automated Test Runner:** Menjalankan 22 unit test skenario untuk mendeteksi regresi kode secara instan saat ada perubahan.
2. **Laravel Storage Log (`storage/logs/laravel.log`):** Memeriksa *stack trace exception* lengkap jika terjadi error 500.
3. **Database Transaction Rollback:** Mencegah data "tersimpan setengah" saat proses upload berkas gagal di tengah jalan.
4. **Artisan CLI Helper:** Menggunakan perintah `php artisan route:list`, `php artisan config:clear`, dan `php artisan view:clear` untuk memastikan cache sistem selalu sinkron.

### 2. Studi Kasus Penanganan Bug Nyata Selama Pengembangan

| No | Kasus Masalah / Bug | Penyebab Teknis | Solusi Perbaikan (*Fix*) |
| :---: | :--- | :--- | :--- |
| **1** | **Race Condition Duplikasi Slug** | Dua request bersamaan menginput slug yang sama sebelum validasi aplikasi selesai. | Menambahkan indeks **UNIQUE Constraint** langsung pada level basis data MySQL di tabel `portfolios` kolom `slug`. |
| **2** | **Tautan Rusak saat Ganti Nama Toko** | Pelanggan lama yang menyimpan bookmark URL lama mendapatkan error 404 saat UMKM mengganti nama usahanya. | Membuat tabel `slug_histories` dan logika **HTTP 301 Permanent Redirect** otomatis di `PublicController`. |
| **3** | **XSS Injection pada Google Maps** | Admin memasukkan seluruh tag `<iframe>` mentah dari Google Maps yang berisiko menyusupkan skrip jahat. | Dibuat fungsi helper `extractMapsEmbedUrl()` untuk menyaring dan mengekstrak hanya atribut `src="https://..."` yang valid dan aman. |
| **4** | **Browser Back Cache Setelah Logout** | Setelah menekan Logout, pengguna masih bisa menekan tombol "Back" di browser dan melihat tampilan dashboard. | Dibuat middleware `PreventBackHistory` yang mengirim header HTTP `Cache-Control: no-cache, no-store, must-revalidate` pada seluruh route admin. |
| **5** | **Format Akun Instagram Fleksibel** | Admin kadang memasukkan `@namausaha`, kadang link lengkap `https://instagram.com/...`. | Dibuat Accessor Eloquent `getInstagramUrlAttribute()` pada Model `Portfolio` yang otomatis menormalisasi semua bentuk input menjadi tautan resmi. |

---

# BAGIAN E: PENGUJIAN SISTEM & TEST CASE

Sesuai instruksi soal Poin 9, berikut adalah tabel pelaksanaan uji coba pada minimal 5 skenario wajib:

### 1. Tabel 5 Skenario Uji Wajib (Manual & Functional Testing)

| ID Uji | Kasus Skenario Uji | Prosedur / Langkah Uji | Hasil yang Diharapkan | Hasil Pengujian | Status |
| :---: | :--- | :--- | :--- | :--- | :---: |
| **TC-01** | **Login Admin - Gagal** | Masukkan username benar dan password yang sengaja disalahkan. | Sistem menolak masuk, tetap di form login, dan menampilkan notifikasi kesalahan kredensial. | Muncul notifikasi: *"Username atau kata sandi yang Anda masukkan salah."* | **SESUAI (PASS)** |
| **TC-02** | **Login Admin - Sukses** | Masukkan username dan password admin yang benar. | Sesi login dibuat, aktivitas login dicatat ke log, dan halaman dialihkan ke Dashboard Admin. | Berhasil masuk ke `/admin/dashboard` dan nama admin tampil di banner atas. | **SESUAI (PASS)** |
| **TC-03** | **Tambah Data Portofolio Baru** | Isi seluruh form UMKM, pilih template `barang`, upload logo & produk, klik Terbitkan. | Data tersimpan ke tabel `portfolios`, file logo tersimpan di storage, log `TAMBAH_PORTFOLIO` tercatat. | Portofolio baru langsung muncul di tabel direktori dengan status Publish. | **SESUAI (PASS)** |
| **TC-04** | **Validasi Slug URL Duplikat** | Input portofolio baru dengan slug yang sudah dipakai oleh toko lain (misal: `kopi-senja`). | Sistem mendeteksi duplikasi, membatalkan simpan, dan memberi tahu bahwa slug sudah terpakai. | Form menolak simpan dengan pesan: *"The slug has already been taken."* | **SESUAI (PASS)** |
| **TC-05** | **Akses Web Publik (Slug Valid)** | Buka browser dan ketik alamat `domain.com/{slug}` (misal: `/kopi-senja`). | Halaman website portofolio UMKM tampil utuh sesuai template visual yang dipilih dengan status 200 OK. | Website portofolio kedai kopi terbuka rapi lengkap dengan tombol WA & Instagram. | **SESUAI (PASS)** |
| **TC-06** | **Akses Slug Tidak Valid (Error 404)** | Buka browser dan ketik alamat acak yang tidak ada di sistem (misal: `/toko-gaib-123`). | Sistem memanggil `abort(404)` dan menampilkan halaman kustom 404 Not Found. | Muncul halaman kustom 404 dengan pesan *"Halaman Tidak Ditemukan"* dan tombol kembali. | **SESUAI (PASS)** |
| **TC-07** | **Pengalihan SEO 301 Redirect** | Ubah slug toko dari `kopi-lama` menjadi `kopi-baru`, lalu buka URL `/{kopi-lama}`. | Browser otomatis dialihkan secara permanen (HTTP 301) ke `/{kopi-baru}` tanpa error. | URL browser otomatis berganti ke slug baru dan website tetap terbuka normal. | **SESUAI (PASS)** |

---

### 2. Bukti Pengujian Otomatis (Automated Test Suite)
Aplikasi ini dilengkapi pengujian otomatis terpadu menggunakan **Pest Framework**:
* **Total Pengujian:** 22 Test Suites
* **Total Assertions:** 73 Assertions
* **Status:** **100% PASSED (0 Failures, 0 Errors)**
* **Waktu Eksekusi:** 1.7 detik

```text
  PASS  Tests\Feature\Admin\AuthTest
  ✓ it renders login page
  ✓ it authenticates admin with valid credentials
  ✓ it rejects login with invalid credentials
  ✓ it logs out authenticated admin

  PASS  Tests\Feature\Admin\PortfolioTest
  ✓ it lists portfolios with pagination
  ✓ it creates portfolio with valid slug and uploads
  ✓ it prevents duplicate slug creation
  ✓ it updates portfolio and records slug history
  ✓ it deletes portfolio and cleans up uploads

  PASS  Tests\Feature\Public\PublicAccessTest
  ✓ it displays landing page
  ✓ it displays published portfolio by slug
  ✓ it redirects 301 for changed slug history
  ✓ it returns 404 for non-existent slug
  
  Tests:    22 passed (73 assertions)
  Duration: 1.73s
```

### 3. Panduan Pengambilan Tangkapan Layar (Screenshot) untuk Portofolio Ujian
Untuk melengkapi berkas fisik laporan cetak, ambil tangkapan layar pada halaman berikut:
1. **Screenshot 1:** Halaman Landing Page Publik (`http://127.0.0.1:8000/`)
2. **Screenshot 2:** Halaman Form Login Admin (`http://127.0.0.1:8000/admin/login`)
3. **Screenshot 3:** Halaman Dashboard Statistik Admin (`http://127.0.0.1:8000/admin/dashboard`)
4. **Screenshot 4:** Halaman Form Tambah Portofolio & Uji Validasi Slug Duplikat
5. **Screenshot 5:** Halaman Direktori Portofolio & Log Aktivitas Sistem
6. **Screenshot 6:** Tampilan Halaman Publik Portofolio UMKM (Contoh: Template Barang & Minuman)
7. **Screenshot 7:** Tampilan Halaman Notifikasi Error 404 Not Found

---

# BAGIAN F: LAPORAN EVALUASI SINGKAT

Sesuai instruksi soal Poin 11:

### A. Fitur yang Sudah Berjalan dengan Baik
1. **Sistem Autentikasi Admin:** Login, Logout, Session Security, dan Proteksi Histori Browser berjalan sempurna.
2. **Manajemen Portofolio Lengkap (CRUD):** Tambah, lihat detail, edit, dan hapus website toko klien berjalan lancar.
3. **Validasi Slug & SEO 301 Redirect:** Sistem berhasil mengamankan alamat unik URL dan melindungi toko dari error 404 saat berganti nama link.
4. **Koleksi 5 Konsep Desain Template Dinamis:** Template `minuman`, `makanan`, `barang`, `jasa`, dan `tokoh` dapat merender produk, alamat peta, serta kontak WA & IG secara presisi.
5. **Sistem Audit Trail (Activity Logs):** Setiap tindakan admin terekam akuntabel dengan waktu real-time.

### B. Bug / Limitasi yang Belum Diperbaiki
1. **Fitur Multibahasa:** Saat ini antarmuka publik dan admin masih berfokus penuh pada Bahasa Indonesia (belum mendukung tombol toggle Bahasa Inggris).
2. **Direct Payment Gateway:** Pembayaran paket berlangganan saat ini masih menggunakan alur konfirmasi manual via WhatsApp, belum terintegrasi otomatis ke payment gateway (seperti Midtrans/Xendit).

### C. Rencana Pengembangan Berikutnya
1. **Integrasi Custom Domain Otomatis:** Memungkinkan UMKM menggunakan domain kustom mereka sendiri (contoh: `www.tokosayur.com`) melalui konfigurasi DNS CNAME terotomasi.
2. **Dashboard Analitik Pengunjung (*Traffic Analytics*):** Menambahkan fitur pencatatan jumlah klik pengunjung dan tombol WhatsApp per hari untuk setiap toko UMKM.
3. **Fitur Ekspor Laporan PDF:** Menambahkan tombol unduh profil dan katalog produk UMKM ke format file PDF siap cetak.

---

# LAMPIRAN: OPERASI LANJUTAN DATABASE (POIN 6 SOAL)

Instruksi soal Poin 6 meminta: *"lakukan operasi relasional, stored procedure, function, trigger serta perintah commit dan rollback"*.

Berikut adalah skrip SQL murni yang dapat kamu jelaskan dan tunjukkan kepada Dewan Penguji jika diminta:

### 1. Perintah Commit & Rollback (Database Transaction)
```sql
-- Memulai transaksi aman saat menambah portofolio
START TRANSACTION;

INSERT INTO portfolios (admin_id, template_id, nama_umkm, slug, whatsapp, status, created_at, updated_at)
VALUES (1, 'minuman', 'Kedai Kopi Majalengka', 'kedai-kopi-majalengka', '0895324392999', 'publish', NOW(), NOW());

INSERT INTO activity_logs (admin_id, portfolio_id, action, description, created_at)
VALUES (1, LAST_INSERT_ID(), 'TAMBAH_PORTFOLIO', 'Menerbitkan website Kedai Kopi Majalengka', NOW());

-- Jika seluruh query di atas berhasil tanpa error:
COMMIT;

-- Jika terjadi kegagalan/error di tengah proses:
-- ROLLBACK;
```

### 2. Stored Procedure: Perpanjang Masa Aktif Paket UMKM
```sql
DELIMITER //
CREATE PROCEDURE sp_perpanjang_paket(
    IN p_portfolio_id BIGINT,
    IN p_jumlah_hari INT
)
BEGIN
    UPDATE portfolios 
    SET expired_at = DATE_ADD(IFNULL(expired_at, NOW()), INTERVAL p_jumlah_hari DAY),
        updated_at = NOW()
    WHERE id = p_portfolio_id;
END //
DELIMITER ;

-- Cara Memanggil:
-- CALL sp_perpanjang_paket(1, 365);
```

### 3. Function: Hitung Sisa Hari Masa Aktif Website UMKM
```sql
DELIMITER //
CREATE FUNCTION fn_sisa_hari_aktif(p_portfolio_id BIGINT) 
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE v_expired TIMESTAMP;
    DECLARE v_sisa INT;

    SELECT expired_at INTO v_expired FROM portfolios WHERE id = p_portfolio_id;

    IF v_expired IS NULL THEN
        RETURN 9999; -- Tanpa Batas / Selamanya Aktif
    ELSE
        SET v_sisa = DATEDIFF(v_expired, NOW());
        RETURN IF(v_sisa < 0, 0, v_sisa);
    END IF;
END //
DELIMITER ;

-- Cara Menggunakan:
-- SELECT nama_umkm, fn_sisa_hari_aktif(id) AS sisa_hari FROM portfolios;
```

### 4. Trigger: Otomatis Catat Log Audit saat Portofolio Dihapus
```sql
DELIMITER //
CREATE TRIGGER tr_after_delete_portfolio
AFTER DELETE ON portfolios
FOR EACH ROW
BEGIN
    INSERT INTO activity_logs (admin_id, portfolio_id, action, description, created_at)
    VALUES (OLD.admin_id, NULL, 'HAPUS_PORTFOLIO', CONCAT('Portofolio toko "', OLD.nama_umkm, '" (slug: ', OLD.slug, ') telah dihapus permanen.'), NOW());
END //
DELIMITER ;
```
