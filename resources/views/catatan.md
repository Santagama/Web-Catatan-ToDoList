# Catatan Dokumentasi: Folder Views (`resources/views/`)

---

## [FUNGSI]
Folder ini merupakan representasi komponen **View (V)** dalam pola arsitektur MVC Laravel. Menggunakan mesin templating **Blade**, folder ini bertugas menyusun struktur HTML dinamis yang akan dirender oleh server (Server-Side Rendering) dan dikirimkan ke peramban (*browser*) pengguna.

---

## [ALUR SISTEM / USER FLOW]
```
Controller selesai memproses logika dan memanggil: return view('nama.view', $data)
                                   │
                                   ▼
Blade Engine meng-compile tag-tag khusus Blade (@extends, @section, @foreach)
menjadi kode PHP murni yang di-cache di storage/framework/views
                                   │
                                   ▼
Server merender dokumen HTML utuh lengkap dengan class Tailwind CSS v4
dan mengirimkannya ke browser klien dalam hitungan milidetik.
```

---

## [PENJELASAN TEKNIS MASING-MASING SUBFOLDER]

*   `layouts/`: Berisi kerangka induk halaman (*master layout*).
    *   `app.blade.php`: Kerangka dasar HTML5, konfigurasi font Instrument Sans, dan `@vite` untuk Tailwind CSS v4.
    *   `admin.blade.php`: Kerangka panel admin yang menyertakan Sidebar Tetap, Header Topbar, dan area notifikasi.
*   `components/`: Potongan antarmuka modular yang dapat digunakan kembali (*reusable*), seperti notifikasi `alert.blade.php`.
*   `admin/`: Seluruh antarmuka yang berkaitan dengan pengelolaan dashboard oleh administrator.
*   `public/`: Halaman depan landing page dan 5 variasi layout template website portofolio UMKM.
*   `errors/`: Halaman penanganan error khusus seperti `404.blade.php` bertema gelap.

