# Catatan Dokumentasi: View Pengaturan Akun (`resources/views/admin/settings/`)

---

## 1. Apa itu File `index.blade.php` di Folder Settings? (Bahasa Santai)
Ini adalah halaman **Pengaturan Akun Pengelola & Tim Admin**! ⚙️
Di sini admin bisa:
1. Mengubah nama lengkap dan username miliknya.
2. Mengganti kata sandi lama ke kata sandi baru.
3. Menambahkan akun admin pengelola baru (Multi-User Admin).
4. Melihat tabel daftar seluruh admin terdaftar dan menghapus admin lain.

---

## 2. Fitur Keamanan Istimewa di Halaman Ini:
1.  **Proteksi Anti-Kudeta untuk Admin Utama**:
    *   Akun Founder (ID 1 / Hanan) memiliki lencana khusus bertuliskan *"Admin Utama (Founder)"* dan tombol hapusnya dinonaktifkan secara permanen (`cursor-not-allowed`) demi menjaga kedaulatan sistem.
2.  **Proteksi Anti-Self Delete**:
    *   Admin yang sedang login tidak bisa menghapus akunnya sendiri (muncul label *"Akun Anda"*).
3.  **Verifikasi Password Lama**:
    *   Admin tidak bisa langsung mengganti password baru tanpa mengetahui password lamanya terlebih dahulu.

---

## 3. 💡 Jawaban Mantap untuk Penguji:
> *"Modul Pengaturan ini menerapkan prinsip Role & Identity Management yang aman. Sistem melindungi akun Administrator Utama (ID 1) dari penghapusan dan mencegah self-deletion agar sistem tidak pernah kehilangan akun aktif."*
