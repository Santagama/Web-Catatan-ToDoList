# Catatan Dokumentasi: Folder Models (`app/Models/`)

---

## [FUNGSI]
Folder ini berisi **Model Eloquent ORM (Object-Relational Mapping)**. Model berfungsi sebagai jembatan penghubung antara logika pemrograman PHP dengan tabel-tabel di database MySQL. Dengan Model, kita dapat melakukan manipulasi data (Create, Read, Update, Delete) menggunakan sintaks objek yang bersih tanpa perlu menulis query SQL manual.

---

## [ALUR SISTEM / USER FLOW]
```
Admin melakukan aksi di antarmuka (misal: simpan data UMKM baru)
                             │
                             ▼
Controller menerima request data dan memanggil method Model:
Contoh: Portfolio::create([...])
                             │
                             ▼
Model Portfolio memeriksa $fillable dan melakukan casting otomatis:
- Array produk diubah menjadi string JSON untuk MySQL ($casts)
- Field expired_at diubah menjadi objek Carbon/Datetime
                             │
                             ▼
Eloquent ORM menyusun query SQL 'INSERT INTO portfolios ...'
dan mengeksekusinya ke database MySQL secara aman (terhindar dari SQL Injection).
                             │
                             ▼
Data berhasil disimpan, Model mengembalikan objek data ke Controller.
```

---

## [PENJELASAN TEKNIS MASING-MASING FILE]

### 1. `Admin.php`
*   **Fungsi**: Merepresentasikan akun pengelola platform.
*   **Keistimewaan**: Meng-extend class `Illuminate\Foundation\Auth\User as Authenticatable`. Hal ini wajib agar model ini dapat dikenali oleh sistem autentikasi dan session Laravel (`Auth::attempt()`, `auth()->user()`).
*   **Atribut Kunci**:
    *   `$fillable`: `['name', 'username', 'password']`.
    *   `$hidden`: Menyembunyikan hash password dan remember token agar tidak bocor saat data di-serialize.
    *   `$casts`: `'password' => 'hashed'` memastikan password terenkripsi otomatis dengan Bcrypt.
*   **Relasi**:
    *   `portfolios()`: Relasi `hasMany` (satu admin dapat mengelola banyak portofolio).
    *   `activityLogs()`: Relasi `hasMany` (satu admin memiliki banyak jejak riwayat aktivitas).

### 2. `Portfolio.php`
*   **Fungsi**: Jantung data dari aplikasi, merepresentasikan profil dan konfigurasi satu halaman portofolio UMKM.
*   **Fitur Andalan (Jawaban Penguji)**:
    *   `$casts = ['products' => 'array', 'expired_at' => 'datetime']`: Menggunakan fitur **Attribute Casting** Laravel. Di MySQL datanya disimpan sebagai teks JSON, tetapi saat diakses di kode PHP/Blade, datanya langsung menjadi Array murni tanpa perlu `json_decode()` manual!
    *   `mapsEmbedUrl()` (Accessor & Mutator): Menggunakan fitur Attribute mutator & accessor modern untuk membersihkan input Google Maps. Jika pengguna menempelkan seluruh kode tag HTML `<iframe>...</iframe>`, sistem otomatis mengekstrak URL bersih dari `src="..."` sehingga mencegah error 404 pada template.
*   **Helper Method**:
    *   `isExpired()`: Mengecek apakah tanggal kadaluarsa paket sudah lewat waktu sekarang.
    *   `remainingDays()`: Menghitung sisa hari aktif paket portofolio menggunakan library Carbon.
*   **Relasi**:
    *   `admin()`: Relasi `belongsTo` ke `Admin`.
    *   `activityLogs()`: Relasi `hasMany` ke `ActivityLog`.
    *   `slugHistories()`: Relasi `hasMany` ke `SlugHistory`.

### 3. `ActivityLog.php`
*   **Fungsi**: Mencatat rekam jejak audit (*audit trail*) setiap aksi krusial yang dilakukan admin untuk transparansi sistem.
*   **Fitur Praktis**:
    *   `$timestamps = false`: Menonaktifkan `updated_at` karena log bersifat permanen (*immutable*) dan hanya memerlukan `created_at`.
    *   `record($action, $description, $portfolioId)`: Method statis pembantu agar controller dapat mencatat log hanya dalam 1 baris kode saja.
*   **Relasi**:
    *   `admin()`: Relasi `belongsTo` ke `Admin` (pelaku aksi).
    *   `portfolio()`: Relasi `belongsTo` ke `Portfolio` (objek yang dimodifikasi, opsional).

### 4. `SlugHistory.php`
*   **Fungsi**: Menyimpan riwayat perubahan slug URL untuk mendukung fitur SEO **HTTP 301 Permanent Redirect**.
*   **Cara Kerja**: Ketika ada slug yang diubah, sistem mencatat `slug_lama` dan `slug_baru`. Jika ada pengunjung yang mengakses URL lama, controller akan mencari ke model ini dan mengarahkan pengunjung ke URL yang baru.
*   **Relasi**:
    *   `portfolio()`: Relasi `belongsTo` ke `Portfolio`.

