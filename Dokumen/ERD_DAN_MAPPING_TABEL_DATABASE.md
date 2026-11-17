# DOKUMEN ERD & MAPPING TABEL DATABASE
## PLATFORM CMS WEB BUILDER - PORTOFOLIO UMKM
**Penyusun:** Hanan Aria Santagama  
**Kelas / Jurusan:** XII RPL 1 — Rekayasa Perangkat Lunak  
**Sekolah:** SMKN 1 Majalengka  
**Sistem Basis Data:** MySQL (InnoDb Engine) / Eloquent ORM Laravel 13

---

## 1. Apa itu ERD & Mapping Tabel? (Penjelasan Singkat untuk Penguji)

* **ERD (Entity Relationship Diagram)** adalah diagram visual yang menggambarkan rancangan database: tabel-tabel apa saja yang ada (*Entitas*), data apa saja yang disimpan di dalamnya (*Atribut*), serta bagaimana tabel-tabel tersebut saling terhubung satu sama lain (*Relasi*).
* **Mapping Tabel (Kamus Data / Relational Mapping)** adalah tabel rincian teknis yang menjelaskan nama kolom, tipe data, panjang karakter, batasan (*constraint* seperti Primary Key/Foreign Key/Unique), dan keterangannya secara terstruktur.

---

## 2. Diagram ERD (Entity Relationship Diagram) — Notasi Peter Chen

Diagram ini menggunakan standar **Notasi Peter Chen (Conceptual Data Model)**:
* **Persegi Panjang** = Entitas (`admins`, `portfolios`, `activity_logs`, `slug_histories`)
* **Belah Ketupat (Diamond)** = Relasi (`mengelola`, `mencatat`, `menjadi_objek`, `memiliki`)
* **Elips / Oval** = Atribut data (dengan teks bergaris bawah `<u>...</u>` untuk Primary Key)
* **Kardinalitas** = One to Many (`1 : N`)

```mermaid
flowchart TB
    %% Entitas Utama (Persegi Panjang)
    E_ADMIN["admins<br>[Entitas Admin]"]
    E_PORTFOLIO["portfolios<br>[Entitas Portofolio UMKM]"]
    E_LOGS["activity_logs<br>[Entitas Log Aktivitas]"]
    E_SLUG["slug_histories<br>[Entitas Riwayat Slug]"]

    %% Relasi (Belah Ketupat / Diamond)
    R_KELOLA{"mengelola"}
    R_CATAT{"mencatat"}
    R_AUDIT{"menjadi_objek"}
    R_RIWAYAT{"memiliki"}

    %% Kardinalitas One to Many (1 : N)
    E_ADMIN ---|1| R_KELOLA
    R_KELOLA ---|N| E_PORTFOLIO

    E_ADMIN ---|1| R_CATAT
    R_CATAT ---|N| E_LOGS

    E_PORTFOLIO ---|1| R_AUDIT
    R_AUDIT ---|N| E_LOGS

    E_PORTFOLIO ---|1| R_RIWAYAT
    R_RIWAYAT ---|N| E_SLUG

    %% Atribut admins (Oval)
    A_ADM_1(["<u>id</u> (PK)"])
    A_ADM_2(["name"])
    A_ADM_3(["<u>username</u> (UK)"])
    A_ADM_4(["password"])
    A_ADM_5(["created_at"])
    A_ADM_6(["updated_at"])

    E_ADMIN --- A_ADM_1
    E_ADMIN --- A_ADM_2
    E_ADMIN --- A_ADM_3
    E_ADMIN --- A_ADM_4
    E_ADMIN --- A_ADM_5
    E_ADMIN --- A_ADM_6

    %% Atribut portfolios (Oval)
    A_PF_1(["<u>id</u> (PK)"])
    A_PF_2(["admin_id (FK)"])
    A_PF_3(["template_id"])
    A_PF_4(["nama_umkm"])
    A_PF_5(["<u>slug</u> (UK)"])
    A_PF_6(["bio"])
    A_PF_7(["alamat"])
    A_PF_8(["whatsapp"])
    A_PF_8B(["instagram"])
    A_PF_9(["maps_embed_url"])
    A_PF_10(["logo_path"])
    A_PF_11(["banner_path"])
    A_PF_12(["products (JSON)"])
    A_PF_13(["paket"])
    A_PF_14(["expired_at"])
    A_PF_15(["status"])
    A_PF_16(["created_at"])
    A_PF_17(["updated_at"])

    E_PORTFOLIO --- A_PF_1
    E_PORTFOLIO --- A_PF_2
    E_PORTFOLIO --- A_PF_3
    E_PORTFOLIO --- A_PF_4
    E_PORTFOLIO --- A_PF_5
    E_PORTFOLIO --- A_PF_6
    E_PORTFOLIO --- A_PF_7
    E_PORTFOLIO --- A_PF_8
    E_PORTFOLIO --- A_PF_8B
    E_PORTFOLIO --- A_PF_9
    E_PORTFOLIO --- A_PF_10
    E_PORTFOLIO --- A_PF_11
    E_PORTFOLIO --- A_PF_12
    E_PORTFOLIO --- A_PF_13
    E_PORTFOLIO --- A_PF_14
    E_PORTFOLIO --- A_PF_15
    E_PORTFOLIO --- A_PF_16
    E_PORTFOLIO --- A_PF_17

    %% Atribut activity_logs (Oval)
    A_LOG_1(["<u>id</u> (PK)"])
    A_LOG_2(["admin_id (FK)"])
    A_LOG_3(["portfolio_id (FK)"])
    A_LOG_4(["action"])
    A_LOG_5(["description"])
    A_LOG_6(["created_at"])

    E_LOGS --- A_LOG_1
    E_LOGS --- A_LOG_2
    E_LOGS --- A_LOG_3
    E_LOGS --- A_LOG_4
    E_LOGS --- A_LOG_5
    E_LOGS --- A_LOG_6

    %% Atribut slug_histories (Oval)
    A_SLG_1(["<u>id</u> (PK)"])
    A_SLG_2(["portfolio_id (FK)"])
    A_SLG_3(["slug_lama"])
    A_SLG_4(["slug_baru"])
    A_SLG_5(["created_at"])

    E_SLUG --- A_SLG_1
    E_SLUG --- A_SLG_2
    E_SLUG --- A_SLG_3
    E_SLUG --- A_SLG_4
    E_SLUG --- A_SLG_5

    %% Styling Warna Obsidian
    classDef entityStyle fill:#1e293b,stroke:#0f172a,stroke-width:3px,color:#ffffff,font-weight:bold
    classDef relationStyle fill:#0f766e,stroke:#134e4a,stroke-width:2px,color:#ffffff,font-weight:bold
    classDef pkStyle fill:#1e3a8a,stroke:#3b82f6,stroke-width:2px,color:#ffffff,font-weight:bold
    classDef fkStyle fill:#312e81,stroke:#6366f1,stroke-width:1.5px,color:#e0e7ff
    classDef attrStyle fill:#334155,stroke:#1e293b,stroke-width:1.5px,color:#f8fafc

    class E_ADMIN,E_PORTFOLIO,E_LOGS,E_SLUG entityStyle
    class R_KELOLA,R_CATAT,R_AUDIT,R_RIWAYAT relationStyle
    class A_ADM_1,A_ADM_3,A_PF_1,A_PF_5,A_LOG_1,A_SLG_1 pkStyle
    class A_PF_2,A_LOG_2,A_LOG_3,A_SLG_2 fkStyle
    class A_ADM_2,A_ADM_4,A_ADM_5,A_ADM_6,A_PF_3,A_PF_4,A_PF_6,A_PF_7,A_PF_8,A_PF_8B,A_PF_9,A_PF_10,A_PF_11,A_PF_12,A_PF_13,A_PF_14,A_PF_15,A_PF_16,A_PF_17,A_LOG_4,A_LOG_5,A_LOG_6,A_SLG_3,A_SLG_4,A_SLG_5 attrStyle
```

---

## 3. Diagram Relasi Fisik Antar-Tabel (Physical Table Mapping)

Diagram di bawah ini menggambarkan pemetaan teknis tabel basis data MySQL (Primary Key, Foreign Key, dan Tipe Kolom):

```mermaid
erDiagram
    ADMINS ||--o{ PORTFOLIOS : "mengelola / menerbitkan (1:N)"
    ADMINS ||--o{ ACTIVITY_LOGS : "melakukan aksi (1:N)"
    PORTFOLIOS ||--o{ ACTIVITY_LOGS : "menjadi objek audit (1:N)"
    PORTFOLIOS ||--o{ SLUG_HISTORIES : "memiliki riwayat URL (1:N)"

    ADMINS {
        bigint_unsigned id PK "Auto Increment"
        varchar_100 name "Nama Lengkap Admin"
        varchar_50 username UK "Username Login Unik"
        varchar_255 password "Hash Bcrypt Password"
        timestamp created_at "Waktu Akun Dibuat"
        timestamp updated_at "Waktu Profil Diperbarui"
    }

    PORTFOLIOS {
        bigint_unsigned id PK "Auto Increment"
        bigint_unsigned admin_id FK "Relasi ke Admins"
        varchar_50 template_id "Template (minuman, makanan, jasa, dll)"
        varchar_150 nama_umkm "Nama Usaha / Brand UMKM"
        varchar_150 slug UK "URL Publik Unik (/kopi-kenangan)"
        text bio "Deskripsi / Profil Usaha"
        text alamat "Alamat Fisik Usaha"
        varchar_20 whatsapp "Nomor WhatsApp Pemesanan"
        varchar_100 instagram "Akun Instagram Resmi"
        text maps_embed_url "URL Sematan Google Maps"
        varchar_255 logo_path "Lokasi File Logo di Storage"
        varchar_255 banner_path "Lokasi File Banner di Storage"
        json products "Daftar Produk Unggulan (Array JSON)"
        varchar_20 paket "Paket (3_bulan, 1_tahun, tanpa_batas)"
        timestamp expired_at "Masa Aktif Paket Berakhir"
        varchar_20 status "Status Web (draft / publish)"
        timestamp created_at "Waktu Didaftarkan"
        timestamp updated_at "Waktu Terakhir Diedit"
    }

    ACTIVITY_LOGS {
        bigint_unsigned id PK "Auto Increment"
        bigint_unsigned admin_id FK "Relasi ke Admin Pelaku"
        bigint_unsigned portfolio_id FK "Relasi ke Portofolio (Nullable)"
        varchar_100 action "Kode Aksi (LOGIN, TAMBAH, EDIT, HAPUS)"
        text description "Narasi Deskripsi Aktivitas"
        timestamp created_at "Waktu Terjadinya Aktivitas"
    }

    SLUG_HISTORIES {
        bigint_unsigned id PK "Auto Increment"
        bigint_unsigned portfolio_id FK "Relasi ke Portofolio"
        varchar_150 slug_lama "Slug Lama (Indexed)"
        varchar_150 slug_baru "Slug Baru Tujuan Redirect"
        timestamp created_at "Waktu Pergantian Slug"
    }
```

---

## 4. Mapping Tabel & Kamus Data (Data Dictionary)

### A. Tabel `admins`
Tabel master untuk menyimpan akun pengelola sistem platform CMS Web Builder.

| No | Nama Kolom | Tipe Data | Nullable | Kunci | Nilai Default | Keterangan & Fungsi |
| :--- | :--- | :--- | :---: | :---: | :--- | :--- |
| 1 | `id` | BIGINT UNSIGNED | Tidak | **PK** | AUTO_INCREMENT | Identifier unik akun admin |
| 2 | `name` | VARCHAR(100) | Tidak | - | - | Nama lengkap admin pengelola |
| 3 | `username` | VARCHAR(50) | Tidak | **UK** | - | Username untuk login (unik, tidak boleh kembar) |
| 4 | `password` | VARCHAR(255) | Tidak | - | - | Kata sandi login terenkripsi algoritma Bcrypt |
| 5 | `created_at` | TIMESTAMP | Ya | - | NULL | Waktu akun admin dibuat |
| 6 | `updated_at` | TIMESTAMP | Ya | - | NULL | Waktu profil admin terakhir diperbarui |

---

### B. Tabel `portfolios`
Tabel operasional utama untuk menyimpan seluruh data website portofolio klien UMKM.

| No | Nama Kolom | Tipe Data | Nullable | Kunci | Nilai Default | Keterangan & Fungsi |
| :--- | :--- | :--- | :---: | :---: | :--- | :--- |
| 1 | `id` | BIGINT UNSIGNED | Tidak | **PK** | AUTO_INCREMENT | Identifier unik portofolio UMKM |
| 2 | `admin_id` | BIGINT UNSIGNED | Tidak | **FK** | - | Relasi ke `admins.id` (Admin yang mendaftarkan) |
| 3 | `template_id` | VARCHAR(50) | Tidak | - | `'minuman'` | Pilihan konsep visual (`minuman`, `makanan`, `barang`, `tokoh`, `jasa`) |
| 4 | `nama_umkm`   | VARCHAR(150) | Tidak | - | - | Nama usaha atau brand resmi UMKM |
| 5 | `slug` | VARCHAR(150) | Tidak | **UK** | - | Alamat URL unik publik (misal: `/kopi-kenangan`) |
| 6 | `bio` | TEXT | Ya | - | NULL | Profil singkat, cerita usaha, atau keunggulan produk |
| 7 | `alamat` | TEXT | Ya | - | NULL | Alamat fisik kedai/toko untuk rute Google Maps |
| 8 | `whatsapp` | VARCHAR(20) | Ya | - | NULL | Nomor kontak WA untuk tombol direct order |
| 9 | `instagram` | VARCHAR(100) | Ya | - | NULL | Username/link akun Instagram resmi UMKM |
| 10 | `maps_embed_url`| TEXT | Ya | - | NULL | URL sematan Google Maps iframe (disanitasi otomatis) |
| 11 | `logo_path` | VARCHAR(255) | Ya | - | NULL | Path letak file logo di `storage/app/public/uploads` |
| 12 | `banner_path` | VARCHAR(255) | Ya | - | NULL | Path letak file banner di `storage/app/public/uploads` |
| 13 | `products` | JSON | Ya | - | NULL | Array JSON fleksibel (Nama produk, harga, foto, deskripsi) |
| 14 | `paket` | VARCHAR(20) | Ya | - | NULL | Jenis paket: `'3_bulan'`, `'1_tahun'`, atau `'tanpa_batas'` |
| 15 | `expired_at` | TIMESTAMP | Ya | - | NULL | Tanggal berakhir masa aktif paket berlangganan |
| 16 | `status` | VARCHAR(20) | Tidak | - | `'draft'` | Status akses web: `'draft'` (tertutup) atau `'publish'` (publik) |
| 17 | `created_at` | TIMESTAMP | Ya | - | NULL | Waktu pendaftaran pertama kali |
| 18 | `updated_at` | TIMESTAMP | Ya | - | NULL | Waktu terakhir perubahan data UMKM |

---

### C. Tabel `activity_logs`
Tabel audit trail (rekam jejak sistem) untuk menjamin akuntabilitas seluruh aksi admin.

| No | Nama Kolom | Tipe Data | Nullable | Kunci | Nilai Default | Keterangan & Fungsi |
| :--- | :--- | :--- | :---: | :---: | :--- | :--- |
| 1 | `id` | BIGINT UNSIGNED | Tidak | **PK** | AUTO_INCREMENT | Identifier unik log aktivitas |
| 2 | `admin_id` | BIGINT UNSIGNED | Tidak | **FK** | - | Relasi ke `admins.id` (Admin yang melakukan aksi) |
| 3 | `portfolio_id`| BIGINT UNSIGNED | Ya | **FK** | NULL | Relasi ke `portfolios.id` (Opsional jika aksi spesifik ke toko) |
| 4 | `action` | VARCHAR(100) | Tidak | - | - | Kode aksi singkat (`LOGIN`, `LOGOUT`, `TAMBAH_PORTFOLIO`, `EDIT_PORTFOLIO`, `HAPUS_PORTFOLIO`) |
| 5 | `description` | TEXT | Tidak | - | - | Penjelasan naratif aksi yang dicatat |
| 6 | `created_at` | TIMESTAMP | Tidak | - | CURRENT_TIMESTAMP | Waktu persis aktivitas terjadi |

---

### D. Tabel `slug_histories`
Tabel pendukung SEO (Search Engine Optimization) untuk mencegah broken link (HTTP 404) saat UMKM mengganti nama URL usahanya.

| No | Nama Kolom | Tipe Data | Nullable | Kunci | Nilai Default | Keterangan & Fungsi |
| :--- | :--- | :--- | :---: | :---: | :--- | :--- |
| 1 | `id` | BIGINT UNSIGNED | Tidak | **PK** | AUTO_INCREMENT | Identifier unik riwayat slug |
| 2 | `portfolio_id`| BIGINT UNSIGNED | Tidak | **FK** | - | Relasi ke `portfolios.id` |
| 3 | `slug_lama` | VARCHAR(150) | Tidak | **INDEX**| - | Slug lama sebelum diedit (diberi indeks pencarian cepat) |
| 4 | `slug_baru` | VARCHAR(150) | Tidak | - | - | Slug baru tujuan redirect otomatis (HTTP 301) |
| 5 | `created_at` | TIMESTAMP | Tidak | - | CURRENT_TIMESTAMP | Waktu terjadinya pergantian slug |

---

## 4. Aturan Relasi Database & Referential Integrity

1. **`admins` ➔ `portfolios` (One-to-Many / 1 : N)**:
   - Satu Admin dapat mengelola banyak portofolio UMKM.
   - Menggunakan aturan `ON DELETE CASCADE`: Jika akun admin dihapus, portofolio yang dikelola ikut dibersihkan atau ditangani.
2. **`admins` ➔ `activity_logs` (One-to-Many / 1 : N)**:
   - Satu Admin memiliki banyak rekam jejak aktivitas audit sistem.
   - Menggunakan aturan `ON DELETE CASCADE`.
3. **`portfolios` ➔ `activity_logs` (One-to-Many / 1 : N)**:
   - Satu portofolio dapat memiliki banyak catatan log aktivitas perubahan.
   - Menggunakan aturan `ON DELETE SET NULL`: Jika toko UMKM dihapus, log aktivitas tetap tersimpan sebagai catatan historis (kolom `portfolio_id` berubah menjadi `NULL`).
4. **`portfolios` ➔ `slug_histories` (One-to-Many / 1 : N)**:
   - Satu portofolio dapat memiliki beberapa riwayat pergantian slug.
   - Menggunakan aturan `ON DELETE CASCADE`: Jika toko dihapus permanen, riwayat redirect slug-nya otomatis dibersihkan.

---

## 5. Cara Menjawab Penguji saat Menjelaskan Database

Jika penguji meminta: *"Coba jelaskan relasi database yang kamu rancang di aplikasi ini!"*, kamu bisa menjawab dengan lancar seperti ini:

> *"Database aplikasi ini terdiri dari 4 tabel utama:  
> 1. Tabel **admins** sebagai master data akun pengelola.  
> 2. Tabel **portfolios** sebagai tabel utama penyimpan profil UMKM, pilihan template, link slug unik, kontak WhatsApp & Instagram, dan kolom JSON fleksibel untuk menampung banyak produk.  
> 3. Tabel **activity_logs** yang berelasi ke admin dan portfolio untuk mencatat jejak audit (kapan admin menambah, mengedit, atau menghapus web).  
> 4. Tabel **slug_histories** yang menyimpan riwayat URL toko lama agar saat slug diedit, pelanggan yang membuka link lama otomatis dialihkan dengan redirect HTTP 301 tanpa error 404.  
> Seluruh relasi dilengkapi Foreign Key constraint dengan aturan cascade dan set-null untuk menjamin integritas data di MySQL."*
