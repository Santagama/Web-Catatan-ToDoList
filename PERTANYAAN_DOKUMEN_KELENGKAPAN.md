# 📑 LAPORAN TEKNIS: ANALISIS ARSITEKTUR GENERATING VS RENDERING
**Proyek**: Platform Web Portofolio UMKM (CMS Web Builder)  
**Dokumen**: Jawaban Pertanyaan Dokumen Kelengkapan Aplikasi  
**Penyusun**: Hanan Aria Santagama (XII RPL 1)

---

### 1. Jika UMKM A mengubah harga produk, apakah halaman publik UMKM A langsung berubah pada pendekatan generating? Jelaskan konsekuensinya.

* **Jawaban:**  
  **TIDAK langsung berubah.**

* **Penjelasan & Konsekuensinya:**  
  1. **Konsep Generating (Static Site Generation / SSG):**  
     Pada pendekatan *generating*, halaman website publik berupa file HTML statis murni yang sudah dicetak (*pre-rendered / pre-built*) terlebih dahulu dan disimpan di dalam disk server atau CDN. Halaman ini tidak terhubung langsung ke database saat dikunjungi oleh pembeli.
  2. **Konsekuensi Keterlambatan Data (*Stale Data*):**  
     Ketika pemilik UMKM A mengubah harga di dashboard admin, data baru tersebut hanya tersimpan di database. File HTML statis yang lama masih menampilkan harga sebelum diubah sampai ada proses kompilasi ulang (*rebuild / re-generate*) file HTML tersebut.
  3. **Dampak pada Transaksi Bisnis:**  
     Jika ada jeda waktu antara perubahan data dengan proses rebuild, calon pelanggan yang membuka website akan melihat harga lama. Ketika pelanggan mengklik tombol *"Pesan via WhatsApp"*, harga yang dikonfirmasi oleh pemilik usaha akan berbeda dengan harga yang tertera di website. Hal ini berisiko memicu komplain pelanggan dan merusak kepercayaan konsumen terhadap UMKM tersebut.
  4. **Beban Resource Server:**  
     Server harus mengalokasikan daya komputasi CPU dan waktu untuk merender ulang file HTML statis setiap kali ada perubahan data sekecil apa pun.

---

### 2. Jika terdapat 500 tenant aktif dan masing-masing memiliki 20 produk, pendekatan mana yang lebih realistis? Jelaskan alasanmu.

* **Jawaban:**  
  Pendekatan yang jauh lebih realistis adalah **Server-Side Rendering (Rendering Dinamis) yang dipadukan dengan Caching (seperti arsitektur Laravel yang kita gunakan saat ini)**.

* **Alasan Teknis Mengapa Lebih Realistis:**
  1. **Menghindari Macetnya Antrean Build (*Build Queue Bottleneck*):**  
     Jika terdapat 500 tenant aktif dan masing-masing sering memperbarui produk, promo, jam operasional, atau status buka/tutup, pendekatan *generating (SSG)* akan memaksa server terus-menerus menjalankan proses build. Jika ada 50 tenant mengedit data di jam yang sama, server bisa mengalami lonjakan beban (*overload*) dan antrean generate halaman menjadi sangat lambat.
  2. **Kebutuhan Fitur Real-Time & Otomasi Sistem:**  
     Platform ini memiliki fitur penting seperti **Task Scheduler auto-draft** untuk paket yang kadaluarsa (`expired_at`) dan **SEO 301 Permanent Redirect** saat slug diubah. Pada pendekatan *rendering*, saat scheduler mengubah status menjadi `draft` di database, halaman publik secara instan otomatis menghasilkan 404 pada detik itu juga tanpa perlu menunggu proses generate file fisik.
  3. **Skala Data Sangat Ringan bagi Database Relasional:**  
     500 tenant dengan 20 produk hanya menghasilkan total 10.000 item produk. Dalam arsitektur database MySQL modern, 10.000 baris data sangatlah kecil. Terlebih lagi, proyek ini menggunakan kolom **JSON `products`** yang berada langsung di dalam baris tabel `portfolios` dengan indeks unik pada `slug`.
  4. **Kecepatan Akses Sangat Cepat:**  
     Query yang dijalankan hanya berupa satu query terindeks:  
     `SELECT * FROM portfolios WHERE slug = 'nama-usaha' LIMIT 1`.  
     Waktu eksekusi query ini hanya membutuhkan waktu sekitar **1 hingga 5 milidetik**. Respon halaman Blade tetap instan dan jauh lebih mudah dikelola dibandingkan mengelola 500 folder/file HTML statis yang rawan korup atau tidak sinkron.

---

### 3. Kapan sebaiknya memilih generating, dan kapan sebaiknya memilih rendering, untuk web builder UMKM?

* **Kapan Sebaiknya Memilih GENERATING (SSG):**
  1. **Konten Sangat Jarang Berubah (*Ultra Static*):**  
     Cocok jika website UMKM hanya berfungsi sebagai brosur profil perusahaan (*company profile*) sederhana yang datanya hanya diperbarui 6 bulan atau 1 tahun sekali.
  2. **Trafik Pengunjung Masif dengan Anggaran Server Terbatas:**  
     Jika sebuah website memiliki jutaan pengunjung per hari namun pemilik platform tidak ingin menyewa server backend yang mahal. File HTML statis hasil generating dapat disimpan di layanan CDN gratis (seperti Cloudflare Pages atau Netlify) dengan beban server database 0%.
  3. **Kecepatan Waktu Respons Pertama (*Time to First Byte / TTFB*) Maksimal:**  
     Karena server tidak perlu melakukan pemrosesan PHP maupun query database saat ada permintaan masuk, halaman statis dapat langsung dikirim ke browser pengguna secara instan.

* **Kapan Sebaiknya Memilih RENDERING (SSR / Dynamic):**
  1. **Data Kerap Berubah dan Butuh Tampilan Real-Time:**  
     Sangat tepat untuk web builder UMKM kuliner atau toko yang sering mengubah harga promo harian, status stok barang, jam buka/tutup toko, dan alamat lokasi.
  2. **Banyak Logika Bisnis di Sisi Server (*Server-Side Business Logic*):**  
     Jika website membutuhkan pengecekan masa aktif paket langganan secara dinamis, deteksi status akun admin, pengalihan URL lama (*SEO 301 Redirect*), atau pencatatan audit log pengunjung.
  3. **Skalabilitas Jumlah Tenant Tanpa Batas:**  
     Ketika jumlah UMKM bertambah dari 500 menjadi 5.000 atau 50.000 tenant, penambahan tenant baru hanya menambah satu baris data di tabel MySQL tanpa perlu menghabiskan ruang penyimpanan disk (*disk storage*) untuk ribuan file HTML statis yang terpisah.

---

### 4. Jelaskan bagaimana caching atau Incremental Static Regeneration (ISR) dapat menjadi jalan tengah antara generating dan rendering.

* **Penjelasan Konsep Jalan Tengah:**  
  *Generating* murni unggul dalam kecepatan akses tetapi lambat saat update data. Sebaliknya, *Rendering* dinamis unggul dalam data yang selalu segar (*fresh*) tetapi dapat membebani CPU database jika pengunjung membludak. **Caching dan ISR hadir sebagai solusi hibrida (jalan tengah terbaik).**

* **1. Melalui Mekanisme Caching (di Sisi Laravel/Server):**
  * **Cara Kerja:**  
    Saat pengunjung pertama mengakses `http://domain/{slug}`, Laravel menjalankan query database dan me-render template Blade secara dinamis. Namun, hasil HTML yang sudah jadi langsung disimpan ke dalam memori cepat (**Cache / Redis**) dengan durasi waktu tertentu (misal: 10 menit).
  * **Hasilnya:**  
    Pengunjung ke-2, ke-3, hingga ke-1.000 akan langsung dilayani dari memori cache tersebut dengan kecepatan setara file statis (*generating*), tanpa menyentuh database sama sekali.
  * **Penyegaran Otomatis (*Cache Invalidation*):**  
    Ketika admin mengklik tombol "Simpan Perubahan" di dashboard, Controller otomatis menghapus cache untuk slug tersebut (`Cache::forget("portfolio_{$slug}")`). Pengunjung berikutnya otomatis mendapatkan data harga terbaru seketika.

* **2. Melalui Mekanisme Incremental Static Regeneration (ISR):**
  * **Cara Kerja (*Stale-While-Revalidate*):**  
    Halaman website pada awalnya dibuat statis. Sistem menentukan waktu revalidasi (misalnya 60 detik).
  * Jika ada pengunjung masuk setelah lewat 60 detik, sistem akan **tetap menyajikan halaman statis lama secara instan**, namun di saat bersamaan di latar belakang (*background*), server secara diam-diam mengambil data baru dan membangun ulang (*rebuild*) halaman statis tersebut.
  * Begitu proses build di latar belakang selesai, file statis baru menggantikan file lama untuk pengunjung berikutnya.
  * **Hasilnya:**  
    Pengguna tidak pernah merasakan lambatnya waktu *loading*, server tidak perlu me-rebuild seluruh 500 website sekaligus, dan data UMKM tetap terbarui secara berkala.

---

### 5. Jika memilih generating, mekanisme apa yang harus disiapkan agar perubahan data UMKM dapat memicu rebuild halaman terkait?

Jika platform memutuskan menggunakan pendekatan *generating*, sistem backend harus menyiapkan **4 arsitektur otomatisasi** berikut:

1. **Pemicu Perubahan Berbasis Event (*Event-Driven Architecture / Webhooks*):**  
   Di dalam Controller Laravel (`PortfolioController@update`), tepat setelah data berhasil disimpan ke MySQL, sistem harus memicu sebuah Event:
   ```php
   event(new PortfolioUpdatedEvent($portfolio));
   ```
   Event ini mengirimkan sinyal bahwa data UMKM dengan ID atau slug tertentu telah diperbarui.

2. **Antrean Pemrosesan Latar Belakang (*Asynchronous Queue Workers*):**  
   Proses *rebuild* halaman membutuhkan waktu beberapa detik dan tidak boleh dijalankan langsung di thread utama (*synchronous*), karena akan membuat halaman dashboard admin berputar-putar (*loading*) lama.  
   Maka, sinyal tersebut dimasukkan ke dalam antrean tugas (**Queue Job / Redis Queue**) agar diproses secara terisolasi di latar belakang oleh *queue worker* tanpa mengganggu kenyamanan admin.

3. **Generator Halaman Granular / Parsial (*Single-Tenant Static Generator*):**  
   Sistem harus memiliki skrip generator cerdas yang **hanya me-rebuild satu halaman UMKM yang datanya berubah saja**, bukan melakukan compile ulang pada seluruh 500 website yang ada.  
   Skrip ini memanggil fungsi rendering template dengan data UMKM terkait, lalu menimpa (*overwrite*) file fisik yang bersangkutan, misalnya:  
   `public/static_sites/{slug}/index.html`.

4. **Pembersihan Cache CDN Otomatis (*CDN Cache Invalidation API*):**  
   Jika website statis didistribusikan melalui jaringan CDN (seperti Cloudflare atau Fastly), sistem antrean harus mengirim permintaan API (*Purge Cache Request*) ke penyedia CDN untuk menghapus salinan file lama dari server edge global:
   ```bash
   POST https://api.cloudflare.com/client/v4/zones/{zone_id}/purge_cache
   {"files": ["https://namadomain.com/kopi-senja"]}
   ```
   Dengan demikian, pengunjung di seluruh dunia dipastikan langsung menerima file HTML baru yang baru saja di-generate.
