# Catatan Dokumentasi: Folder Views Publik (`resources/views/public/`)

---

## [FUNGSI]
Folder ini berisi seluruh antarmuka publik yang dapat diakses oleh **pengunjung umum / calon klien tanpa perlu login**. Meliputi **Landing Page promosi layanan pembuatan web portofolio profesional** (`landing.blade.php`) dengan desain *Clean White Theme* dan **5 Variasi Template Portofolio UMKM Dinamis** yang berada di dalam subfolder `templates/`.

---

## [ALUR SISTEM / USER FLOW]
```
1. Pengunjung membuka alamat domain utama '/'
   └── Masuk ke rute: home (PublicController@landing)
   └── View public.landing menampilkan:
       - Header & Brand 'CMS Web Builder'
       - Hero section ajakan konversi & value proposition
       - 6 Fitur unggulan website untuk calon klien
       - 5 Pilihan kategori desain industri (Kuliner, Resto, Jasa, Tokoh, Organisasi)
       - 3 Langkah alur pemesanan terima beres (Done-For-You)
       - 2 Pilihan paket investasi (Starter 3 Bulan vs Pro Bisnis 1 Tahun)
       - Interactive CV Card profil developer (Hanan Aria Santagama)
       - Call-to-Action WhatsApp konsultasi gratis
       - Footer bersih dengan copyright © 2026 Hanan Aria Santagama | XII RPL 1

2. Pengunjung membuka link portofolio klien: '/nama-usaha'
   └── Masuk ke rute dinamis: portfolio.public (PublicController@show)
   ├── Cek 1: Jika slug terdaftar & publish:
   │          Sistem membaca kolom 'template_id' (contoh: 'minuman')
   │          Lalu merender view: public.templates.minuman
   ├── Cek 2: Jika slug pernah diubah:
   │          Sistem mencari di tabel slug_histories
   │          Lalu melakukan HTTP 301 Permanent Redirect ke slug baru
   └── Cek 3: Jika slug tidak ditemukan atau masih draft:
              Sistem melempar halaman 404 (errors.404)

3. Pengunjung mengklik tombol 'Pesan via WA':
   └── Otomatis membuka aplikasi WhatsApp dengan template pesan order sesuai produk.
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `landing.blade.php`
*   **Fungsi**: Halaman landing page utama penawaran jasa pembuatan website portofolio profesional.
*   **Tema Visual**: *Clean Modern White Theme* (`bg-white` & `bg-slate-50`), tipografi kontras tinggi, border halus, bayangan lembut, dan tanpa efek stabilo hijau (seleksi teks native browser).
*   **Komponen Konten**:
    *   *Navbar*: Logo CMS Web Builder (fallback cerdas ke file `.png` / `.svg`), link navigasi halus, tombol Konsultasi WA, dan Login Admin.
    *   *Hero Section*: Headline fokus solusi bisnis, trust metrics (selesai 24 jam, mobile responsive, WA order, Google Maps).
    *   *Fitur Unggulan*: 6 kartu fitur (slug kustom, katalog produk, chat WA, peta lokasi, mobile friendly, bebas maintenance).
    *   *Etalase Kategori Desain*: Menampilkan 5 varian industri (Minuman, Makanan, Jasa, Tokoh, Organisasi).
    *   *Paket Layanan*: Perbedaan paket murni di benefit layanan di luar web (masa aktif 90 hari vs 365 hari, kuota update menu, dukungan SEO redirect).
    *   *Interactive CV Card Developer*: Profil Hanan Aria Santagama (foto profil, role founder, SMKN 1 Majalengka XII RPL 1, tech stack badges, tanda tangan digital, tautan kontak).
    *   *Footer*: Minimalis dan rapi, copyright tunggal `© 2026 Hanan Aria Santagama | XII RPL 1`.

### 2. Subfolder `templates/` (5 Variasi Layout Portofolio)
*   `minuman.blade.php`: Mengadopsi aksen warna kopi/amber, menonjolkan menu minuman segar, harga, dan tombol pesan menu ke WhatsApp.
*   `makanan.blade.php`: Mengadopsi aksen warna oranye hangat kuliner, menonjolkan foto hidangan lezat dan tombol pesan antar (*delivery*).
*   `organisasi.blade.php`: Mengadopsi aksen warna biru/indigo formal, menonjolkan Visi-Misi, struktur kepengurusan, dan program kerja unggulan.
*   `tokoh.blade.php`: Mengadopsi aksen warna cyan berwibawa, menonjolkan foto profil besar, rekam jejak, program janji aksi, dan tombol WA.
*   `jasa.blade.php`: Mengadopsi aksen warna hijau emerald terpercaya, menonjolkan daftar layanan, pricelist transparan, dan sematan peta Google Maps.
