# Catatan Dokumentasi: Folder Seeders (`database/seeders/`)

---

## [FUNGSI]
Folder ini berfungsi untuk **menyuntikkan data awal (Data Seeding / Dummy Data)** ke dalam tabel database MySQL secara otomatis. Sangat berguna agar saat aplikasi di-clone di PC penguji, developer tidak perlu repot mengetik data akun atau data portofolio satu per satu dari awal. Cukup jalankan perintah seeder, data langsung terisi lengkap dan siap didemokan.

---

## [ALUR SISTEM / USER FLOW]
```
Siswa / Penguji menjalankan perintah: 'php artisan db:seed'
                           │
                           ▼
Laravel memanggil file utama: DatabaseSeeder::run()
                           │
                           ▼
DatabaseSeeder memanggil AdminSeeder::class
└── Menyuntikkan akun admin 'hanan' dengan password Bcrypt 'hanan123'
                           │
                           ▼
Database terisi kredensial admin, siap digunakan untuk login dan pengujian live.
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `DatabaseSeeder.php`
*   **Fungsi**: Titik sentral (*Master Seeder*) yang mengatur urutan eksekusi seeder di aplikasi.
*   **Logika**: Memanggil method `$this->call(AdminSeeder::class)`. Sistem dijaga tetap bersih (*clean database*), sehingga portofolio dibuat secara langsung (*live input*) saat pengujian oleh penguji.

### 2. `AdminSeeder.php`
*   **Fungsi**: Memasukkan data akun admin default pengelola platform ke tabel `admins`.
*   **Kredensial Default**:
    *   `name`: "Hanan Aria Santagama"
    *   `username`: "hanan"
    *   `password`: "hanan123" (otomatis di-hash dengan `Hash::make()` menggunakan algoritma Bcrypt).
*   **Metode Aman**: Menggunakan `Admin::updateOrCreate()`. Jika seeder dijalankan berulang kali, tidak akan menyebabkan error duplikasi username.

