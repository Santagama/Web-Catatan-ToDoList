# Catatan Dokumentasi: View Portofolio UMKM (`resources/views/admin/portfolios/`)

---

## 1. Apa Fungsi Folder Ini? (Bahasa Santai)
Ini adalah **Dapur Inti Aplikasi**! 🍲
Di sinilah admin mengelola seluruh website portofolio klien UMKM, mulai dari melihat tabel data, membuat website baru, mengedit, melihat detail, hingga memperpanjang masa aktif paket.

---

## 2. Penjelasan Tiap File View

### A. `index.blade.php` (Tabel Master Portofolio)
*   **Fungsinya**: Menampilkan seluruh website UMKM yang sudah dibuat.
*   **Fitur Keren**:
    *   **Kotak Pencarian**: Bisa cari berdasarkan nama toko atau slug URL.
    *   **Filter Tab Status**: Tombol cepat untuk memfilter: `Semua`, `Publish` (Aktif), dan `Draft` (Konsep).
    *   **Tombol Aksi**: Buka website publik di tab baru, Edit data, dan Hapus portofolio.
    *   **Paginasi Otomatis**: Membagi data jadi 10 baris per halaman (`$portfolios->links()`).

### B. `create.blade.php` (Form Pembuatan Website Baru)
*   **Fungsinya**: Formulir lengkap untuk mendaftarkan website portofolio baru.
*   **Fitur Keren yang Bikin Penguji Kagum**:
    1.  *Pilihan 5 Template*: Kartu visual untuk memilih tema (Minuman, Makanan, Barang, Tokoh, Jasa).
    2.  *Auto-Slug Realtime (Vanilla JS)*: Saat admin mengetik *"Kopi Kenangan Senja"*, input slug di bawahnya otomatis terisi *"kopi-kenangan-senja"* tanpa spasi!
    3.  *Live Preview Foto*: Saat admin memilih file gambar logo atau banner dari laptop, gambarnya langsung muncul di layar sebelum tombol simpan ditekan!
    4.  *Daftar Produk Dinamis*: Tombol `+ Tambah Produk` bisa diklik berkali-kali untuk menambah produk baru tanpa batas secara dinamis lewat JavaScript!

### C. `edit.blade.php` (Form Edit Portofolio)
*   **Fungsinya**: Mengubah data portofolio yang sudah ada.
*   **Fitur Andalan**:
    *   *Peringatan Ganti Slug (SEO 301) & Proteksi Riwayat*: Jika admin mengganti nama slug URL, muncul kotak peringatan bahwa link lama otomatis dialihkan 301 agar tidak broken link. Sistem di backend juga memvalidasi agar slug baru tidak bertabrakan dengan riwayat pengalihan milik portofolio lain.
    *   Menampilkan gambar logo dan banner lama yang sedang aktif.

### D. `show.blade.php` (Halaman Tinjauan / Detail Lengkap)
*   **Fungsinya**: Melihat seluruh profil portofolio secara komprehensif.
*   **Fitur Andalan**:
    *   Menghitung sisa hari aktif paket (`remainingDays()`).
    *   Peta Google Maps interaktif yang disematkan langsung.
    *   Tabel riwayat perubahan slug URL (`slug_histories`) sebagai bukti implementasi SEO 301.
    *   Modal popup untuk memperpanjang paket langganan (3 bulan atau 1 tahun).

---

## 3. 💡 Jawaban Mantap untuk Penguji:
> *"Modul Portofolio ini mengintegrasikan Form Request, penanganan upload multimedia, dan komponen dinamis berbasis Vanilla JavaScript (Auto-Slug dan Live Image Preview) yang ringan tanpa membebani browser pengguna."*
