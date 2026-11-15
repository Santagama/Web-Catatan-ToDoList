# Catatan Dokumentasi: Folder Controllers (`app/Http/Controllers/`)

---

## [FUNGSI]
Folder ini merupakan **pusat logika pengendali (Controller)** dalam arsitektur MVC (Model-View-Controller) Laravel. Controller bertindak sebagai "otak" yang menerima permintaan (*HTTP Request*) dari rute (`routes/web.php`), menjalankan validasi, memanggil Model untuk manipulasi basis data, dan mengembalikan respon berupa tampilan View Blade atau pengalihan (*Redirect*).

---

## [ALUR SISTEM / USER FLOW]
```
User / Pengunjung mengirim permintaan HTTP melalui browser (klik link / submit form)
                                       │
                                       ▼
Routing Laravel (routes/web.php) mencocokkan URL & Method (GET, POST, PUT, DELETE)
                                       │
                                       ▼
Route meneruskan request ke Controller yang sesuai:
- Modul Publik dihandle oleh PublicController
- Modul Admin dihandle oleh subfolder Admin/* Controller
                                       │
                                       ▼
Controller memproses data (Validasi -> Model -> Business Logic)
                                       │
                                       ▼
Controller mengembalikan respon:
- view('nama.file', $data)  => Menampilkan halaman HTML
- redirect()->route(...)    => Mengalihkan halaman dengan pesan flash
```

---

## [PENJELASAN TEKNIS MASING-MASING SUBFOLDER & FILE]

*   `Controller.php`: Base class abstrak bawaan Laravel yang diwarisi oleh semua controller dalam aplikasi.
*   `Admin/`: Subfolder khusus yang menampung seluruh controller area dashboard admin yang terproteksi oleh middleware autentikasi.
*   `PublicController.php`: Controller untuk melayani halaman publik pengunjung (Landing Page promosi dan rendering 5 template portofolio UMKM).

