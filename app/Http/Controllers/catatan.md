# Catatan Dokumentasi: Folder Controllers (`app/Http/Controllers/`)

---

## 1. Apa itu Controller? (Bahasa Santai)
Kalau diibaratkan di restoran:
- **Route** itu seperti *Buku Menu* (tahu daftar makanan apa saja yang ada).
- **View** itu seperti *Piring & Penyajian Makanan* (tampilan cantik yang dilihat pelanggan).
- **Model** itu seperti *Gudang Bahan Makanan* (tempat mengambil & menyimpan data).
- Nah, **Controller itu adalah KOKI (Chef)-nya!** 👨‍🍳
Dia yang menerima pesanan dari pelanggan, memproses bumbu-bumbu (validasi), mengambil bahan dari gudang (Model), lalu menyajikannya ke atas piring (View).

---

## 2. Alur Kerja Controller di Aplikasi Kita
```
Pengunjung klik link atau submit formulir di browser
                     │
                     ▼
File 'routes/web.php' mencari URL & Method (GET, POST, PUT, DELETE)
                     │
                     ▼
Route meneruskan tugas ke Controller yang tepat:
- Halaman umum / publik  => diurus oleh PublicController
- Halaman dashboard admin => diurus oleh Controller di dalam folder Admin/
                     │
                     ▼
Controller memproses logika:
1. Validasi data form (apakah nama sudah diisi? apakah slug kembar?)
2. Upload gambar jika ada
3. Panggil Model untuk simpan/ambil data database
                     │
                     ▼
Controller mengirim respon:
- Tampilkan halaman web (view)
- Atau alihkan ke halaman lain (redirect) dengan pesan sukses!
```

---

## 3. Pembagian File di Folder Ini
1.  `Controller.php`: Class induk (bapaknya) semua controller. File ini bawaan Laravel dan tidak perlu diubah-ubah.
2.  `PublicController.php`: Koki khusus yang melayani pengunjung umum yang membuka Landing Page promosi dan membuka website portofolio UMKM (`/{slug}`).
3.  Folder `Admin/`: Dapur khusus untuk melayani admin pengelola yang sudah berhasil login (Dashboard, Kelola UMKM, Ganti Password, Catatan Log).

---

## 4. 💡 Jawaban Mantap untuk Penguji:
> *"Pak/Bu, dalam konsep MVC (Model-View-Controller) Laravel, Controller bertindak sebagai pusat logika bisnis. Controller kami menerima HTTP Request dari Route, melakukan validasi form, berinteraksi dengan Database melalui Eloquent Model, lalu menyajikan hasilnya ke Blade View."*
