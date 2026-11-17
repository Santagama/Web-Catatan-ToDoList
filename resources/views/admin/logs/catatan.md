# Catatan Dokumentasi: View Activity Log (`resources/views/admin/logs/`)

---

## 1. Apa itu File `index.blade.php` di Folder Logs? (Bahasa Santai)
Ini adalah halaman **Buku Catatan Sejarah (Audit Trail)**! 📜
Setiap kali ada admin yang:
- Login atau Logout
- Menambah UMKM baru
- Mengubah data UMKM
- Menghapus UMKM
- Menambah admin baru
Semua aksinya tercatat otomatis di sini lengkap dengan jam, menit, detik, nama pelakunya, dan keterangan kejadiannya.

---

## 2. Fitur-Fitur Keren di Halaman Ini:
1.  **Filter Periode Bulan & Tahun**:
    *   Penguji bisa memilih dropdown bulan (Januari - Desember) dan tahun untuk memfilter riwayat aksi secara fleksibel.
2.  **4 Kartu Angka Statistik**:
    *   Menghitung akumulasi total aksi bulan ini: Berapa total aksi, berapa yang ditambah, berapa yang diedit, dan berapa yang dihapus.
3.  **Warna Lencana (Badge) yang Berbeda**:
    *   `LOGIN` / `LOGOUT`: Biru
    *   `TAMBAH_PORTFOLIO`: Hijau
    *   `EDIT_PORTFOLIO`: Kuning
    *   `HAPUS_PORTFOLIO`: Merah
    *   `AUTO_DRAFT`: Ungu (otomasi task scheduler Laravel)
4.  **Waktu Ramah Manusia**:
    *   Menggunakan fungsi Carbon `diffForHumans()` seperti *"5 menit yang lalu"* atau *"2 jam yang lalu"* sehingga sangat mudah dibaca.

---

## 3. 💡 Jawaban Mantap untuk Penguji:
> *"Modul Activity Log ini kami sediakan untuk memenuhi standar transparansi sistem. Setiap operasi CRUD dan otentikasi terekam secara otomatis ke tabel `activity_logs` dan ditampilkan dalam bentuk linimasa interaktif lengkap dengan filter periode."*
