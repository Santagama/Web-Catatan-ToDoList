# Dokumentasi View Template Portofolio Publik

Folder ini berisi 5 varian template spesifik industri untuk etalase portofolio UMKM:
1. `minuman.blade.php` (Aksen Amber - Kedai Kopi, Boba, Minuman Segar)
2. `makanan.blade.php` (Aksen Oranye - Restoran, Rumah Makan, Kuliner Bakso)
3. `organisasi.blade.php` (Aksen Indigo - OSIS, Komunitas Pemuda, Lembaga Swadaya)
4. `tokoh.blade.php` (Aksen Sian - Profil Calon Legislatif, Figur Publik, Tokoh Masyarakat)
5. `jasa.blade.php` (Aksen Zamrud/Emerald - Studio Foto, Bengkel Servis, Barbershop/Salon)

### [FUNGSI]
Menampilkan halaman web publik resmi UMKM mitra secara instan dan responsif berdasarkan `template_id` yang dipilih admin. Menyajikan profil usaha, bio, galeri produk/layanan dinamis (dari kolom JSON `products`), alamat fisik, tautan Google Maps, serta tombol pemesanan langsung terintegrasi WhatsApp.

### [ALUR SISTEM/USER FLOW]
1. Pengunjung/konsumen mengakses URL publik portofolio via slug (contoh: `http://localhost/kopi-senja-majalengka`).
2. `PublicController@show` memeriksa validitas slug, status `publish`, dan status aktif paket langganan.
3. Controller memuat template Blade yang sesuai (`public.templates.{template_id}`).
4. Konsumen melihat katalog produk dan harga; saat memilih tombol "Pesan via WhatsApp", sistem membuka aplikasi WhatsApp dengan pesan pembuka otomatis yang memuat nama produk dan nama usaha.

### [PENJELASAN TEKNIS]
- Seluruh template memanfaatkan casting array `$portfolio->products` dengan fallback aman `count($portfolio->products ?? [])` dan `@forelse ($portfolio->products ?? [] as $item)`.
- Menggunakan `Storage::url(...)` untuk menampilkan berkas logo, banner, dan foto produk dari *symbolic link* `public/storage`.
- Mengonversi nomor WhatsApp ke format internasional menggunakan `preg_replace('/[^0-9]/', '', $portfolio->whatsapp)` sehingga kompatibel dengan tautan `https://wa.me/...`.
- Desain *mobile-first*, adaptif menggunakan Tailwind CSS v4, dan bebas dari ketergantungan JavaScript berat/framework SPA.
