# Catatan Dokumentasi: Folder Views Settings (`resources/views/admin/settings/`)

---

## [FUNGSI]
Folder ini berisi antarmuka pengguna (View Blade) untuk modul **Pengaturan Akun Administrator (`admin.settings`)**. Memfasilitasi admin untuk memperbarui profil identitas dirinya (Nama Lengkap, Username) serta mengganti kata sandi dengan mekanisme verifikasi kata sandi lama yang aman.

---

## [ALUR SISTEM / USER FLOW]
```
1. Admin mengklik menu 'Pengaturan Akun' di sidebar
   └── Masuk ke rute: admin.settings.index
   └── View index.blade.php menampilkan data nama dan username admin saat ini

2. Admin mengubah nama atau username, lalu klik Simpan
   └── Form mengirim HTTP PUT ke rute admin.settings.update
   └── SettingsController@update memvalidasi keunikan username baru
       (unique:admins,username,ID) agar tidak bentrok dengan akun lain

3. Admin ingin mengganti password baru:
   └── Mengisi 'Kata Sandi Saat Ini' dan 'Kata Sandi Baru' beserta konfirmasinya
   └── Sistem mencocokkan kata sandi lama menggunakan Hash::check()
       - Jika salah: Kembali ke form dengan pesan error
       - Jika cocok: Password baru dienkripsi otomatis dengan Bcrypt via Model Admin
   └── Aksi dicatat ke tabel activity_logs dengan keterangan 'GANTI_PENGATURAN'
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `index.blade.php`
*   **Fungsi**: Halaman formulir pembaruan kredensial dan profil admin.
*   **Fitur Keamanan**:
    *   *Verifikasi Password Dua Lapis*: Mengharuskan pengisian `current_password` sebelum kata sandi baru diterima.
    *   *Konfirmasi Kata Sandi*: Validasi `confirmed` di Laravel memastikan admin tidak salah mengetik kata sandi barunya.
    *   *Kartu Edukasi Bcrypt*: Teks informasi teknis tentang algoritma hashing satu arah Bcrypt untuk bahan penjelasan ke penguji.

