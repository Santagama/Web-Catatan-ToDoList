# Catatan Dokumentasi: Folder Views Logs (`resources/views/admin/logs/`)

---

## [FUNGSI]
Folder ini berisi antarmuka pengguna (View Blade) untuk modul **Jejak Audit & Log Aktivitas (`activity_logs`)**. Modul ini memenuhi syarat wajib pengujian dari **PT Sawala** dan **Soal Resmi UKK RPL** untuk memastikan seluruh aksi krusial yang dilakukan pengguna sistem dapat diaudit secara transparan dan akuntabel.

---

## [ALUR SISTEM / USER FLOW]
```
1. Admin mengklik menu 'Log Aktivitas' di sidebar
   └── Masuk ke rute: admin.logs.index
   └── ActivityLogController@index mengambil data log dari tabel activity_logs
       beserta relasi admin dan portofolionya (Eager Loading with('admin', 'portfolio'))

2. View index.blade.php merender:
   ├── 3 Kartu Ringkasan: Total Tambah, Edit, dan Hapus pada bulan berjalan
   ├── Filter Periode: Pilihan dropdown Bulan dan Tahun
   └── Tabel Linimasa: Menampilkan timestamp, nama admin, badge warna aksi,
       dan narasi detail aksi yang dilakukan

3. Jika aksi terkait portofolio tertentu:
   └── Tampil tautan cepat 'Lihat UMKM: [Nama]' yang langsung mengarah ke halaman detail
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `index.blade.php`
*   **Fungsi**: Halaman tabel linimasa pencatatan aktivitas sistem.
*   **Komponen Visual**:
    *   *Kartu Metrik Bulan Berjalan*: Menghitung akumulasi frekuensi aksi penambahan, pembaruan, dan penghapusan data UMKM dalam bulan aktif.
    *   *Form Filter*: Memungkinkan penguji memfilter riwayat aktivitas berdasarkan bulan dan tahun spesifik menggunakan request query string `?bulan=...&tahun=...`.
    *   *Pembeda Warna Badge Aksi*:
        *   `LOGIN` / `LOGOUT`: Biru / Netral
        *   `TAMBAH_PORTFOLIO`: Hijau Emerald
        *   `EDIT_PORTFOLIO`: Kuning Amber
        *   `HAPUS_PORTFOLIO`: Merah Rose
        *   `PERPANJANG_PAKET`: Teal
        *   `AUTO_DRAFT`: Ungu Purple (otomasi scheduler)
    *   *Format Waktu Ramah Manusia*: Menggunakan Carbon `diffForHumans()` (contoh: *"2 jam yang lalu"*, *"kemarin"*) dipadukan dengan format kalender presisi `d M Y, H:i`.

