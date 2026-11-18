# Panduan & Contekan Pasang Popup Konfirmasi (Umpan Ujikom)

**Siswa**: Hanan Aria Santagama (XII RPL 1)  
**Tujuan**: Menghapus popup terlebih dahulu sebagai **umpan kesalahan yang disengaja**, lalu memasangnya kembali secara kilat (10-15 detik) saat disuruh oleh penguji UKK.

---

## ⚡ Status Saat Ini:
Seluruh popup konfirmasi di bawah ini **SUDAH DIKOSONGKAN**.  
Di dalam file kodingannya, sudah disediakan ruang kosong berjarak dengan tanda komentar:
```html
{{-- // TEMPAT KODE POPUP KONFIRMASI ... DI SINI // --}}
```
Kamu tinggal membuka file dan baris yang dimaksud, lalu menempelkan (*paste*) kodingannya tepat di area komentar tersebut!

---

## 📌 DAFTAR 3 LOKASI POPUP & KODINGANNYA:

### 1. Hapus Portofolio UMKM (Menu Direktori Web)
* **File Target**:  
  `resources/views/admin/portfolios/index.blade.php`
* **Perkiraan Posisi**: Sekitar **Baris 180**
* **Cari Teks**:
  ```html
  <form action="{{ route('admin.portfolios.destroy', $porto->id) }}" method="POST"
        
        {{-- // TEMPAT KODE POPUP KONFIRMASI HAPUS PORTOFOLIO DI SINI // --}}

  >
  ```
* **Kodingan yang Harus Di-Paste**:
  ```html
  onsubmit="return confirm('Yakin ingin menghapus portofolio website ini?');"
  ```

---

### 2. Hapus Admin (Menu Pengaturan > Daftar Admin Aktif)
* **File Target**:  
  `resources/views/admin/settings/index.blade.php`
* **Perkiraan Posisi**: Sekitar **Baris 330**
* **Cari Teks**:
  ```html
  <form action="{{ route('admin.settings.admins.destroy', $item->id) }}" method="POST" class="inline-block"

        {{-- // TEMPAT KODE POPUP KONFIRMASI HAPUS ADMIN DI SINI // --}}

  >
  ```
* **Kodingan yang Harus Di-Paste**:
  ```html
  onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini? Tindakan ini tidak dapat dibatalkan.');"
  ```

---

### 3. Tombol Logout (Sidebar Kiri Bawah)
* **File Target**:  
  `resources/views/layouts/admin.blade.php`
* **Perkiraan Posisi**: Sekitar **Baris 110**
* **Cari Teks**:
  ```html
  <form action="{{ route('admin.logout') }}" method="POST"

        {{-- // TEMPAT KODE POPUP KONFIRMASI LOGOUT DI SINI // --}}

  >
  ```
* **Kodingan yang Harus Di-Paste**:
  ```html
  onsubmit="return confirm('Yakin ingin keluar dari sesi admin?');"
  ```

---

### *(Bonus Tambahan) 4. Tombol Hapus di Halaman Detail Portofolio*
* **File Target**:  
  `resources/views/admin/portfolios/show.blade.php`
* **Perkiraan Posisi**: Sekitar **Baris 80**
* **Kodingan yang Di-Paste**:
  ```html
  onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini secara permanen?');"
  ```

---

## 🚀 Langkah Kilat di Depan Penguji (Hanya 10-15 Detik!):

1. **Penguji**: *"Loh Hanan, ini tombol hapusnya belum ada konfirmasi ya? Kalau nggak sengaja kepencet langsung hilang datanya dong! Coba kamu tambahin popup konfirmasi!"*
2. **Hanan**: *"Baik Pak/Bu, siap saya tambahkan sekarang."*
3. **Aksi Hanan**:
   - Buka VS Code / text editor.
   - Buka file yang diminta penguji (misal: `index.blade.php` untuk direktori web).
   - Cari baris yang ada komentar `{{-- // TEMPAT KODE POPUP... // --}}`.
   - Ketik atau paste:
     ```html
     onsubmit="return confirm('Yakin ingin menghapus portofolio website ini?');"
     ```
   - Tekan **Ctrl + S** (Save).
   - Kembali ke browser, tekan **F5 / Refresh**.
   - Klik lagi tombol hapus di depan penguji $\rightarrow$ **Muncul Kotak Dialog Peringatan Browser!**
4. **Hasil**: Penguji langsung puas karena kamu bisa memperbaiki dan menambahkan fitur tersebut dalam hitungan detik tanpa ragu-ragu!
