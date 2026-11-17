# Catatan Dokumentasi: Folder Migrations (`database/migrations/`)

---

## [FUNGSI]
Folder ini berfungsi sebagai **manajemen skema database (Database Version Control)**. Semua struktur tabel, tipe data kolom, foreign key, dan relasi dibuat dalam bentuk kode PHP sehingga database MySQL dapat dibangun secara otomatis, konsisten, dan dapat dilacak perubahannya tanpa perlu membuat tabel secara manual di phpMyAdmin.

---

## [ALUR SISTEM / USER FLOW]
```
Developer / Siswa mengetik 'php artisan migrate' di terminal
                     │
                     ▼
Laravel membaca seluruh file migration secara berurutan sesuai timestamp
                     │
                     ▼
Method up() dieksekusi satu per satu:
1. Buat tabel 'admins'
2. Buat tabel 'portfolios' (berelasi ke admins)
3. Buat tabel 'activity_logs' (berelasi ke admins & portfolios)
4. Buat tabel 'slug_histories' (berelasi ke portfolios)
                     │
                     ▼
MySQL mengeksekusi perintah DDL (Data Definition Language)
dan mencatat daftar batch di tabel internal 'migrations'.
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `..._create_admins_table.php`
*   **Fungsi**: Membentuk tabel `admins` yang menampung data kredensial login admin pengelola sistem.
*   **Struktur Kolom**:
    *   `id`: Primary key auto-increment.
    *   `name` (varchar 100): Nama lengkap admin ("Hanan Aria Santagama").
    *   `username` (varchar 50): Username unik (`unique()`), mencegah adanya username ganda.
    *   `password` (varchar 255): Password yang sudah terenkripsi Bcrypt hash.
    *   `timestamps()`: Mencatat tanggal `created_at` dan `updated_at`.

### 2. `..._create_portfolios_table.php`
*   **Fungsi**: Membentuk tabel utama `portfolios` untuk menyimpan seluruh profil bisnis UMKM, pilihan template, paket, dan katalog produk.
*   **Struktur Kolom**:
    *   `id`: Primary key auto-increment.
    *   `admin_id`: Foreign key ke `admins.id` dengan relasi `cascadeOnDelete()`.
    *   `template_id` (varchar 50): Menyimpan kode template visual (`minuman`, `makanan`, `barang`, `tokoh`, `jasa`).
    *   `nama_umkm` (varchar 150): Nama usaha atau entitas UMKM.
    *   `slug` (varchar 150): URL unik publik (`unique()`), menjadi alamat web UMKM (contoh: `/kopi-kita`).
    *   `bio` (text, nullable): Cerita singkat atau profil usaha.
    *   `alamat` (text, nullable): Alamat fisik UMKM.
    *   `whatsapp` (varchar 20, nullable): Nomor kontak WA untuk pemesanan langsung.
    *   `maps_embed_url` (text, nullable): URL sematan peta Google Maps (tipe TEXT agar muat menampung URL maupun kode tag iframe).
    *   `logo_path` & `banner_path` (varchar 255, nullable): Lokasi file gambar di disk public storage.
    *   `products` (json, nullable): **Fitur modern array JSON** untuk menampung daftar produk unggulan (nama, harga, deskripsi, foto) tanpa perlu tabel tambahan yang membebani query.
    *   `paket` (varchar 20, nullable): Jenis durasi langganan (`3_bulan`, `1_tahun`, `tanpa_batas`).
    *   `expired_at` (timestamp, nullable): Batas waktu aktif portofolio untuk fitur otomasi Task Scheduler.
    *   `status` (varchar 20, default 'draft'): Status visibilitas (`draft` atau `publish`).
    *   `timestamps()`: Tanggal pembuatan dan pembaruan.

### 3. `..._create_activity_logs_table.php`
*   **Fungsi**: Membentuk tabel `activity_logs` untuk mencatat jejak audit (*audit trail*) setiap perubahan data penting di platform.
*   **Struktur Kolom**:
    *   `id`: Primary key auto-increment.
    *   `admin_id`: Foreign key ke `admins.id`.
    *   `portfolio_id`: Foreign key opsional (`nullable()`) ke `portfolios.id` dengan aturan `nullOnDelete()`. Jika portofolio dihapus, riwayat log tetap tersimpan untuk akuntabilitas.
    *   `action` (varchar 100): Label aksi singkat (`LOGIN`, `TAMBAH_PORTFOLIO`, `EDIT_PORTFOLIO`, `HAPUS_PORTFOLIO`, `AUTO_DRAFT`, `GANTI_PASSWORD`).
    *   `description` (text): Keterangan kalimat lengkap tentang kejadian.
    *   `created_at`: Waktu aksi dicatat (`useCurrent()`).

### 4. `..._create_slug_histories_table.php`
*   **Fungsi**: Membentuk tabel `slug_histories` untuk mendukung fitur SEO **HTTP 301 Permanent Redirect**. Jika nama usaha/slug diubah, pengunjung yang mengakses URL lama otomatis dialihkan ke URL baru.
*   **Struktur Kolom**:
    *   `id`: Primary key auto-increment.
    *   `portfolio_id`: Foreign key ke `portfolios.id` dengan `cascadeOnDelete()`.
    *   `slug_lama` (varchar 150): Slug lama sebelum diubah, diberi indeks `index()` untuk kecepatan lookup query.
    *   `slug_baru` (varchar 150): Slug baru tujuan pengalihan.
    *   `created_at`: Waktu pergantian slug dicatat.

