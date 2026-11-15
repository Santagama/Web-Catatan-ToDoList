# **UJI KOMPETENSI KEAHLIAN**

# **TAHUN PELAJARAN 2026/2027**

## **SOAL PRAKTIK KEJURUAN**

**Satuan Pendidikan** : Sekolah Menengah Kejuruan  
**Konsentrasi Keahlian** : Rekayasa Perangkat Lunak  
**Alokasi Waktu** : 8 Jam x 3 Hari  
**Bentuk Soal** : Penugasan Perorangan  
**Judul Tugas** : Pengembangan Platform Web Portofolio UMKM

## **I. PETUNJUK UMUM**

1. Periksalah dengan teliti dokumen soal ujian praktik, yang terdiri dari 4 halaman  
2. Periksalah peralatan dan bahan yang dibutuhkan  
3. Gunakan peralatan utama dan peralatan keselamatan kerja yang telah disediakan  
4. Gunakan peralatan sesuai dengan SOP (Standard Operating Procedure)  
5. Bekerjalah dengan memperhatikan petunjuk Pembimbing/Penguji

## **II. DAFTAR PERALATAN**

| No. | Nama Alat dan Bahan | Spesifikasi Minimal | Jumlah | Keterangan |
| :---- | :---- | :---- | :---- | :---- |
| **ALAT** |  |  |  |  |
| 1 | PC Client/Laptop | Processor: Setara 2,0 GHz, RAM: 4 GB Harddisk, NIC: 10/100 Mbps, Monitor 14", Mouse, Keyboard | 1 set |  |
| 2 | Koneksi Internet | Minimal 1 Mbps | 1 line |  |
| **KOMPONEN** |  |  |  |  |
| 1 | Sistem Operasi | Sesuai Kebutuhan | 1 unit |  |
| 2 | Text Editor/Tools Pemrograman | Sesuai Kebutuhan | 1 unit |  |
| 3 | Aplikasi Server Basis Data | Sesuai Kebutuhan | 1 unit |  |
| 4 | Debugging Tools | Sesuai Kebutuhan | 1 unit |  |
| 5 | Aplikasi Pengolahan Kata | Sesuai Kebutuhan | 1 unit |  |

## **IV. SOAL/TUGAS**

**Judul Tugas:** Pengembangan Platform Web Portofolio UMKM

**Tugas Praktik :**  
Sebuah usaha jasa digital menyediakan layanan pembuatan website portofolio instan (satu halaman) untuk membantu digitalisasi UMKM, dengan model layanan Done-For-You (Terima Beres): UMKM tidak perlu mendaftar maupun login ke sistem, cukup mengirimkan data usaha melalui WhatsApp kepada Admin, dan Admin yang menerbitkan website tersebut melalui dashboard.

Anda ditugaskan sebagai seorang Pemrogram pada perusahaan tersebut untuk membangun Platform Web Portofolio UMKM yang terdiri dari sebuah dashboard Admin (satu pintu akses) dan halaman portofolio publik yang dapat diakses oleh pengunjung melalui URL/slug unik, dengan fitur sebagai berikut:

### **Tabel Fitur Platform Web Portofolio UMKM**

| Fitur | Admin | Pengunjung Publik |
| :---- | :---- | :---- |
| Login | V |  |
| Logout | V |  |
| CRUD data akun Admin | V |  |
| CRUD data portofolio UMKM (profil usaha, bio, kontak, logo) | V |  |
| Validasi ketersediaan slug/URL sebelum simpan | V |  |
| Menerbitkan (publish) halaman portofolio UMKM | V |  |
| Log aktivitas perubahan data portofolio | V |  |
| Mengakses halaman portofolio UMKM melalui URL/slug |  | V |
| Melihat notifikasi halaman tidak ditemukan (404) untuk slug tidak valid |  | V |

### **Langkah Kerja:**

1. Buatlah struktur data dan akses terhadap struktur data termasuk dengan tipe data dan control program untuk aplikasi  
2. Gunakan metode Waterfall sederhana atau prototype:  
   a. Analisis Kebutuhan  
   b. Desain (ERD dan diagram program)  
   c. Implementasi kode  
   d. Pengujian  
   e. Dokumentasi  
3. Buatlah deskripsi dan diagram alur (flowchart) atau pseudocode untuk minimal:  
   a. Proses login Admin ke dashboard  
   b. Proses input data, validasi ketersediaan slug/URL, dan penerbitan (publish) halaman portofolio UMKM  
   c. Proses akses publik halaman portofolio berdasarkan slug/URL, termasuk penanganan slug yang tidak ditemukan (404)  
4. Buat dokumentasi terpisah untuk setiap modul (tuliskan input, proses dan output) untuk setiap proses beserta fungsi, prosedur dan method.  
5. Dengan menggunakan ERD yang dibuat dari poin 2 silahkan mulai membuat database (minimal tabel admins dan portfolios)  
6. Pada database, buat tabel yang sesuai dengan fitur, lakukan operasi relasional, stored procedure, function, trigger serta perintah commit dan rollback.  
7. Buat Folder projek, jalankan semua aplikasi yang programmer perlukan  
8. Buatlah aplikasi dengan memperhatikan Coding Guidelines dan Best Practices. Perhatikan:  
   a. Pastikan halaman memuat dengan cepat (gunakan query yang efisien)  
   b. Hindari looping yang tidak perlu  
   c. Gunakan limit ketika menggunakan data besar  
9. Tentukan kebutuhan uji coba  
   Contoh: berisi kasus dan hasil, misal:  
   Kasus: login dengan username dan password yang salah  
   Hasil: Gagal, tidak dapat login dan muncul notifikasi  
   Minimal 5 skenario uji berikut:  
   a. Login Admin  
   b. Tambah data portofolio UMKM baru  
   c. Validasi slug/URL yang sudah dipakai (duplikat)  
   d. Akses halaman portofolio publik dengan slug yang valid  
   e. Akses halaman portofolio publik dengan slug yang tidak ditemukan (404)  
10. Lakukan Pengujian dengan test case yang sudah dibuat  
11. Buat Laporan Singkat:  
    a. Fitur yang sudah berjalan dengan baik  
    b. Bug yang belum diperbaiki  
    c. Rencana Pengembangan berikutnya

## **Hasil yang diharapkan**

Hasil yang diharapkan dari rangkaian kerja di atas adalah terbuatnya Platform Web Portofolio UMKM sesuai dengan ketentuan fitur, dibuktikan dengan pengumpulan :

1. Folder Proyek Aplikasi (kode program lengkap)  
2. Database dengan ekstensi .sql  
3. Dokumentasi :  
   a. ERD  
   b. Deskripsi Program  
   c. Dokumentasi fungsi/prosedur  
   d. Debugging  
   e. Pengujian dan Tangkapan Layar hasil uji  
4. Laporan evaluasi singkat

*"SELAMAT & SUKSES"*

## **LAMPIRAN**

**1\. Deskripsi Tampilan Ilustrasi Admin Panel (Dashboard):**

* URL: `app.portofolio.id/dashboard`  
* Header: "Selamat Datang, Admin"  
* Metrik / Statistik:  
  * Total UMKM: 150  
  * Website Aktif: 145  
  * Permintaan Baru: 3  
* Menu Samping: Dashboard, Portofolio UMKM, Daftar Klien, Aktivitas Terbaru, Pengaturan.  
* Form "Buat Portofolio UMKM Baru":  
  * Nama Usaha (contoh: Kopi Kita)  
  * Slug URL (contoh: `portofolio.id/kopi-kita`)  
  * Bio / Portofolio ("Ceritakan tentang usaha Anda, produk unggulan...")  
  * Unggah Logo UMKM  
  * Nomor WhatsApp (contoh: \+62 812 3456 789\)  
  * Tombol: "Terbitkan Website Portofolio"  
* Tabel Ringkasan Data UMKM:  
  * Kolom: Nama UMKM, Link URL, Status, Aksi  
  * Data contoh:  
    * Kopi Kita \| `draft.portofolio.id/kopikita` \| Aktif  
    * Batik Indah \| `portofolio.id/batikindah` \| Aktif  
    * Kue Lezat \| `kuelezat.com` \| Draft

**2\. Deskripsi Tampilan Ilustrasi Web UMKM (Halaman Publik):**

* URL: `webmu.com/kue-enak-bu-sri`  
* Logo / Brand: "Kue Enak Bu Sri"  
* Hero Section:  
  * Judul: "Spesialis Kue Basah & Kering di Jakarta"  
  * Deskripsi: "Kami menyediakan aneka kue lezat buatan rumah dengan bahan berkualitas terbaik. Sejak 2020\. Terima pesanan untuk acara\!"  
  * Foto sajian aneka kue  
* Bagian Produk Unggulan:  
  * Lapis Legit  
  * Kastengel  
  * Putri Salju  
  * Brownies  
* Call to Action (CTA): Tombol "Pesan Sekarang lewat WhatsApp"

