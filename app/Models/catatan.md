# Catatan Dokumentasi: Folder Models (`app/Models/`)

---

## 1. Apa itu Folder Models? (Bahasa Santai)
Folder ini adalah tempat tinggalnya **Model Eloquent ORM**. 
Kalau diibaratkan, **Model itu seperti jembatan atau kurir pribadi antara codingan PHP kita dengan tabel database MySQL**. 
Tanpa model, kita harus ngetik query SQL panjang kayak `SELECT * FROM portfolios WHERE ...` secara manual. Tapi berkat Model, kita cukup panggil `Portfolio::all()` atau `Portfolio::create([...])`, semuanya beres otomatis, cepat, dan aman dari bahaya hacker (SQL Injection).

---

## 2. Alur Cara Kerjanya (Flowchart Sederhana)
```
Admin klik simpan data di website
                │
                ▼
Controller panggil Model:
Portfolio::create([...])
                │
                ▼
Model Portfolio bekerja otomatis:
- Cek kolom mana yang boleh diisi ($fillable)
- Ubah array produk jadi teks JSON MySQL ($casts)
- Ubah format tanggal kedaluwarsa jadi Carbon ($casts)
                │
                ▼
Eloquent kirim perintah aman ke MySQL:
INSERT INTO portfolios ...
                │
                ▼
Data tersimpan rapi di Database!
```

---

## 3. Penjelasan Tiap File & Contekan Jawaban Ujikom

### A. `Admin.php`
*   **Fungsinya buat apa?**
    Mengatur data akun login pengelola sistem (nama, username, password).
*   **Kenapa extends `Authenticatable`?**
    Supaya model ini otomatis dikenali oleh sistem login bawaan Laravel (`Auth::attempt()`, `auth()->user()`).
*   **Hal Penting di File Ini:**
    *   `$fillable = ['name', 'username', 'password']`: Menentukan kolom mana saja yang boleh diinput dari form.
    *   `$hidden = ['password']`: Password disembunyikan agar tidak pernah bocor ke tampilan.
    *   `$casts = ['password' => 'hashed']`: Setiap kali admin simpan password baru, Laravel otomatis mengubahnya menjadi enkripsi Bcrypt.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Pak/Bu, model Admin ini meng-extend class Authenticatable agar terintegrasi langsung dengan Auth Guard Laravel. Password-nya juga otomatis kami enkripsi Bcrypt lewat fitur casts `password => hashed` demi keamanan data pengguna."*

---

### B. `Portfolio.php` (Model Utama Paling Penting!)
*   **Fungsinya buat apa?**
    Menampung seluruh data website UMKM (nama toko, slug URL, tema template, foto logo/banner, no WA, Instagram, Google Maps, dan katalog produk).
*   **Fitur Keren di File Ini:**
    1.  `$casts = ['products' => 'array', 'expired_at' => 'datetime']`
        *   **Kelebihannya**: Di MySQL produk disimpan sebagai teks JSON. Tapi saat ditarik ke PHP/Blade, otomatis berubah jadi **Array murni**, jadi kita tidak perlu `json_decode()` manual!
    2.  `mapsEmbedUrl()` (Accessor & Mutator):
        *   Membersihkan input link Google Maps secara otomatis. Mau admin menempelkan link langsung atau kode tag `<iframe src="...">` lengkap, sistem pintar ini langsung mengekstrak URL bersihnya agar tidak error 404 di tampilan web.
    3.  `isExpired()` & `remainingDays()`:
        *   Fungsi pembantu untuk mengecek apakah paket langganan web UMKM sudah habis dan menghitung sisa hari aktifnya.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Model Portfolio ini menyimpan data produk fleksibel menggunakan kolom JSON di MySQL dan kami optimalkan dengan Eloquent Casting `'products' => 'array'`. Sehingga data produk bisa langsung di-looping di Blade template tanpa perlu decode manual."*

---

### C. `ActivityLog.php`
*   **Fungsinya buat apa?**
    Mencatat jejak audit (*audit trail*) semua aksi admin di sistem (siapa yang login, siapa yang tambah data UMKM, siapa yang edit, siapa yang hapus).
*   **Hal Keren di File Ini:**
    *   `public $timestamps = false`: Kita matikan `updated_at` bawaan Laravel, karena log aktivitas itu catatan sejarah yang permanen (hanya butuh waktu dibuat `created_at`).
    *   `ActivityLog::record(...)`: Fungsi pembantu statis agar kita bisa mencatat aktivitas dari Controller mana saja hanya dengan 1 baris kode singkat.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"Tabel activity_logs ini kami sediakan untuk transparansi dan audit trail sistem. Jadi kalau ada data yang dihapus atau diubah, kita bisa tahu pasti siapa admin pelakunya dan kapan kejadiannya."*

---

### D. `SlugHistory.php`
*   **Fungsinya buat apa?**
    Menyimpan catatan sejarah alamat URL slug yang pernah dipakai UMKM.
*   **Untuk Apa? (Fitur SEO 301 Permanent Redirect)**:
    Misal nama toko awal adalah `toko-roti`, lalu pemilik toko ganti nama jadi `bakery-lezat`. Pengunjung yang masih punya link lama `toko-roti` tidak akan tersesat ke halaman 404, karena sistem otomatis mengecek tabel ini dan mengarahkan pengunjung ke link baru `bakery-lezat`.
*   💡 **Jawaban Mantap untuk Penguji:**
    > *"File ini mendukung optimasi SEO (Search Engine Optimization) dengan teknik HTTP 301 Permanent Redirect. Sehingga jika UMKM mengganti alamat webnya, ranking Google dan pelanggan lamanya tidak akan hilang karena broken link."*
