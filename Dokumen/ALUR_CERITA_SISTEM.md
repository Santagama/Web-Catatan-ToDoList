# Alur Cerita Sistem: "Day in the Life" Bisnis CMS Web Builder UMKM

**Penyusun**: Hanan Aria Santagama (Kelas XII RPL 1 — SMKN 1 Majalengka)  
**Proyek**: CMS Web Builder — Platform Pembuatan Website Portofolio Instan untuk UMKM  
**Tujuan Dokumen**: Panduan alur bisnis realistis dari kacamata manusia (klien dan admin) agar saat ujian wawancara/demonstrasi sistem, kamu bisa menceritakan web ini mengalir seperti sebuah cerita bisnis nyata yang profesional!

---

## 🎭 Profil Karakter dalam Cerita

1. **Hanan Aria Santagama**: Siswa SMK jurusan RPL yang membuka jasa agensi digital pembuatan website portofolio instan untuk UMKM lokal di Majalengka. Hanan bertindak sebagai **Super Admin (Admin ID: 1)** di sistem web ini.
2. **Pak Budi**: Pemilik kedai kopi lokal bernama **"Kopi Sejahtera"** di Majalengka. Beliau ingin usahanya go-digital punya link katalog menu sendiri di bio Instagram dan WhatsApp Bisnisnya, tetapi tidak paham coding dan tidak punya biaya besar untuk menyewa programmer jutaan rupiah.

---

## 📖 Bab 1: Pak Budi Menemukan Jasa Hanan di Instagram & Membuka Landing Page

Suatu sore, Pak Budi sedang scroll Instagram dan melihat postingan promosi dari Hanan:
> *"Mau UMKM Anda punya website katalog menu modern yang bisa langsung order via WhatsApp cuma dalam hitungan menit? Klik link di bio!"*

Pak Budi tertarik lalu mengklik link yang tertera di bio IG Hanan, yang langsung mengarah ke halaman utama sistem:
👉 **URL**: `http://localhost:8000/`

### Apa yang dialami Pak Budi di Landing Page?
1. **Hero Section Modern**: Pak Budi disambut dengan judul mencolok: *"Bantu UMKM Majalengka Naik Kelas dengan Website Portofolio Instan"*.
2. **Lihat Contoh Web yang Sudah Jadi (Showcase)**: Pak Budi melihat kartu-kartu UMKM lain yang sudah dibuatkan web oleh Hanan (misal: Toko Roti, Bengkel Motor, Salon).
3. **Eksplorasi 5 Katalog Template Desain**: Pak Budi melihat 5 pilihan desain template:
   - ☕ **Template Minuman**: Cocok untuk kafe, boba, kopi, dan jus.
   - 🍲 **Template Makanan**: Cocok untuk resto, warteg, katering, dan bakery.
   - 📦 **Template Barang**: Cocok untuk distro baju, kerajinan tangan, dan toko kelontong.
   - 👤 **Template Tokoh**: Cocok untuk profil personal, konsultan, dan seniman.
   - 🛠️ **Template Jasa**: Cocok untuk bengkel servis, laundry, dan cuci mobil.
4. **Tabel Harga Paket yang Jelas**: Pak Budi melihat daftar paket berlangganan:
   - **Paket 1 Bulan**: Rp 50.000
   - **Paket 6 Bulan**: Rp 250.000 *(Paling Populer & Hemat)*
   - **Paket 1 Tahun**: Rp 450.000
5. **Tombol Call-to-Action (CTA) WhatsApp**: Di bagian bawah, ada tombol hijau mencolok *"Konsultasi & Buat Web Sekarang"*. Pak Budi langsung mengkliknya!

---

## 💬 Bab 2: Transaksi & Pengiriman Aset Usaha via WhatsApp

Saat Pak Budi menekan tombol CTA di landing page, ponselnya otomatis membuka aplikasi WhatsApp dengan pesan pembuka yang sudah terisi otomatis:
> *"Halo Hanan, saya tertarik ingin membuat website portofolio untuk usaha saya dari website Web Builder..."*

### Obrolan WhatsApp Antara Pak Budi dan Hanan:
- **Pak Budi**: *"Halo Mas Hanan, saya punya kedai kopi 'Kopi Sejahtera'. Saya mau ambil Paket 6 Bulan pakai Template Minuman, gimana caranya?"*
- **Hanan**: *"Siap Pak Budi! Totalnya Rp 250.000 untuk masa aktif 6 bulan. Silakan transfer ke rekening BCA / DANA saya. Setelah itu cukup kirimkan data dan foto-foto produknya ya Pak."*

Pak Budi mengirim bukti transfer. Kemudian Hanan mengirimkan formulir isian sederhana di chat WhatsApp:
- **Nama Usaha**: Kopi Sejahtera
- **Alamat URL yang Diinginkan (Slug)**: `kopi-sejahtera`
- **Profil Singkat / Bio**: *"Kedai kopi estetik di pusat kota Majalengka, menyajikan kopi biji lokal pilihan dengan suasana nyaman untuk nugas dan santai."*
- **Alamat Toko**: Jl. KH. Abdul Halim No. 45, Majalengka
- **Nomor WhatsApp Pemesanan**: `081234567890`
- **Link Google Maps**: `https://maps.google.com/...`
- **Foto Logo & Banner Kafe**: *(Pak Budi melampirkan file foto)*
- **Daftar Menu & Harga**:
  1. *Kopi Susu Gula Aren* — Rp 18.000 (Best Seller racikan khas)
  2. *Caramel Macchiato* — Rp 22.000 (Espresso dengan saus karamel gurih)
  3. *Americano Ice* — Rp 15.000 (Kopi hitam dingin segar)
  4. *Croissant Butter* — Rp 20.000 (Pastry renyah pendamping kopi)

Semua data sudah lengkap. Sekarang giliran Hanan mengeksekusinya di sistem!

---

## 💻 Bab 3: Hanan Membuka Laptop & Login ke Panel Admin

Hanan membuka laptopnya, membuka browser, lalu mengklik tombol **"Login Admin"** di pojok kanan atas landing page:
👉 **URL**: `http://localhost:8000/admin/login`

### Proses di Halaman Login:
1. Hanan memasukkan **Username**: `admin` dan **Password**: `password`.
2. Klik tombol **"Masuk ke Dashboard"**.
3. Sistem memverifikasi kredensial. Begitu cocok, sesi login aman dibuat dan Hanan langsung dialihkan ke beranda kendali utama:
👉 **URL**: `http://localhost:8000/admin/dashboard`

### Apa yang Dilihat Hanan di Dashboard?
- **Kartu Statistik Ringkas**:
  - Total Portofolio: 5 UMKM
  - Portofolio Aktif (Publish): 4 UMKM
  - Portofolio Draft: 1 UMKM
  - Total Admin Terdaftar: 1 Orang
- **Banner Peringatan Masa Aktif**: Jika ada UMKM yang masa aktifnya tersisa $\le 3$ hari, muncul kotak peringatan kuning cerah agar Hanan bisa segera mengingatkan kliennya.
- **Tabel 5 Portofolio Terbaru**: Menampilkan data web UMKM yang baru saja dibuat atau diedit beserta statusnya.

---

## 📝 Bab 4: Input Data UMKM & Penerbitan Portofolio

Untuk membuatkan web pesanan Pak Budi, Hanan mengklik tombol hijau **"+ Buat Web Baru"** di pojok kanan atas dashboard.
👉 **URL**: `http://localhost:8000/admin/portfolios/create`

### Langkah-langkah Penginputan Data oleh Hanan:
1. **Memilih Template Desain**:
   - Di bagian atas form, terdapat pilihan template visual berbentuk kartu radio interaktif. Hanan mengklik kartu **"Minuman"** (dengan ikon cangkir kopi).
2. **Mengisi Identitas Usaha & Fitur Auto-Slug Cerdas**:
   - Hanan mengetik di kolom Nama UMKM: `Kopi Sejahtera`.
   - **Sihir JavaScript**: Kolom Slug URL di bawahnya otomatis terketik sendiri menjadi `kopi-sejahtera`!
   - Sistem langsung melakukan pengecekan ketersediaan slug ke database di latar belakang via AJAX. Muncul teks hijau: *"✓ Slug tersedia dan siap digunakan"*.
3. **Mengisi Bio, Alamat, dan Kontak**:
   - Hanan menyalin bio dari WhatsApp Pak Budi.
   - Memasukkan nomor WhatsApp: `081234567890`.
   - Memasukkan alamat lengkap dan menyematkan URL Google Maps Embed agar pelanggan Pak Budi bisa melihat peta lokasi tokonya.
4. **Upload Logo & Foto Banner**:
   - Hanan memilih file gambar logo dan banner yang dikirim Pak Budi.
   - Begitu file dipilih, langsung muncul **Live Image Preview** di layar, memastikan gambar tidak pecah atau salah pilih.
5. **Menambahkan Daftar Menu Produk Secara Dinamis**:
   - Hanan mengklik tombol **"+ Tambah Produk"**.
   - Satu baris kartu produk baru langsung muncul tanpa reload halaman!
   - Hanan menginputkan nama produk *"Kopi Susu Gula Aren"*, harga `18000`, deskripsi singkat, dan upload fotonya.
   - Hanan mengklik tombol **"+ Tambah Produk"** 3 kali lagi untuk memasukkan Caramel Macchiato, Americano, dan Croissant. (Total ada 4 produk).
6. **Memilih Paket Durasi & Status Penerbitan**:
   - Kolom **Paket Berlangganan**: Hanan memilih dropdown **"6 Bulan"**. Sistem akan otomatis menghitung tanggal kedaluwarsa 6 bulan ke depan dari hari ini.
   - Kolom **Status**: Hanan memilih **"Publish"** (artinya langsung diterbitkan untuk umum).
7. **Menyimpan Data**:
   - Hanan menekan tombol besar **"Simpan Portofolio"**.
   - Sistem memvalidasi seluruh input, meng-upload file gambar ke storage publik, menyimpan data produk dalam format JSON modern, dan mencatat riwayat ke tabel `activity_logs`.
   - Muncul notifikasi sukses: *"Portofolio Kopi Sejahtera berhasil diterbitkan!"* dan layar otomatis kembali ke daftar portofolio.

---

## 🌐 Bab 5: Serah Terima Website & Klien Puas

Hanan ingin memastikan websitenya tampil sempurna sebelum dikirimkan ke Pak Budi. Hanan membuka URL publik portofolio tersebut di tab baru:
👉 **URL**: `http://localhost:8000/kopi-sejahtera`

### Apa yang Terjadi di Halaman Web Kopi Sejahtera?
1. **Desain Elegan Template Minuman**: Muncul banner kedai kopi Pak Budi, logo melingkar yang rapi, nama "Kopi Sejahtera", dan bio kafe yang estetik.
2. **Katalog Menu Interaktif**: 4 menu kopi tampil dalam bentuk grid kartu modern lengkap dengan foto, nama, deskripsi, dan badge harga (misal: *Rp 18.000*).
3. **Tombol "Pesan via WhatsApp" di Setiap Produk**:
   - Hanan mencoba mengklik tombol pesan di menu *Kopi Susu Gula Aren*.
   - Browser otomatis membuka WhatsApp ke nomor Pak Budi (`081234567890`) dengan format pesan yang langsung terisi rapi:
     > *"Halo Kopi Sejahtera, saya ingin memesan Kopi Susu Gula Aren seharga Rp 18.000. Apakah masih tersedia?"*
   - Pelanggan tidak perlu repot mengetik ulang nama menu atau nomor telepon!
4. **Peta Google Maps**: Di bagian bawah halaman, pengunjung bisa langsung melihat peta lokasi kedai kopi Pak Budi dan mencari rute jalan ke sana.

### Kirim Link ke Klien:
Hanan menyalin link `http://localhost:8000/kopi-sejahtera` lalu mengirimkannya ke WhatsApp Pak Budi:
> *"Selamat sore Pak Budi! Website portofolio Kopi Sejahtera sudah resmi online dan aktif selama 6 bulan ke depan. Ini link-nya: http://localhost:8000/kopi-sejahtera. Silakan dipasang di bio Instagram dan status WhatsApp ya Pak!"*

Pak Budi sangat senang karena usahanya kini terlihat profesional layaknya kafe-kafe bintang lima, dan omset penjualannya mulai naik karena pelanggan bisa pesan menu dengan mudah!

---

## ⏰ Bab 6: Monitoring Masa Aktif (Sisa 3 Hari) & Perpanjangan Paket

Waktu berlalu... Setelah 5 bulan 27 hari berjalan, website Kopi Sejahtera mendekati akhir masa aktif paket 6 bulannya (tersisa 3 hari lagi).

### Apa yang Terjadi di Sistem?
1. **Peringatan Otomatis di Dashboard Hanan**:
   - Saat Hanan membuka Dashboard Admin, di bagian atas layar muncul **Alert Banner Kuning Mencolok**:
     > *"⚠️ Peringatan: 1 UMKM akan segera habis masa aktifnya dalam waktu kurang dari 3 hari! Segera hubungi pemilik usaha."*
   - Nama "Kopi Sejahtera" tertera jelas dengan sisa waktu: *"2 hari lagi"*.
2. **Hanan Menghubungi Pak Budi**:
   - Hanan mengirim pesan WhatsApp ramah:
     > *"Halo Pak Budi, sekadar mengingatkan masa aktif website Kopi Sejahtera tinggal 3 hari lagi. Mau sekalian diperpanjang untuk 6 bulan ke depan agar website tetap aktif online?"*
   - Pak Budi menjawab: *"Wah iya mas, perpanjang dong! Penjualan saya kebantu banget dari web itu. Saya transfer ya!"*

### Skenario A (Pak Budi Memperpanjang Paket):
1. Pak Budi mentransfer biaya perpanjangan.
2. Hanan masuk ke admin $\rightarrow$ klik menu **Portofolio** $\rightarrow$ klik tombol **Detail (Mata)** pada Kopi Sejahtera.
3. Di halaman detail, ada kartu khusus **"Perpanjangan Masa Aktif"**.
4. Hanan memilih durasi **"6 Bulan"** lalu menekan tombol biru **"Perpanjang Paket Sekarang"**.
5. Tanggal kedaluwarsa otomatis bertambah 6 bulan ke depan, status tetap **Publish**, dan sistem mencatat riwayat `PERPANJANG_PAKET` di log aktivitas.

### Skenario B (Jika Pak Budi TIDAK Memperpanjang / Telat Bayar):
1. Bagaimana jika klien tidak memperpanjang dan masa aktifnya habis lewat jam 23:59?
2. **Sihir Task Scheduler Laravel**:
   - Tepat jam **00:00 tengah malam**, sistem scheduler di server menjalankan perintah otomatis:
   - Sistem mendeteksi bahwa tanggal `expired_at` Kopi Sejahtera sudah lewat dari tanggal hari ini.
   - Status Kopi Sejahtera **otomatis diubah dari `publish` menjadi `draft`**!
   - Sistem mencatat log audit: *"Paket Kopi Sejahtera telah kedaluwarsa dan otomatis dialihkan ke draft oleh sistem scheduler."*
3. **Dampaknya Bagi Pengunjung**:
   - Jika ada orang yang membuka link `http://localhost:8000/kopi-sejahtera`, web **TIDAK BISA DIBUKA** lagi (otomatis muncul halaman 404 Not Found).
   - Data produk, foto, dan bio Pak Budi TIDAK DIHAPUS, tetap aman tersimpan di database. Jika sewaktu-waktu Pak Budi ingin mengaktifkannya kembali, Hanan tinggal klik tombol perpanjang dan statusnya otomatis aktif kembali!

---

## 🔄 Bab 7: Rebranding Usaha & Fitur Canggih SEO 301 Permanent Redirect

Dua bulan kemudian, bisnis Pak Budi makin besar. Beliau membuka cabang kedua dan ingin mengganti nama websitenya agar lebih berkelas:
- Nama Lama: `Kopi Sejahtera` (Slug: `/kopi-sejahtera`)
- Nama Baru: `Kopi Sejahtera Majalengka` (Slug Baru: `/kopi-sejahtera-majalengka`)

Pak Budi menghubungi Hanan:
> *"Mas Hanan, saya ganti nama usaha jadi 'Kopi Sejahtera Majalengka'. Alamat webnya tolong diubah jadi /kopi-sejahtera-majalengka ya. Tapi saya takut stiker kemasan cup kopi saya yang lama kan tertulis /kopi-sejahtera, nanti kalau pelanggan lama scan QR-nya jadi error gimana?"*

Hanan tersenyum tenang: *"Tenang Pak Budi, sistem web kami punya teknologi SEO 301 Redirect. Link lama bapak tidak akan pernah mati!"*

### Apa yang Dilakukan Hanan di Sistem?
1. Hanan masuk ke menu **Edit Portofolio** Kopi Sejahtera.
2. Mengubah nama usaha menjadi `Kopi Sejahtera Majalengka`.
3. Mengubah slug menjadi `kopi-sejahtera-majalengka`.
4. Klik tombol **"Simpan Perubahan"**.

### Apa yang Terjadi di Balik Layar (Database & Controller)?
- Sistem mendeteksi bahwa slug lama (`kopi-sejahtera`) berbeda dengan slug baru (`kopi-sejahtera-majalengka`).
- Sistem **secara otomatis mencatat slug lama ke dalam tabel `slug_histories`**.
- Tabel utama `portfolios` diperbarui dengan slug baru.

### Pembuktian di Browser:
1. Pelanggan lama membuka link di kemasan lama: `http://localhost:8000/kopi-sejahtera`.
2. Browser **TIDAK MENAMPILKAN ERROR 404!**
3. Dalam sepersekian detik, URL di address bar browser otomatis berubah sendiri menjadi:
   👉 `http://localhost:8000/kopi-sejahtera-majalengka` dengan status kode **HTTP 301 (Moved Permanently)**.
4. Nilai ranking Google tidak hilang, pelanggan lama tidak kecewa, dan Pak Budi semakin kagum dengan profesionalitas sistem Hanan!

---

## 🚫 Bab 8: Pengunjung Nyasar / Salah Ketik URL (Halaman 404 Keren)

Suatu hari, ada orang yang salah mengetik alamat URL di browser:
👉 Ketik URL ngawur: `http://localhost:8000/kopi-ngawur-gak-jelas`

### Apa yang Ditampilkan Web?
1. Sistem mencari ke tabel `portfolios` $\rightarrow$ tidak ada.
2. Sistem mencari ke tabel riwayat `slug_histories` $\rightarrow$ tidak ada.
3. Sistem secara elegan melempar fungsi `abort(404)`.
4. Browser menampilkan **Halaman Khusus 404 (Not Found)** yang didesain modern:
   - Ada ilustrasi angka **404** besar yang estetik.
   - Teks penjelasan bersahabat: *"Oops! Halaman Portofolio Tidak Ditemukan. Halaman yang Anda cari mungkin salah ketik, sudah dihapus, atau paket masa aktifnya telah berakhir."*
   - Terdapat tombol jelas: **"Kembali ke Beranda"** yang mengarahkan pengunjung kembali ke landing page dengan selamat.

---

## 🛡️ Bab 9: Keamanan Sistem & Manajemen Multi-Admin (Fitur Anti-Kudeta)

Karena pesanan pembuatan website UMKM semakin banyak, Hanan merekrut temannya, **Rian**, sebagai staf admin pembantu untuk membantunya menginputkan data produk UMKM.

### 1. Menambahkan Staf Admin Baru:
- Hanan masuk ke menu **Pengaturan** (`/admin/settings`).
- Di bagian bawah, ada form **"Daftarkan Akun Admin Baru"**.
- Hanan menginputkan:
  - Nama: `Rian Kurniawan`
  - Username: `rian`
  - Email: `rian@gmail.com`
  - Password: `password123`
- Klik **"Daftarkan Admin"**. Rian sekarang memiliki akun sendiri untuk login dan membantu input portofolio.

### 2. Fitur Proteksi Super Admin (Anti-Kudeta):
- Suatu hari, Rian iseng membuka menu Pengaturan dan mencoba mengklik tombol **Hapus** pada akun Hanan (Admin ID: 1).
- **Proteksi Logika Sistem Bekerja**:
  - Tombol hapus pada akun Hanan dikunci dan diberi label khusus: *"Super Admin (Akun Utama)"*.
  - Bahkan jika Rian mencoba membobolnya lewat inspect element atau request API jahat, Controller di backend memiliki baris pengaman:
    ```php
    if ($admin->id === 1) {
        return back()->with('error', 'Akun Super Admin utama tidak boleh dihapus!');
    }
    ```
  - Upaya kudeta gagal total! Akun pemilik sistem selalu 100% aman terlindungi.

### 3. Keamanan Sesi & Anti-Back History (PreventBackHistory):
- Setelah selesai bekerja, Hanan mengklik tombol merah **"Keluar (Logout)"**.
- Sistem langsung menghapus sesi login dan me-regenerate token CSRF.
- Hanan dialihkan kembali ke halaman login.
- **Uji Coba Penguji**: Jika ada orang lain yang duduk di laptop Hanan lalu menekan tombol **"Back" (Panah Kiri)** di browser:
  - Layar **TIDAK AKAN** menampilkan kembali halaman dashboard admin!
  - Browser otomatis memuat ulang halaman login karena adanya middleware khusus `PreventBackHistory` yang mematikan cache browser (No-Cache, No-Store). Data rahasia klien tetap aman!

---

## 🎯 Kesimpulan & Keunggulan untuk Disampaikan ke Penguji Ujikom

Jika penguji bertanya: *"Apa keunggulan dari proyek web builder kamu dibandingkan aplikasi portofolio biasa?"*

**Jawaban Ringkas & Percaya Diri Hanan:**
1. **Solutif untuk Ekonomi Nyata**: *"Bukan cuma portofolio statis, tapi ada model bisnis nyata (paket berlangganan 1, 6, 12 bulan) yang membantu UMKM Majalengka punya web murah tanpa pusing koding."*
2. **Otomasi Cerdas**: *"Ada Task Scheduler yang otomatis menonaktifkan web yang habis masa aktifnya di jam 00:00, serta banner peringatan sisa 3 hari di dashboard."*
3. **SEO Friendly 301 Redirect**: *"Jika UMKM ganti nama atau ganti slug, link lama di kemasan produknya tidak akan error 404, melainkan otomatis dialihkan ke alamat baru secara permanen."*
4. **Keamanan Berlapis**: *"Dilengkapi perlindungan Anti-Kudeta Super Admin, pencegahan tombol back history browser pasca-logout, dan audit logging untuk melacak setiap aksi admin."*
