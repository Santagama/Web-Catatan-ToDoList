# Catatan Dokumentasi: View Penanganan Error (`resources/views/errors/`)

---

## 1. Apa itu File `404.blade.php`? (Bahasa Santai)
Ini adalah halaman khusus yang muncul saat pengunjung membuka alamat web yang **TIDAK DITEMUKAN** (Error 404 Not Found)! 🚫
Contohnya saat pengunjung mengetik URL yang salah:
`http://localhost:8000/toko-yang-tidak-pernah-ada`

Daripada pengunjung disajikan halaman putih polos bawaan browser yang jelek dan membingungkan, Laravel otomatis memanggil file `404.blade.php` ini!

---

## 2. Fitur Ramah Pengunjung di Halaman 404:
1.  **Tipografi Angka 404 Merah Tegas**:
    *   Ukuran besar dan jelas memberi tahu pengunjung bahwa halaman tidak tersedia.
2.  **Pesan Penjelasan yang Jelas & Santun**:
    *   Memberi tahu bahwa mungkin alamat URL salah ketik, website sudah dipindahkan, atau pemilik toko belum mempublikasikannya.
3.  **Tombol Kembali ke Beranda**:
    *   Membawa pengunjung pulang ke halaman utama dengan satu kali klik.
4.  **Tombol Tanya Admin via WhatsApp**:
    *   Menyediakan tombol bantuan langsung ke WhatsApp admin jika pengunjung membutuhkan panduan.

---

## 3. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, custom error page 404 ini kami sediakan untuk meningkatkan User Experience (UX). Dengan menyajikan tombol navigasi kembali dan integrasi bantuan WhatsApp, pengunjung tidak akan mengalami jalan buntu (dead-end page) saat terjadi kesalahan input URL."*
