# Panduan Resmi Soal No. 6 Ujikom: Praktik Database Tingkat Lanjut

**Nama Siswa**: Hanan Aria Santagama  
**Kelas**: XII RPL 1 — SMKN 1 Majalengka  
**Nama Database**: `db_cmswebbuilderhanan`  
**Bunyi Soal No. 6**:
> *"Pada database, buat tabel yang sesuai dengan fitur, lakukan operasi relasional, stored procedure, function, trigger serta perintah commit dan rollback."*

---

## 1. Bagaimana Alur Ujian Soal No. 6 Ini? (Realita di Depan Penguji)

Banyak siswa bingung: *"Apakah ini diketik di codingan Laravel atau di phpMyAdmin?"*

**Jawabannya:**
* **Tabel & Relasinya** sudah dibuat otomatis oleh Laravel lewat perintah `php artisan migrate`.
* **Stored Procedure, Function, Trigger, Relasi (JOIN), serta Commit & Rollback** diketik dan didemonstrasikan langsung **di tab "SQL" di phpMyAdmin**!
* Saat penguji UKK menghampiri meja kamu, penguji biasanya akan berkata:
  > *"Hanan, coba buka phpMyAdmin database kamu. Tunjukkan tabelnya, lalu coba jalankan Stored Procedure, Function, Trigger, dan contoh transaksi Commit & Rollback!"*

Di momen itulah kamu tinggal:
1. Buka browser $\rightarrow$ buka `http://localhost/phpmyadmin`.
2. Klik nama database: `db_cmswebbuilderhanan`.
3. Klik tab **SQL** di menu atas.
4. Salin (copy-paste) query di bawah ini satu per satu lalu klik tombol **"Kirim" / "Go"**.

---

## 2. Apa Saja yang Kurang dari Catatan Latihan Gurumu?

Di catatan latihan di kelas, gurumu baru memberikan **3 poin**:
1. Function (`CekKetersediaanSlug`)
2. Procedure (`TambahPortfolio`)
3. Trigger (`trg_after_insert_portfolio`)

Yang **BELUM ADA** di catatan gurumu padahal tertulis jelas di soal:
1. **Operasi Relasional (Query JOIN)** $\rightarrow$ Menampilkan gabungan data dari 2 atau 3 tabel berelasi.
2. **Perintah COMMIT dan ROLLBACK** $\rightarrow$ Menunjukkan fitur transaksi pembatalan dan penyimpanan permanen database.

Dan yang **HARUS DISESUAIKAN (KARENA BEDA NAMA KOLOM)**:
| Kolom di Catatan Latihan Lama | Kolom di Database Nyata Kamu | Akibat jika Pakai Catatan Lama |
| :--- | :--- | :--- |
| `nama_web` | `nama_umkm` | Error: Unknown column 'nama_web' |
| `bio_deskripsi` | `bio` | Error: Unknown column 'bio_deskripsi' |
| `kontak_sosmed` | `whatsapp` | Error: Unknown column 'kontak_sosmed' |
| `logo_url`, `banner_url` | `logo_path`, `banner_path` | Error: Unknown column |
| `updated_at` di `activity_logs` | *(Hanya ada `created_at`)* | **Error fatal: Unknown column 'updated_at'** |

Di bawah ini, semua query sudah **diperbaiki 100% pas dengan database aslimu!**

---

## 3. Query Lengkap Siap Eksekusi (Tinggal Copy-Paste)

### POIN A: Operasi Relasional (Query JOIN Antar Tabel)

Digunakan untuk membuktikan bahwa tabel-tabel di database saling berhubungan (Relasional) melalui Foreign Key.

#### A.1. INNER JOIN (Portofolio + Nama Admin Pembuat)
```sql
SELECT 
    p.id AS portfolio_id,
    p.nama_umkm,
    p.slug,
    p.template_id,
    p.status,
    a.name AS nama_admin,
    a.username
FROM portfolios p
INNER JOIN admins a ON p.admin_id = a.id
ORDER BY p.id DESC;
```
* **Penjelasan untuk Penguji**: *"Query ini menggabungkan tabel `portfolios` dan `admins` berdasarkan relasi Foreign Key `portfolios.admin_id = admins.id`, sehingga kita tahu siapa admin yang bertanggung jawab atas website UMKM tersebut."*

#### A.2. RELASI 3 TABEL (Riwayat Perubahan Slug SEO 301)
```sql
SELECT 
    sh.id AS history_id,
    p.nama_umkm,
    sh.slug_lama,
    sh.slug_baru,
    sh.created_at AS tanggal_ubah,
    a.name AS admin_pembuat
FROM slug_histories sh
INNER JOIN portfolios p ON sh.portfolio_id = p.id
INNER JOIN admins a ON p.admin_id = a.id
ORDER BY sh.id DESC;
```
* **Penjelasan untuk Penguji**: *"Query ini menghubungkan 3 tabel sekaligus (`slug_histories`, `portfolios`, dan `admins`) untuk melihat jejak perubahan URL lama ke URL baru beserta nama adminnya."*

---

### POIN B: Stored Function (`CekKetersediaanSlug`)

Berfungsi untuk memeriksa apakah sebuah slug/URL sudah pernah dipakai atau belum. Fungsi ini mengembalikan nilai angka: `0` jika slug bebas, atau `> 0` jika sudah dipakai.

#### B.1. Cara Membuat Function (Ketik di Tab SQL phpMyAdmin):
```sql
DELIMITER $$

DROP FUNCTION IF EXISTS CekKetersediaanSlug$$

CREATE FUNCTION CekKetersediaanSlug(p_slug VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci)
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM portfolios WHERE slug = p_slug;
    RETURN total;
END$$

DELIMITER ;
```

#### B.2. Cara Menjalankan & Menampilkan ke Penguji:
```sql
-- Uji slug yang belum pernah ada (Harus menghasilkan angka 0):
SELECT CekKetersediaanSlug('toko-kue-baru-majalengka') AS status_slug;

-- Uji slug yang sudah ada di database (Harus menghasilkan angka 1):
SELECT CekKetersediaanSlug('kopi-senja') AS status_slug;
```
* **Penjelasan untuk Penguji**: *"Fungsi ini bertindak sebagai validator di level database, Pak/Bu. Mengembalikan 0 jika slug masih tersedia, dan 1 jika sudah dipakai."*

---

### POIN C: Stored Procedure (`TambahPortfolio`)

Kumpulan prosedur SQL untuk menambahkan portofolio baru. Di dalamnya otomatis memanggil Stored Function `CekKetersediaanSlug`. Jika slug ternyata sudah ada yang memakai, sistem melempar error penolakan (`SIGNAL SQLSTATE '45000'`).

#### C.1. Cara Membuat Procedure (Ketik di Tab SQL phpMyAdmin):
```sql
DELIMITER $$

DROP PROCEDURE IF EXISTS TambahPortfolio$$

CREATE PROCEDURE TambahPortfolio(
    IN p_admin_id      BIGINT UNSIGNED,
    IN p_nama_umkm     VARCHAR(150),
    IN p_slug          VARCHAR(150),
    IN p_bio           TEXT,
    IN p_whatsapp      VARCHAR(20),
    IN p_template_id   VARCHAR(50),
    IN p_status        VARCHAR(20)
)
BEGIN
    -- 1. Validasi slug menggunakan Stored Function
    IF CekKetersediaanSlug(p_slug) > 0 THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Error Database: Slug/URL website tersebut sudah digunakan!';
    ELSE
        -- 2. Insert jika slug belum digunakan
        INSERT INTO portfolios (
            admin_id, nama_umkm, slug, bio, whatsapp, template_id, status, created_at, updated_at
        )
        VALUES (
            p_admin_id, p_nama_umkm, p_slug, p_bio, p_whatsapp, p_template_id, p_status, NOW(), NOW()
        );
    END IF;
END$$

DELIMITER ;
```

#### C.2. Cara Memanggil & Menguji ke Penguji:
```sql
-- Panggil procedure untuk menambah UMKM baru:
CALL TambahPortfolio(
    1,
    'Keripik Pisang Majalengka',
    'keripik-pisang-majalengka',
    'Camilan renyah manis gurih khas Majalengka',
    '0895324392999',
    'makanan',
    'publish'
);
```
* **Demo Penolakan (Error Handling)**:
  Coba jalankan query `CALL` di atas sekali lagi dengan slug yang sama (`keripik-pisang-majalengka`). 
  phpMyAdmin akan menampilkan pesan error merah:  
  *`#1644 - Error Database: Slug/URL website tersebut sudah digunakan!`*  
  *(Ini membuktikan validasi database kamu bekerja 100%!)*

---

### POIN D: Database Trigger (`trg_after_insert_portfolio`)

Trigger adalah pemicu otomatis. Setiap kali ada website portofolio baru berhasil dimasukkan ke tabel `portfolios`, trigger ini secara otomatis mencatat audit aktivitas ke tabel `activity_logs`.

#### D.1. Cara Membuat Trigger (Ketik di Tab SQL phpMyAdmin):
```sql
DELIMITER $$

DROP TRIGGER IF EXISTS trg_after_insert_portfolio$$

CREATE TRIGGER trg_after_insert_portfolio
AFTER INSERT ON portfolios
FOR EACH ROW
BEGIN
    INSERT INTO activity_logs (admin_id, portfolio_id, action, description, created_at)
    VALUES (
        NEW.admin_id, 
        NEW.id, 
        'TAMBAH_PORTOFOLIO', 
        CONCAT('Menerbitkan website portofolio baru: ', NEW.nama_umkm, ' (Slug: /', NEW.slug, ')'), 
        NOW()
    );
END$$

DELIMITER ;
```

#### D.2. Cara Melihat Daftar Trigger yang Terpasang:
```sql
SHOW TRIGGERS LIKE 'portfolios';
```

#### D.3. Cara Membuktikan Trigger Berjalan ke Penguji:
1. Tambah 1 data portofolio (bisa lewat form web atau query `CALL TambahPortfolio(...)`).
2. Jalankan query cek log:
   ```sql
   SELECT * FROM activity_logs ORDER BY id DESC LIMIT 1;
   ```
   *Buktikan ke penguji bahwa di tabel `activity_logs` otomatis muncul baris baru tanpa kita ketik query INSERT secara manual!*

---

### POIN E: Perintah Transaksi (COMMIT dan ROLLBACK)

Membuktikan prinsip **ACID (Atomicity, Consistency, Isolation, Durability)** pada database MySQL InnoDB.

#### E.1. DEMO ROLLBACK (Data Dibatalkan & Kembali Bersih):
Jalankan blok berikut sekaligus di tab SQL phpMyAdmin:
```sql
START TRANSACTION;

-- Masukkan data percobaan
INSERT INTO portfolios (admin_id, nama_umkm, slug, template_id, status, created_at, updated_at)
VALUES (1, 'Toko Batal Uji Coba', 'toko-batal-uji-coba-999', 'makanan', 'draft', NOW(), NOW());

-- Batalkan perubahan sebelum tersimpan permanen:
ROLLBACK;

-- Buktikan datanya TIDAK ADA karena sudah di-ROLLBACK:
SELECT * FROM portfolios WHERE slug = 'toko-batal-uji-coba-999';
```
* **Penjelasan untuk Penguji**: *"Saat `START TRANSACTION` dimulai lalu kita panggil `ROLLBACK`, MySQL akan membatalkan seluruh query INSERT yang baru saja dijalankan sehingga integritas database tetap terjaga dan tidak ada sampah data."*

#### E.2. DEMO COMMIT (Data Disimpan Permanen ke Disk):
Jalankan blok berikut di tab SQL phpMyAdmin:
```sql
START TRANSACTION;

-- Masukkan data resmi
INSERT INTO portfolios (admin_id, nama_umkm, slug, template_id, status, created_at, updated_at)
VALUES (1, 'Batik Majalengka Asli', 'batik-majalengka-asli', 'barang', 'publish', NOW(), NOW());

-- Simpan permanen ke disk:
COMMIT;

-- Buktikan datanya BERHASIL TERSIMPAN:
SELECT * FROM portfolios WHERE slug = 'batik-majalengka-asli';
```
* **Penjelasan untuk Penguji**: *"Dengan perintah `COMMIT`, transaksi dinyatakan sukses dan perubahan data langsung disimpan permanen ke disk database."*

---

## 4. Rangkuman Pertanyaan & Jawaban Sidang Penguji

| Pertanyaan Penguji | Jawaban Mantap Hanan |
| :--- | :--- |
| **"Apa bedanya Stored Procedure dan Stored Function?"** | *"Stored Function **wajib mengembalikan satu nilai balik (RETURN)** dan bisa dipanggil langsung di dalam perintah SELECT. Sedangkan Stored Procedure adalah kumpulan instruksi aksi/logika yang tidak wajib return nilai dan dipanggil menggunakan perintah `CALL`."* |
| **"Kapan Trigger dijalankan?"** | *"Trigger dijalankan secara otomatis oleh database engine MySQL sesaat setelah (AFTER) atau sebelum (BEFORE) terjadi event INSERT, UPDATE, atau DELETE pada tabel target."* |
| **"Apa fungsi COMMIT dan ROLLBACK?"** | *"Untuk menjaga konsistensi transaksi (ACID). `COMMIT` untuk menyimpan perubahan secara permanen, sedangkan `ROLLBACK` untuk membatalkan seluruh perintah jika terjadi error di tengah proses."* |
