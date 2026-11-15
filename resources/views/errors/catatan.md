# Catatan Dokumentasi: Folder Views Errors (`resources/views/errors/`)

---

## [FUNGSI]
Folder ini berisi antarmuka khusus untuk menangani kode status kesalahan HTTP (*HTTP Error Status Code*). Di dalamnya terdapat penanganan khusus untuk error **404 Not Found** yang disesuaikan dengan tema visual platform (Dark Zinc & Emerald Green), sehingga pengunjung tidak disajikan halaman error putih polos bawaan server yang membingungkan.

---

## [ALUR SISTEM / USER FLOW]
```
Pengunjung memasukkan URL slug yang salah atau tidak terdaftar:
Contoh: localhost:8000/toko-yang-tidak-ada
                             │
                             ▼
PublicController@show mencari slug di tabel portfolios dan slug_histories
                             │
                             ▼
Data tidak ditemukan (atau ada tapi statusnya masih 'draft')
                             │
                             ▼
Laravel mengeksekusi: abort(404)
                             │
                             ▼
Framework otomatis merender view: resources/views/errors/404.blade.php
Menampilkan pesan informatif dan tombol kembali ke halaman beranda utama.
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `404.blade.php`
*   **Fungsi**: Halaman tampilan ketika rute/slug portofolio tidak ditemukan.
*   **Fitur**:
    *   Badge kode status `404` dengan bayangan halus bernuansa gelap.
    *   Pesan penjelasan yang santun bahwa URL belum terdaftar atau masih dalam status draft oleh pengelola.
    *   Tombol navigasi `Kembali ke Beranda Utama` (`route('home')`) dan tombol cepat `Tanya Admin via WA`.
