# Catatan Dokumentasi: Folder Migrations (`database/migrations/`)

---

## 1. Apa itu Database Migration? (Bahasa Santai)
Migration itu ibarat **"Cetak Biru (Blueprint) Arsitektur Database"**! 🏗️
Daripada kita membuat tabel satu per satu lewat phpMyAdmin (yang rawan salah klik tipe data atau lupa pasang Primary Key), kita menulis rancangan tabelnya lewat kode PHP di Migration.
Saat kita mengetik:
```bash
php artisan migrate
```
Laravel otomatis membangun seluruh tabel, kolom, tipe data, dan relasi antar tabel di database MySQL dalam hitungan detik!

---

## 2. Alur Pembentukan Tabel
```
Siswa / Penguji mengetik: php artisan migrate
                     │
                     ▼
Laravel membaca file migration berurutan dari atas ke bawah:
1. admins_table         => Buat tabel akun admin
2. portfolios_table     => Buat tabel profil & katalog UMKM (relasi ke admins)
3. activity_logs_table  => Buat tabel jejak audit (relasi ke admins & portfolios)
4. slug_histories_table => Buat tabel riwayat URL (relasi ke portfolios)
                     │
                     ▼
Database MySQL terstruktur rapi dengan Foreign Key dan Indexing!
```

---

## 3. Penjelasan 4 Tabel Inti Aplikasi & Contekan Ujikom

### A. Tabel `admins`
*   **Fungsinya**: Menyimpan data akun login pengelola sistem.
*   **Kolom Kunci**:
    *   `id`: Primary key auto increment.
    *   `name`: Nama lengkap ("Hanan Aria Santagama").
    *   `username`: Diberi aturan `->unique()` agar tidak ada username kembar.
    *   `password`: Menyimpan hash password Bcrypt (panjang 255 karakter).
    *   `timestamps()`: Menyimpan tanggal `created_at` dan `updated_at`.

---

### B. Tabel `portfolios` (Tabel Utama)
*   **Fungsinya**: Menyimpan seluruh profil bisnis UMKM, pilihan template, foto, hingga katalog produk.
*   **Kolom Istimewa**:
    *   `admin_id`: Foreign key ke `admins.id` dengan aturan `cascadeOnDelete()`.
    *   `template_id`: Kode template visual (`minuman`, `makanan`, `barang`, `tokoh`, `jasa`).
    *   `slug`: Alamat URL unik web UMKM (`->unique()`), contoh: `/kopi-kenangan`.
    *   `maps_embed_url` (text, nullable): Link peta Google Maps.
    *   `products` (json, nullable): **Fitur Modern!** Kolom bertipe JSON untuk menyimpan banyak produk (nama, harga, deskripsi, foto) tanpa perlu repot membuat tabel tambahan yang membebani query!
    *   `paket` & `expired_at`: Durasi aktif langganan dan tanggal kadaluarsa untuk otomasi sistem.
    *   `status`: Visibilitas (`draft` atau `publish`).
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Struktur tabel portfolios kami rancang modern dengan memanfaatkan tipe data JSON untuk kolom `products`. Pendekatan NoSQL-in-SQL ini membuat penyimpanan katalog produk UMKM sangat fleksibel dan performa read-nya sangat cepat karena tidak perlu melakukan join relasi tabel produk terpisah."*

---

### C. Tabel `activity_logs`
*   **Fungsinya**: Mencatat jejak audit (*audit trail*) siapa melakukan apa dan kapan terjadinya.
*   **Kolom Kunci**:
    *   `admin_id`: Siapa admin yang melakukan aksi.
    *   `portfolio_id`: ID UMKM terkait (menggunakan `nullOnDelete()`, jadi kalau UMKM-nya dihapus, catatan riwayat log-nya tetap abadi tersimpan untuk bukti audit).
    *   `action`: Kode aksi singkat (`LOGIN`, `TAMBAH_PORTFOLIO`, `HAPUS_PORTFOLIO`, dll).
    *   `description`: Penjelasan kalimat yang mudah dibaca.
    *   `created_at`: Menggunakan `useCurrent()` untuk mencatat detik kejadian.

---

### D. Tabel `slug_histories`
*   **Fungsinya**: Mendukung fitur SEO **HTTP 301 Permanent Redirect**.
*   **Kolom Kunci**:
    *   `portfolio_id`: Pemilik slug terkait.
    *   `slug_lama`: Alamat web lama sebelum diedit, diberi `->index()` agar pencarian di database super cepat saat pengunjung mengakses link lama.
    *   `slug_baru`: Alamat web baru tujuan pengalihan.
    *   `created_at`: Waktu perubahan URL.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Tabel slug_histories ini kami optimalkan dengan Indexing pada kolom `slug_lama`. Hal ini menjamin proses pencarian saat pengunjung mengakses URL lama berjalan instan dalam hitungan milidetik sebelum browser dialihkan ke URL baru."*
