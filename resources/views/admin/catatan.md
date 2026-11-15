# Catatan Dokumentasi: Folder Views Admin (`resources/views/admin/`)

---

## [FUNGSI]
Folder ini khusus menampung antarmuka visual untuk **Portal Pengelola (Admin Dashboard)**. Seluruh halaman di sini mengadopsi tema **Dark Zinc & Emerald Green** yang clean, elegan, fungsional, dan bebas dari tampilan murahan (*anti-AI slop*).

---

## [ALUR SISTEM / USER FLOW]
```
1. Admin mengakses URL /admin/login
   └── View admin.auth.login menampilkan formulir kredensial di tengah layar

2. Admin berhasil memverifikasi kredensial
   └── Controller mengarahkan ke route admin.dashboard
   └── View admin.dashboard merender 4 kartu metrik, 5 portofolio terbaru,
       dan 5 rekam aktivitas audit terbaru
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE & SUBFOLDER]

### 1. `auth/login.blade.php`
*   **Fungsi**: Halaman login administrator berdesain gelap minimalis di tengah layar (*centered card*).
*   **Fitur**:
    *   Form input `username` dan `password` dengan proteksi token `@csrf`.
    *   Pesan error validasi otomatis (`@error`) jika salah memasukkan data.
    *   Badge kecil yang menampilkan kredensial default (`hanan` / `hanan123`) untuk mempermudah penilaian penguji saat demonstrasi.

### 2. `dashboard.blade.php`
*   **Fungsi**: Beranda pemantauan utama sistem admin.
*   **Komponen Konten**:
    *   *4 Kartu Metrik*: Total UMKM, Portofolio Terbit (Aktif), Draft (Tertunda), dan Paket Kadaluarsa (Expired).
    *   *Tabel 5 Portofolio Terkini*: Memantau UMKM yang baru didaftarkan beserta pilihan templatenya.
    *   *Tabel Jejak Audit*: Menampilkan log aktivitas terkini beserta pembeda warna badge aksi (`LOGIN`, `TAMBAH_PORTFOLIO`, dll).

