# Catatan Dokumentasi: Folder Views (`resources/views/`)

---

## 1. Apa itu Folder Views? (Bahasa Santai)
Folder ini adalah tempat tinggalnya **Tampilan Antarmuka Website (Front-End HTML)**! 🎨
Kalau dalam arsitektur MVC (Model-View-Controller):
- **Model**: Yang ngambil data dari gudang database.
- **Controller**: Koki yang ngolah logika dan data.
- **View**: Piring saji dan tata rias makanan yang dinikmati pelanggan!

Laravel menggunakan mesin template bernama **Blade** (cirinya semua file berakhiran `.blade.php`). Dengan Blade, kita bisa membuat website yang dinamis tanpa perlu mengetik kode PHP yang rumit dan bikin pusing.

---

## 2. Jurus Sakti Perintah Blade yang Wajib Kamu Pahami:
1. `@extends('layouts.admin')`:
   * Artinya: *"Tolong ambilkan kerangka dasar halaman admin ya (header, sidebar, footer sudah otomatis ada)."*
2. `@section('content') ... @endsection`:
   * Artinya: *"Ini lho isi konten utama halamannya, tolong masukkan ke dalam kerangka tadi."*
3. `@csrf`:
   * Token pengaman rahasia wajib di dalam setiap `<form>` agar tidak bisa dibajak hacker.
4. `@foreach ($data as $item) ... @endforeach`:
   * Perulangan untuk menampilkan daftar data (misal: daftar produk, tabel portofolio).
5. `{{ $porto->nama_umkm }}`:
   * Menampilkan data teks ke layar secara aman (otomatis mencegah serangan XSS).

---

## 3. Peta Subfolder di Dalam Views
*   📁 `layouts/`: Kerangka induk halaman.
    *   `app.blade.php`: Kerangka umum (dipakai di Landing Page, Login, dan 404).
    *   `admin.blade.php`: Kerangka khusus dashboard admin (ada sidebar kiri dan topbar mobile).
*   📁 `components/`: Potongan kecil yang sering dipakai berulang kali, contohnya `alert.blade.php` (kotak notifikasi hijau/merah).
*   📁 `admin/`: Seluruh halaman yang ada di dalam dashboard admin (tabel UMKM, tambah/edit web, log aktivitas, ganti password).
*   📁 `public/`: Halaman depan yang bisa dibuka siapa saja tanpa login (Landing Page promosi dan 5 template UMKM).
*   📁 `errors/`: Halaman khusus saat terjadi error, contohnya `404.blade.php` (halaman tidak ditemukan).

---

## 4. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, sistem Front-End kami dibangun menggunakan Blade Templating Engine dengan prinsip Modular Layout (`@extends` dan `@yield`). Sehingga komponen global seperti Sidebar dan Header cukup dibuat sekali di folder layouts, membuat kode sangat bersih, rapi, dan mudah dirawat."*
