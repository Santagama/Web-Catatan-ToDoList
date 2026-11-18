# Alur Cerita Sistem: "Day in the Life" Bisnis CMS Web Builder UMKM

**Penyusun**: Hanan Aria Santagama (Kelas XII RPL 1 — SMKN 1 Majalengka)  
**Aplikasi**: CMS Web Builder — Platform Pembuatan Website Portofolio Instan untuk UMKM  
**Tujuan Dokumen**: Alur cerita realistis dari kacamata manusia (klien dan admin) yang **100% persis dengan tampilan dan kodingan aplikasi web kita saat ini**. Dokumen ini membuatmu bisa bercerita mengalir, santai, dan percaya diri saat wawancara dengan penguji industri!

---

## 🎭 Profil Karakter dalam Cerita

1. **Hanan Aria Santagama**: Siswa SMK jurusan RPL yang membuka jasa agensi pembuatan website katalog portofolio instan untuk UMKM lokal Majalengka. Hanan adalah **Super Admin (Admin ID: 1)** di web ini.
2. **Pak Budi**: Pemilik kedai kopi lokal di Majalengka bernama **"Kopi Sejahtera"**. Beliau ingin punya link katalog menu sendiri di bio Instagram dan status WhatsApp-nya agar pembeli bisa langsung pesan menu tanpa ribet tanya-tanya lewat chat manual.

---

## 📖 Bab 1: Pak Budi Menemukan Jasa Hanan & Membuka Landing Page

Suatu sore, Pak Budi melihat postingan promosi jasa pembuatan web instan oleh Hanan di Instagram. Pak Budi mengklik link di bio IG Hanan yang langsung membuka halaman utama:
👉 **URL**: `http://localhost:8000/`

### Apa yang Dilihat Pak Budi di Landing Page?
1. **Hero Section Bersih & Modern**:
   - Judul utama: *"Website Portofolio UMKM, 24 Jam Langsung Jadi."*
   - Subtitle: *"Kirim foto dan info produk via WhatsApp. Kami buatkan website instan yang estetik, cepat, dan siap dipakai..."*
2. **Katalog 5 Konsep Desain**:
   Pak Budi melihat 5 pilihan template yang sesuai dengan jenis usaha:
   - ☕ **01. Template Minuman**: Kedai Kopi & Minuman Segar
   - 🍲 **02. Template Makanan**: Restoran & Kuliner Makanan
   - 🛠️ **03. Template Jasa**: Studio & Layanan Servis
   - 👤 **04. Template Tokoh**: Personal Branding & Publik
   - 📦 **05. Template Barang**: Retail, Fashion & Produk Fisik
3. **Pilihan Paket Layanan yang Transparan**:
   Pak Budi melihat daftar harga yang terjangkau:
   - **Paket Starter**: **Rp 75.000 / 3 Bulan** (Pilihan ekonomis untuk mulai go-digital)
   - **Paket Pro Bisnis**: **Rp 200.000 / 1 Tahun Penuh** (Paling hemat 33%)
4. **Tombol Call-to-Action (CTA) WhatsApp**:
   Di tombol hijau tertulis: *"Pesan Website via WhatsApp"*. Pak Budi langsung mengkliknya!

---

## 💬 Bab 2: Transaksi & Pengiriman Aset Usaha via WhatsApp

Ketika Pak Budi menekan tombol WhatsApp di landing page, ponselnya otomatis membuka chat WA ke nomor Hanan (`0895324392999`) dengan pesan pembuka otomatis:
> *"Halo Developer CMSWebBuilder Hanan Aria Santagama, saya Pak Budi. Saya memerlukan informasi lebih lanjut dan tertarik untuk memesan pembuatan website portofolio profesional..."*

### Obrolan di WhatsApp:
- **Pak Budi**: *"Halo Mas Hanan, saya pemilik kedai kopi 'Kopi Sejahtera'. Saya mau pesan yang Paket Starter (3 Bulan seharga Rp 75.000) pakai Template Minuman, datanya apa saja yang perlu saya kirim?"*
- **Hanan**: *"Siap Pak Budi! Cukup transfer Rp 75.000 ke rekening saya, lalu kirimkan data profil usaha dan foto menunya ya Pak."*

Pak Budi mengirim bukti transfer dan mengisi format data sederhana:
- **Nama Usaha**: Kopi Sejahtera
- **Alamat URL (Slug) yang Diinginkan**: `kopi-sejahtera`
- **Profil Singkat / Bio**: *"Kedai kopi estetik di pusat kota Majalengka, menyajikan racikan biji kopi lokal pilihan dengan suasana nyaman."*
- **Nomor WhatsApp**: `081234567890`
- **Instagram**: `@kopisejahtera.mjl`
- **Alamat Toko**: Jl. KH. Abdul Halim No. 45, Majalengka
- **Link Google Maps**: `https://maps.google.com/...`
- **Foto Logo & Banner**: *(Pak Budi melampirkan file foto)*
- **Daftar Menu Produk Awal**:
  1. *Kopi Susu Gula Aren* — Rp 18.000 (Menu andalan racikan khas)
  2. *Caramel Macchiato* — Rp 22.000 (Espresso dengan saus karamel)
  3. *Americano Ice* — Rp 15.000 (Kopi hitam dingin segar)

Data sudah lengkap, sekarang saatnya Hanan mengeksekusi di laptopnya!

---

## 💻 Bab 3: Hanan Membuka Laptop & Login ke Panel Admin

Hanan membuka laptopnya, membuka browser ke `http://localhost:8000`, lalu mengklik tombol **"Login Admin"** di navbar pojok kanan atas:
👉 **URL**: `http://localhost:8000/admin/login`

### Proses Login:
1. Hanan memasukkan **Username**: `admin` dan **Password**: `password`.
2. Klik tombol **"Masuk ke Dashboard"**.
3. Sistem memverifikasi kredensial. Jika cocok, sesi login aktif dibuat dan Hanan langsung masuk ke halaman utama:
👉 **URL**: `http://localhost:8000/admin/dashboard`

### Apa yang Ada di Dashboard Hanan?
- **4 Kartu Metrik Statistik**: Total Portofolio, Portofolio Publish, Portofolio Draft, dan Portofolio Expired.
- **Banner Peringatan Kuning**: Memberitahu otomatis jika ada UMKM yang masa aktifnya tersisa $\le 3$ hari.
- **Tabel 5 Portofolio Terbaru & Log Aktivitas**: Memantau aktivitas input data terakhir.

---

## 📝 Bab 4: Input Data UMKM & Fitur Cek Slug Realtime

Hanan mengklik tombol **"+ Buat Web Baru"** di dashboard untuk menginputkan data pesanan Pak Budi:
👉 **URL**: `http://localhost:8000/admin/portfolios/create`

### Langkah-langkah yang Dilakukan Hanan di Formulir:
1. **Pilih Template**: Hanan mengklik radio card **"Minuman"** (ikon cangkir kopi).
2. **Ketik Nama UMKM & Sihir Auto-Slug AJAX**:
   - Hanan mengetik di kolom Nama UMKM: `Kopi Sejahtera`.
   - **Fitur Cerdas JavaScript**: Kolom Slug di bawahnya otomatis terisi sendiri menjadi `kopi-sejahtera`.
   - Di latar belakang (tanpa refresh), sistem mengirim pertanyaan singkat ke rute `/api/check-slug` untuk mengecek ke database apakah nama `kopi-sejahtera` sudah dipakai orang lain atau belum.
   - Karena belum ada, langsung muncul teks hijau: *"✓ Slug tersedia dan siap digunakan"*.
3. **Isi Bio, WhatsApp, Instagram, Alamat & Maps**:
   - Hanan menyalin bio, nomor WA `081234567890`, Instagram `@kopisejahtera.mjl`, alamat jalan, dan link iframe embed Google Maps.
4. **Upload Foto Logo & Banner (Live Preview)**:
   - Hanan memilih file foto logo dan banner Pak Budi. Begitu file dipilih, langsung muncul preview gambar di layar untuk memastikan gambar tidak salah.
5. **Tambah Produk Dinamis**:
   - Di bagian Daftar Produk, sudah ada form produk pertama. Hanan menginputkan nama *"Kopi Susu Gula Aren"*, harga `18000`, upload foto, dan deskripsi singkat.
   - Hanan mengklik tombol **"+ Tambah Produk"** 2 kali lagi tanpa reload halaman untuk memasukkan *Caramel Macchiato* dan *Americano Ice*.
6. **Pilih Paket & Status Terbit**:
   - Di dropdown **Paket Durasi Langganan**, Hanan memilih **"3 Bulan (Trial 90 Hari)"** sesuai pesanan Pak Budi. Sistem akan otomatis menghitung tanggal expired 90 hari ke depan.
   - Di dropdown **Status Publikasi**, Hanan memilih **"Publish"**.
7. **Klik "Simpan Portofolio"**:
   - Laravel memvalidasi semua input, menyimpan foto ke disk public, menyimpan daftar 3 produk tadi ke dalam kolom JSON `products`, dan mencatat aksi ini ke tabel `activity_logs`.
   - Hanan diarahkan kembali ke daftar portofolio dengan pesan sukses!

---

## 🌐 Bab 5: Serah Terima Website & Uji Tombol WhatsApp

Hanan membuka link website Pak Budi yang baru jadi untuk memastikan semuanya rapi:
👉 **URL**: `http://localhost:8000/kopi-sejahtera`

### Apa yang Terjadi di Layar?
1. **Tampilan Elegan Template Minuman**: Muncul foto banner kedai, logo kopi, nama "Kopi Sejahtera", bio, dan tombol sosial media.
2. **Katalog 3 Menu Kopi**: Kartu menu kopi tampil rapi dengan badge harga (misal: *Rp 18.000*).
3. **Tombol "Pesan via WhatsApp" di Setiap Menu**:
   - Hanan mencoba mengklik tombol pesan pada menu *Kopi Susu Gula Aren*.
   - Browser otomatis membuka WhatsApp ke nomor Pak Budi (`081234567890`) dengan format pesan yang sudah otomatis terisi:
     > *"Halo Kopi Sejahtera, saya ingin memesan Kopi Susu Gula Aren seharga Rp 18.000. Apakah masih tersedia?"*
4. **Peta Google Maps**: Di bagian bawah halaman, peta lokasi kedai kopi Pak Budi tampil interaktif.

Hanan mengirim pesan WhatsApp ke Pak Budi:
> *"Selamat Pak Budi, website portofolio Kopi Sejahtera sudah online dan aktif selama 3 bulan ke depan! Ini link resminya: http://localhost:8000/kopi-sejahtera. Silakan dipasang di bio Instagram dan status WA ya Pak!"*

Pak Budi sangat senang karena kedai kopinya sekarang terlihat profesional dan pelanggan bisa langsung pesan menu favorit mereka!

---

## ⏰ Bab 6: Monitoring Masa Aktif (Sisa 3 Hari) & Perpanjangan Paket

Waktu berjalan... Setelah 87 hari berlalu, masa aktif paket 3 bulan Kopi Sejahtera tersisa 3 hari lagi.

### Apa yang Terjadi di Sistem?
1. **Peringatan Otomatis di Dashboard Hanan**:
   - Saat Hanan membuka Dashboard Admin, muncul **Banner Peringatan Kuning**:
     > *"⚠️ Perhatian: Terdapat 1 portofolio UMKM yang akan segera kedaluwarsa dalam waktu kurang dari 3 hari!"*
   - Nama "Kopi Sejahtera" tertera dengan sisa waktu: *"3 hari lagi"*.
2. **Hanan Menghubungi Pak Budi**:
   - Hanan mengirim pesan WA: *"Halo Pak Budi, paket website Kopi Sejahtera sisa 3 hari lagi nih. Mau sekalian diperpanjang?"*
   - Pak Budi menjawab: *"Alhamdulillah Mas Hanan, penjualan kopi saya meningkat sejak pakai web itu! Saya mau perpanjang langsung ambil Paket 1 Tahun (Rp 200.000) ya Mas."*

### Skenario A (Pak Budi Memperpanjang Paket):
1. Pak Budi mentransfer biaya perpanjangan Rp 200.000.
2. Hanan membuka menu Portofolio $\rightarrow$ klik tombol **Detail (Mata)** pada Kopi Sejahtera (`/admin/portfolios/1`).
3. Di bagian kartu **"Perpanjangan Masa Aktif"**, Hanan memilih opsi **"1 Tahun"** lalu mengklik tombol **"Perpanjang Paket Sekarang"**.
4. Tanggal kedaluwarsa otomatis bertambah 1 tahun (365 hari) di atas tanggal lama, status tetap **Publish**, dan sistem mencatat log audit `PERPANJANG_PAKET`.

### Skenario B (Jika Klien Tidak Memperpanjang / Telat Bayar):
- Bagaimana jika klien tidak memperpanjang sampai lewat batas tanggal?
- **Otomasi Task Scheduler Laravel**: Tepat pukul **00:00 tengah malam**, server menjalankan skrip scheduler di `routes/console.php`. Sistem mendeteksi `expired_at < now()`, lalu otomatis mengubah status toko menjadi **Draft** dan mencatat log audit `AUTO_DRAFT`.
- Jika ada pembeli yang membuka link `http://localhost:8000/kopi-sejahtera`, web **TIDAK BISA DIBUKA** (otomatis muncul 404 Not Found). Data Pak Budi tetap tersimpan aman di database dan bisa diaktifkan lagi kapan saja saat Pak Budi membayar!

---

## 🔄 Bab 7: Rebranding Usaha & Fitur Canggih SEO 301 Redirect

Suatu hari, kedai Pak Budi membuka cabang baru dan ingin mengubah nama toko serta URL-nya:
- Nama Lama: `Kopi Sejahtera` (Slug: `/kopi-sejahtera`)
- Nama Baru: `Kopi Sejahtera Majalengka` (Slug Baru: `/kopi-sejahtera-majalengka`)

Pak Budi khawatir: *"Mas Hanan, di gelas cup kopi saya yang lama kan sudah tercetak link /kopi-sejahtera, nanti kalau pelanggan lama buka link itu jadi error dong?"*

Hanan menjawab: *"Tenang Pak Budi, sistem kami punya fitur **SEO 301 Permanent Redirect**. Link lama bapak otomatis dialihkan ke link baru!"*

### Apa yang Terjadi di Sistem?
1. Hanan membuka form Edit Portofolio Kopi Sejahtera, mengubah slug menjadi `kopi-sejahtera-majalengka`, lalu klik **"Simpan Perubahan"**.
2. Di balik layar, Controller mendeteksi perubahan slug dan **otomatis mencatat slug lama ke tabel `slug_histories`**.
3. **Uji Coba di Browser:**
   - Ketika pelanggan lama mengetik link lama: `http://localhost:8000/kopi-sejahtera`.
   - Browser **TIDAK menampilkan 404**!
   - Dalam hitungan milidetik, alamat di browser otomatis berganti sendiri menjadi `http://localhost:8000/kopi-sejahtera-majalengka` dengan status HTTP 301 (Moved Permanently)! Pelanggan tetap bisa pesan kopi seperti biasa!

---

## 🚫 Bab 8: Pengunjung Nyasar / Salah Ketik URL (Halaman 404)

Jika ada pengunjung iseng yang mengetik alamat yang tidak pernah terdaftar di database:
👉 Ketik URL ngawur: `http://localhost:8000/toko-palsu-ngawur`

### Respon Sistem:
1. Controller mencari di tabel `portfolios` $\rightarrow$ tidak ada.
2. Controller mencari di tabel riwayat `slug_histories` $\rightarrow$ tidak ada.
3. Sistem memanggil fungsi `abort(404)`.
4. Browser menampilkan **Halaman Khusus 404 Not Found** yang estetik:
   - Ada angka **404** besar.
   - Penjelasan ramah: *"Oops! Halaman Portofolio Tidak Ditemukan. Halaman yang Anda cari mungkin salah ketik, sudah dihapus, atau paket masa aktifnya telah berakhir."*
   - Tombol **"Kembali ke Beranda"** yang mengarahkan pengunjung kembali ke landing page dengan selamat.

---

## 🛡️ Bab 9: Keamanan Akun Multi-Admin & Fitur Anti-Kudeta Super Admin

Karena pesanan web semakin banyak, Hanan mendaftarkan temannya sebagai staf admin pembantu di menu **Pengaturan** (`/admin/settings`):
- Mengisi nama staf, username, email, dan password.
- Klik **"Daftarkan Admin"**.

### Fitur Proteksi Super Admin (Anti-Kudeta):
- Akun Hanan terdaftar sebagai **Admin ID: 1 (Super Admin)**.
- Di tabel daftar admin, tombol hapus pada akun Hanan dikunci dengan label *"Super Admin (Akun Utama)"*.
- Jika ada staf admin yang mencoba menghapus akun Hanan lewat celah inspect element atau request paksa, Controller di backend memiliki baris pengaman:
  ```php
  if ($admin->id === 1) {
      return back()->with('error', 'Akun Utama tidak boleh dihapus!');
  }
  ```
  Upaya hapus akun utama langsung digagalkan sistem!

### Keamanan Logout & Anti-Back History:
- Begitu selesai bekerja, Hanan mengklik tombol merah **"Keluar (Logout)"**.
- Sistem menghapus sesi login dan meregenerasi token CSRF.
- Jika ada orang lain yang menekan tombol **"Back" (Panah Kiri)** di browser, layar **TIDAK AKAN** memunculkan kembali halaman dashboard admin karena adanya middleware khusus `PreventBackHistory` yang mematikan cache browser (*No-Cache, No-Store*).
