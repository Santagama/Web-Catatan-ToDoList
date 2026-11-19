# Catatan Dokumentasi: View Activity Log (`resources/views/admin/logs/`)

---

## 1. Apa itu File `index.blade.php` di Folder Logs? (Bahasa Santai)
Ini adalah halaman **Buku Catatan Sejarah (Audit Trail)**! 📜  
Setiap kali ada aksi penting yang dilakukan di dalam sistem:
- Admin login atau logout
- Menambah website UMKM baru
- Mengubah/edit data UMKM
- Menghapus website UMKM
- Memperpanjang paket langganan
- Sistem otomatis menonaktifkan toko expired (Auto-Draft jam 00:00)

Semua jejak aksinya tercatat otomatis di sini lengkap dengan tanggal, jam, menit, nama admin pelakunya, dan keterangan detail kejadiannya.

---

## 2. Fitur-Fitur Keren di Halaman Ini:

1. **Filter Periode Dinamis (Bulan & Tahun)**:
   * Penguji bisa memilih dropdown bulan (Januari – Desember) dan dropdown tahun (contoh: 2026, 2025, 2024).
   * Tombol *"Terapkan"* mengeksekusi filter, dan ada tombol *"Reset"* untuk mengembalikan ke tampilan awal.

2. **4 Kartu Statistik Cerdas (Ikut Berubah Sesuai Filter)**:
   * **TOTAL**: Menghitung seluruh aksi admin pada periode yang dipilih.
   * **TAMBAH**: Menghitung berapa kali portofolio baru diterbitkan pada periode tersebut.
   * **EDIT**: Menghitung berapa kali data portofolio diperbarui pada periode tersebut.
   * **HAPUS**: Menghitung berapa kali portofolio dihapus pada periode tersebut.
   * 🌟 **Kelebihan Baru**: Kartu-kartu ini **TIDAK LAGI macet di bulan berjalan**, melainkan **100% dinamis mengikuti filter dropdown** yang sedang dipilih oleh admin!

3. **Lencana (Badge) Aksi Berwarna Kontras**:
   * `TAMBAH_PORTFOLIO`: Badge Hijau Teal
   * `EDIT_PORTFOLIO`: Badge Biru Cyan
   * `HAPUS_PORTFOLIO`: Badge Merah Rose
   * `LOGIN` / `LOGOUT`: Badge Netral Abu-abu
   * `AUTO_DRAFT`: Badge Sistem Scheduler

4. **Keterangan Waktu Bahasa Indonesia Bersih**:
   * Format tanggal rapi menggunakan library Carbon bahasa Indonesia:  
     Contoh: `Kamis, 19 November 2026, 08:30 WIB`.

---

## 3. 💡 Jawaban Mantap Saat Ditanya Penguji:

**Pertanyaan Penguji:**  
*"Hanan, bagaimana cara kerja filter periode dan kartu statistik di Activity Log ini?"*

**Jawaban Percaya Diri Hanan:**
> *"Di halaman Activity Log ini, kami menerapkan filter pencarian dinamis berbasis query string `bulan` dan `tahun` di `ActivityLogController@index`.*
> 
> *Saat tombol 'Terapkan' ditekan, sistem tidak hanya menyaring linimasa riwayat log di bawah, tetapi juga **secara dinamis mengkalkulasi ulang 4 kartu metrik di atas** (Total, Tambah, Edit, Hapus) menggunakan query agregat `count()` yang disinkronkan dengan bulan dan tahun yang dipilih.*
> 
> *Tujuannya agar admin dapat memantau produktivitas tim secara akurat pada periode bulan atau tahun tertentu."*
