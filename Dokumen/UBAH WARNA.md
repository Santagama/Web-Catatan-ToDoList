# 🎨 Panduan Lengkap Mengubah Warna Halaman & Tombol (Contekan Uji Petik UKK)

**Penyusun**: Hanan Aria Santagama (Kelas XII RPL 1 — SMKN 1 Majalengka)  
**Aplikasi**: CMS Web Builder Platform Portofolio UMKM  
**Tujuan Dokumen**: Contekan kilat jika penguji industri tiba-tiba menyuruh: *"Coba Hanan, ganti warna background halaman ini!"* atau *"Coba tombol ini ganti jadi warna biru/merah!"*. Semua file, lokasi baris, dan kode warnanya sudah dirangkum di sini secara lengkap!

---

## ⚡ Trik Kilat 3 Detik di Depan Penguji:
Hampir seluruh tombol dan elemen penting di file tampilan sudah dipasangi komentar penanda:
```html
{{-- // UBAH WARNA ... // --}}
```
**Caranya:** Di file yang bersangkutan, tekan **`Ctrl + F`** di VS Code $\rightarrow$ ketik kata **`UBAH WARNA`** $\rightarrow$ kursor langsung melompat ke baris tersebut tanpa perlu dicari manual!

---

## 🎨 Tabel Kamus Kode Warna Tailwind CSS

Gunakan class warna resmi Tailwind di bawah ini saat diminta penguji:

| Warna yang Diminta | Background Utama | Hover (Saat Kursor Nempel) | Teks Berwarna | Garis Tepi (Border) |
| :--- | :--- | :--- | :--- | :--- |
| **Teal (Warna Asli Web)** | `bg-teal-600` | `hover:bg-teal-700` | `text-teal-600` | `border-teal-500` |
| **Biru (Blue)** | `bg-blue-600` | `hover:bg-blue-700` | `text-blue-600` | `border-blue-500` |
| **Merah (Rose / Red)** | `bg-rose-600` | `hover:bg-rose-700` | `text-rose-600` | `border-rose-500` |
| **Hijau (Emerald / Green)** | `bg-emerald-600` | `hover:bg-emerald-700` | `text-emerald-600` | `border-emerald-500` |
| **Ungu (Purple / Indigo)** | `bg-purple-600` | `hover:bg-purple-700` | `text-purple-600` | `border-purple-500` |
| **Kuning / Oranye (Amber)** | `bg-amber-600` | `hover:bg-amber-700` | `text-amber-600` | `border-amber-500` |
| **Putih Bersih (White)** | `bg-white` | `hover:bg-zinc-100` | `text-white` | `border-zinc-200` |
| **Abu-Abu Terang (Zinc)** | `bg-zinc-100` | `hover:bg-zinc-200` | `text-zinc-700` | `border-zinc-300` |
| **Hitam / Gelap (Dark)** | `bg-zinc-950` | `hover:bg-zinc-900` | `text-zinc-900` | `border-zinc-800` |

---

## 🖥️ BAGIAN 1: Mengubah Warna Background (Latar Belakang) Halaman

Jika penguji meminta: *"Coba ganti warna background halamannya!"*

### 1. Background Seluruh Halaman Panel Admin
* **File Target**: [resources/views/layouts/admin.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/layouts/admin.blade.php#L18)
* **Posisi**: **Baris 18**
* **Kodingan Asli**:
  ```html
  <body class="bg-zinc-50 text-zinc-900 min-h-screen antialiased flex flex-col font-sans">
  ```
* **Cara Ubah**: Ganti kata `bg-zinc-50` menjadi:
  * Ingin Putih Bersih: `bg-white`
  * Ingin Abu-abu Modern: `bg-slate-100`
  * Ingin Gelap (Dark Mode): `bg-zinc-950 text-zinc-100`

---

### 2. Background Sidebar Admin (Menu Samping Kiri)
* **File Target**: [resources/views/layouts/admin.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/layouts/admin.blade.php#L35)
* **Posisi**: **Baris 35**
* **Kodingan Asli**:
  ```html
  <aside id="admin-sidebar" class="... bg-white border-r border-zinc-200/80 ...">
  ```
* **Cara Ubah**: Ganti `bg-white` menjadi:
  * Ingin Sidebar Gelap: `bg-zinc-900 border-zinc-800 text-white`
  * Ingin Sidebar Abu Lembut: `bg-zinc-100`

---

### 3. Background Halaman Landing Page Publik (`/`)
* **File Target**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L17)
* **Posisi**: **Baris 17 dan Baris 20**
* **Kodingan Asli**:
  ```html
  @section('body_class', 'bg-white text-slate-900 min-h-screen ...')
  <div class="relative bg-white text-slate-900 min-h-screen ...">
  ```
* **Cara Ubah**: Ganti `bg-white` menjadi:
  * Ingin Krem Hangat: `bg-amber-50`
  * Ingin Abu-abu Elegan: `bg-slate-50`
  * Ingin Mode Gelap (Dark): `bg-slate-950 text-white`

---

### 4. Background Halaman Error 404 Not Found
* **File Target**: [resources/views/errors/404.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/errors/404.blade.php#L14)
* **Posisi**: **Baris 14**
* **Kodingan Asli**:
  ```html
  <div class="relative flex min-h-screen flex-col items-center justify-center bg-zinc-950 px-6 py-12 ...">
  ```
* **Cara Ubah**: Ganti `bg-zinc-950` menjadi:
  * Ingin Latar Terang: `bg-zinc-50 text-zinc-900`
  * Ingin Latar Merah Peringatan: `bg-rose-950 text-rose-100`

---

## 🔘 BAGIAN 2: Mengubah Warna Tombol-Tombol Utama (Action Buttons)

Jika penguji menunjuk tombol tertentu dan menyuruh mengganti warnanya:

---

### 1. Tombol "Login Admin" di Navbar Landing Page
* **File Target**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L54)
* **Posisi**: **Baris 54**
* **Kodingan Asli**:
  ```html
  <a href="{{ route('admin.login') }}" class="... bg-teal-600 ...">
  ```
* **Ubah `bg-teal-600` menjadi**:
  * Biru: `bg-blue-600 hover:bg-blue-700`
  * Merah: `bg-rose-600 hover:bg-rose-700`

---

### 2. Tombol "Pesan Website via WhatsApp" (Hero Landing Page)
* **File Target**: [resources/views/public/landing.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/landing.blade.php#L114)
* **Posisi**: **Baris 114**
* **Kodingan Asli**:
  ```html
  <a href="{{ $waUrl }}" class="... bg-teal-600 text-white ...">
  ```
* **Ubah `bg-teal-600` menjadi**:
  * Hijau WhatsApp Resmi: `bg-emerald-600 hover:bg-emerald-700`
  * Biru: `bg-blue-600 hover:bg-blue-700`

---

### 3. Tombol Submit Form Login Admin ("Masuk ke Panel Admin")
* **File Target**: [resources/views/admin/auth/login.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/auth/login.blade.php#L173)
* **Posisi**: **Baris 173**
* **Kodingan Asli**:
  ```html
  <button type="submit" class="... bg-white hover:bg-zinc-100 text-gray-950 ...">
  ```
* **Ubah `bg-white text-gray-950` menjadi**:
  * Teal: `bg-teal-600 hover:bg-teal-700 text-white`
  * Biru: `bg-blue-600 hover:bg-blue-700 text-white`
  * Merah: `bg-rose-600 hover:bg-rose-700 text-white`

---

### 4. Tombol Menu Aktif di Sidebar Admin
* **File Target**: [resources/views/layouts/admin.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/layouts/admin.blade.php#L65)
* **Posisi**: **Baris 65 (Dashboard), Baris 74 (Portofolio), Baris 83 (Log), Baris 92 (Pengaturan)**
* **Kodingan Asli**:
  ```html
  bg-teal-500/15 text-teal-600 border border-teal-500/30
  ```
* **Ubah menjadi**:
  * Biru: `bg-blue-500/15 text-blue-600 border border-blue-500/30`
  * Merah: `bg-rose-500/15 text-rose-600 border border-rose-500/30`
  * Ungu: `bg-purple-500/15 text-purple-600 border border-purple-500/30`

---

### 5. Tombol "Keluar (Logout)" di Sidebar
* **File Target**: [resources/views/layouts/admin.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/layouts/admin.blade.php#L121)
* **Posisi**: **Baris 121**
* **Kodingan Asli**:
  ```html
  class="... text-rose-500 bg-rose-50 border border-rose-200 ..."
  ```
* **Ubah menjadi**:
  * Merah Pekat: `bg-rose-600 hover:bg-rose-700 text-white`
  * Abu-abu: `bg-zinc-100 hover:bg-zinc-200 text-zinc-700`

---

### 6. Tombol "+ Buat Web Baru" di Dashboard
* **File Target**: [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/dashboard.blade.php#L179)
* **Posisi**: **Baris 179**
* **Kodingan Asli**:
  ```html
  class="... bg-teal-600 text-white shadow-lg shadow-teal-100 ..."
  ```
* **Ubah `bg-teal-600 shadow-teal-100` menjadi**:
  * Biru: `bg-blue-600 hover:bg-blue-700 shadow-blue-100 text-white`
  * Merah: `bg-rose-600 hover:bg-rose-700 shadow-rose-100 text-white`
  * Hijau: `bg-emerald-600 hover:bg-emerald-700 shadow-emerald-100 text-white`

---

### 7. Tombol "+ Tambah Produk" di Form Input UMKM
* **File Target**: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L191)
* **Posisi**: **Baris 191** *(dan di edit.blade.php baris 196)*
* **Kodingan Asli**:
  ```html
  class="... bg-teal-600 text-white shadow-md shadow-teal-100 ..."
  ```
* **Ubah `bg-teal-600 shadow-teal-100` menjadi**:
  * Biru: `bg-blue-600 hover:bg-blue-700 text-white shadow-blue-100`
  * Hitam: `bg-zinc-900 hover:bg-black text-white`

---

### 8. Tombol "Simpan Portofolio" / "Simpan Perubahan"
* **File Create**: [resources/views/admin/portfolios/create.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/create.blade.php#L280) (**Baris 280**)
* **File Edit**: [resources/views/admin/portfolios/edit.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/edit.blade.php#L284) (**Baris 284**)
* **Kodingan Asli**:
  ```html
  <button type="submit" class="... bg-teal-600 text-white shadow-lg shadow-teal-100 ...">
  ```
* **Ubah `bg-teal-600 shadow-teal-100` menjadi**:
  * Biru: `bg-blue-600 hover:bg-blue-700 text-white shadow-blue-100`
  * Hijau: `bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-100`
  * Merah: `bg-rose-600 hover:bg-rose-700 text-white shadow-rose-100`

---

### 9. Tombol "Perpanjang Paket" di Halaman Detail Portofolio
* **File Target**: [resources/views/admin/portfolios/show.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/portfolios/show.blade.php#L65)
* **Posisi**: **Baris 65 dan Baris 366 (Tombol Modal)**
* **Kodingan Asli**:
  ```html
  class="... bg-teal-600 text-white shadow-md shadow-teal-100 ..."
  ```
* **Ubah `bg-teal-600` menjadi**:
  * Biru: `bg-blue-600 hover:bg-blue-700 text-white`
  * Ungu: `bg-purple-600 hover:bg-purple-700 text-white`

---

### 10. Tombol "Simpan Profil" & "Tambah Admin" di Pengaturan
* **File Target**: [resources/views/admin/settings/index.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/admin/settings/index.blade.php)
* **Tombol Simpan Profil**: **Baris 154** (`bg-teal-600 text-white`)
* **Tombol Tambah Admin**: **Baris 246** (`bg-teal-600 text-white`)
* **Cara Ubah**: Ganti `bg-teal-600` dengan `bg-blue-600` atau `bg-rose-600`.

---

### 11. Tombol "Kembali ke Beranda" di Halaman 404
* **File Target**: [resources/views/errors/404.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/errors/404.blade.php#L37)
* **Posisi**: **Baris 37**
* **Kodingan Asli**:
  ```html
  class="... bg-white hover:bg-zinc-200 text-zinc-950 ..."
  ```
* **Cara Ubah**:
  * Ingin Merah: `bg-rose-600 hover:bg-rose-700 text-white`
  * Ingin Teal: `bg-teal-600 hover:bg-teal-700 text-white`

---

## ☕ BAGIAN 3: Mengubah Warna Tombol Order WhatsApp di 5 Template UMKM

Jika penguji membuka salah satu halaman UMKM (misal `/kopi-sejahtera`) lalu menyuruh mengganti warna tombol pesannya:

| Template | File Lokasi | Baris Perkiraan | Kodingan Asli | Cara Ubah ke Warna Lain |
| :--- | :--- | :---: | :--- | :--- |
| **1. Minuman** | [resources/views/public/templates/minuman.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/templates/minuman.blade.php#L188) | **Baris ~188** | `bg-[#C68D5D]` (Cokelat Kopi) | Ganti jadi `bg-teal-600` (Teal) atau `bg-emerald-600` (Hijau) |
| **2. Makanan** | [resources/views/public/templates/makanan.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/templates/makanan.blade.php#L188) | **Baris ~188** | `bg-amber-600` (Oranye Selera) | Ganti jadi `bg-red-600` (Merah) atau `bg-emerald-600` (Hijau) |
| **3. Jasa** | [resources/views/public/templates/jasa.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/templates/jasa.blade.php#L188) | **Baris ~188** | `bg-emerald-600` (Hijau Jasa) | Ganti jadi `bg-blue-600` (Biru Servis) |
| **4. Tokoh** | [resources/views/public/templates/tokoh.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/templates/tokoh.blade.php#L188) | **Baris ~188** | `bg-cyan-600` (Biru Muda Elegan) | Ganti jadi `bg-slate-900` (Hitam Formal) |
| **5. Barang** | [resources/views/public/templates/barang.blade.php](file:///c:/laragon/www/CMSWebBuilder_Hanan/resources/views/public/templates/barang.blade.php#L188) | **Baris ~188** | `bg-blue-600` (Biru Retail) | Ganti jadi `bg-rose-600` (Merah Diskon) |

---

## 🚀 Langkah Wajib Setelah Mengubah Kodingan Warna

Agar warna baru langsung muncul di layar browser penguji tanpa kendala:
1. Simpan file yang diedit di VS Code: Tekan **`Ctrl + S`**.
2. Beralih ke browser, lakukan **Hard Refresh**: Tekan tombol **`Ctrl + F5`** (atau `Ctrl + Shift + R`) agar browser membersihkan memori cache lama dan langsung merender warna baru!
3. **Selesai dalam waktu kurang dari 10 detik!** Penguji dijamin langsung kagum melihat kecepatan kerjamu.
