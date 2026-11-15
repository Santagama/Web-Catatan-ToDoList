# Catatan Dokumentasi: Folder Views Portfolios (`resources/views/admin/portfolios/`)

---

## [FUNGSI]
Folder ini berisi seluruh antarmuka pengguna (View Blade) untuk **Manajemen Portofolio UMKM**. Di sinilah admin dapat melihat direktori semua UMKM, menyaring berdasarkan status, menambah portofolio baru dengan pemilihan template visual, mengedit data bisnis dan katalog produk, melihat detail lengkap, serta memperpanjang masa aktif paket langganan.

---

## [ALUR SISTEM / USER FLOW]
```
1. Admin membuka menu 'Direktori UMKM' di sidebar
   └── Masuk ke rute: admin.portfolios.index
   └── View index.blade.php menampilkan tabel daftar portofolio, search bar,
       dan tab filter status (Semua, Aktif, Draft, Expired)

2. Admin menekan tombol '+ Tambah Portofolio'
   └── Masuk ke rute: admin.portfolios.create
   └── View create.blade.php menampilkan 5 kartu template visual,
       form profil usaha (dengan auto-generate slug realtime),
       kotak upload logo & banner dengan live preview gambar,
       dan section dinamis '+ Tambah Produk' untuk menambah baris barang

3. Admin menekan tombol 'Detail' pada baris portofolio
   └── Masuk ke rute: admin.portfolios.show
   └── View show.blade.php menampilkan profil lengkap, katalog produk,
       embed peta Google Maps, sisa masa aktif paket, dan bukti riwayat slug lama (SEO 301)
   └── Admin bisa klik tombol 'Perpanjang Paket' untuk membuka modal perpanjangan masa aktif

4. Admin menekan tombol 'Edit'
   └── Masuk ke rute: admin.portfolios.edit
   └── View edit.blade.php menampilkan form berisi data lama
   └── Jika admin mengubah slug, muncul peringatan otomatis bahwa slug lama akan dialihkan

5. Admin menekan tombol 'Hapus'
   └── Muncul konfirmasi alert JavaScript
   └── Data dan seluruh file gambar di storage dihapus bersih via PortfolioController@destroy
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `index.blade.php`
*   **Fungsi**: Halaman tabel direktori seluruh portofolio UMKM.
*   **Fitur**:
    *   *Search Bar*: Mencari nama usaha atau slug via parameter `?search=...`.
    *   *Tab Filter Status*: Filter cepat `Semua`, `publish` (Aktif), `draft` (Tertunda), dan `expired` (Kadaluarsa).
    *   *Tombol Aksi Cepat*:
        *   **Lihat Web**: Membuka halaman publik `/{slug}` di tab baru (`target="_blank"`).
        *   **Salin**: Menyalin URL publik ke clipboard secara instan menggunakan JavaScript `navigator.clipboard.writeText()`.
        *   **Detail, Edit, Hapus**: Navigasi ke modul manajemen portofolio terkait.
    *   *Paginasi Laravel*: Menampilkan navigasi halaman jika data melebihi 10 entri (`$portfolios->links()`).

### 2. `create.blade.php`
*   **Fungsi**: Halaman formulir pendaftaran portofolio UMKM baru.
*   **Fitur Cerdas (Nilai Plus Penguji)**:
    *   *Pemilihan Template*: Radio button bergaya kartu interaktif untuk 5 template (`minuman`, `makanan`, `organisasi`, `tokoh`, `jasa`).
    *   *Auto-Slug Generator (Vanilla JS)*: Saat admin mengetik *"Kopi Senja Nusantara"*, input slug otomatis terisi *"kopi-senja-nusantara"*.
    *   *Live Image Preview (Vanilla JS)*: Saat admin memilih file logo atau banner, gambar langsung tampil di layar sebelum klik Simpan.
    *   *Dynamic Product Row*: Admin bisa klik `+ Tambah Produk` untuk menambah baris produk (nama, harga, deskripsi, foto) tanpa batas secara dinamis di browser.

### 3. `edit.blade.php`
*   **Fungsi**: Halaman pembaruan data portofolio.
*   **Fitur Khusus**:
    *   Mendeteksi perubahan slug: Jika admin mengganti slug URL asli, JavaScript memunculkan peringatan bahwa URL lama akan dialihkan otomatis via HTTP 301.
    *   Menampilkan thumbnail gambar logo dan banner yang saat ini sedang aktif.
    *   Menampilkan seluruh baris produk yang sudah tersimpan sebelumnya untuk dapat diedit atau dihapus.

### 4. `show.blade.php`
*   **Fungsi**: Halaman tinjauan komprehensif satu portofolio UMKM.
*   **Fitur**:
    *   Menampilkan status masa aktif dengan perhitungan sisa hari menggunakan Carbon (`remainingDays()`).
    *   Menampilkan daftar katalog produk unggulan dalam format kartu grid.
    *   Menampilkan riwayat pengalihan slug lama $\rightarrow$ slug baru dari tabel `slug_histories` (bukti implementasi SEO 301 untuk penguji).
    *   Modal interaktif untuk memperpanjang paket langganan (3 bulan atau 1 tahun) yang memanggil route `admin.portfolios.extend`.

