# Catatan Dokumentasi: Folder Views Admin (`resources/views/admin/`)

---

## 1. Apa Fungsi Folder Ini? (Bahasa Santai)
Folder ini berisi seluruh tampilan untuk **Panel Kontrol Admin (Dashboard)**.
Tema visual yang kita gunakan adalah **Light Modern (White & Teal)** yang terlihat profesional, bersih, elegan, dan nyaman di mata penguji.

Semua halaman di dalam folder ini otomatis mewarisi layout `@extends('layouts.admin')`, jadi sidebar kiri, foto profil admin, dan navigasi menu sudah otomatis tersedia di setiap halaman.

---

## 2. Alur Navigasi Admin
```
Admin berhasil Login
        │
        ▼
admin/dashboard.blade.php (Lihat ringkasan 4 kartu metrik & 5 data terbaru)
        │
        ├── Direktori Web    => portfolios/index.blade.php (Tabel data UMKM)
        ├── Buat Web Baru    => portfolios/create.blade.php (Form input UMKM)
        ├── Activity Log     => logs/index.blade.php (Timeline jejak audit)
        ├── Pengaturan Akun  => settings/index.blade.php (Profil & Multi-User Admin)
        └── Logout           => Tombol keluar sesi di sidebar bawah
```

---

## 3. Penjelasan Halaman Kunci

### A. `dashboard.blade.php` (Beranda Pemantauan)
*   **Isinya apa saja?**
    *   **Banner Selamat Datang**: Menyapa nama admin yang sedang aktif secara otomatis (`{{ auth()->user()->name }}`).
    *   **4 Kartu Angka Metrik**:
        1. Total Portofolio UMKM
        2. Web Aktif (Publish)
        3. Web Konsep (Draft)
        4. Web Kedaluwarsa (Expired)
    *   **Tabel 5 Portofolio Terbaru**: Melihat langsung UMKM mana yang baru didaftarkan.
    *   **Tabel 5 Jejak Aktivitas Terakhir**: Bukti pengawasan sistem secara transparan.

---

## 4. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, panel administrasi kami rancang dengan layout terpusat yang responsif (desktop maupun mobile). Dashboard dilengkapi metrik operasional realtime sehingga admin dapat memantau status tayang seluruh klien UMKM hanya dalam satu layar."*
