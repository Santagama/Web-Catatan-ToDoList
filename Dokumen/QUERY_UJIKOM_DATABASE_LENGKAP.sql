-- ==============================================================================
-- DOKUMEN QUERY RESMI DATABASE UJIKOM SMK REKAYASA PERANGKAT LUNAK (RPL)
-- APLIKASI: CMS Web Builder — Platform Web Portofolio UMKM
-- SISWA   : Hanan Aria Santagama (Kelas XII RPL 1 — SMKN 1 Majalengka)
-- DATABASE: db_cmswebbuilderhanan (MySQL / MariaDB via phpMyAdmin)
-- SOAL NO : 6 (Operasi Relasional, Stored Procedure, Function, Trigger, Commit & Rollback)
-- ==============================================================================
--
-- PANDUAN PENGGUNAAN:
-- 1. Buka phpMyAdmin -> klik nama database `db_cmswebbuilderhanan`.
-- 2. Klik tab "SQL" di bagian atas.
-- 3. Copy-paste query per bagian di bawah ini, lalu klik tombol "Kirim" / "Go".
--
-- ==============================================================================

USE db_cmswebbuilderhanan;


-- ==============================================================================
-- 1. TRIGGER (UTAMA: OTOMATIS CATAT LOG AKTIVITAS)
-- Fungsi: Saat data portofolio DITAMBAH / DIUBAH, otomatis catat ke activity_logs
-- ==============================================================================
DELIMITER $$

-- A. Trigger Setelah Tambah (AFTER INSERT)
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
        CONCAT('Menerbitkan portfolio baru: ', NEW.nama_umkm, ' (Slug: /', NEW.slug, ')'),
        NOW()
    );
END$$

-- B. Trigger Setelah Ubah (AFTER UPDATE)
DROP TRIGGER IF EXISTS trg_after_update_portfolio$$
CREATE TRIGGER trg_after_update_portfolio
AFTER UPDATE ON portfolios
FOR EACH ROW
BEGIN
    INSERT INTO activity_logs (admin_id, portfolio_id, action, description, created_at)
    VALUES (
        NEW.admin_id,
        NEW.id,
        'EDIT_PORTOFOLIO',
        CONCAT('Memperbarui data portfolio: ', NEW.nama_umkm),
        NOW()
    );
END$$

DELIMITER ;

-- CARA CEK:
SHOW TRIGGERS LIKE 'portfolios';
SELECT * FROM activity_logs ORDER BY id DESC LIMIT 3;


-- ==============================================================================
-- 2. STORED FUNCTION (CEK SLUG)
-- Fungsi: Cek apakah slug sudah dipakai (0 = tersedia, > 0 = terpakai)
-- ==============================================================================
DELIMITER $$

DROP FUNCTION IF EXISTS CekKetersediaanSlug$$
CREATE FUNCTION CekKetersediaanSlug(p_slug VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci)
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM portfolios WHERE slug = p_slug COLLATE utf8mb4_0900_ai_ci;
    RETURN total;
END$$

DELIMITER ;

-- CARA PANGGIL:
SELECT CekKetersediaanSlug('toko-roti-baru') AS status_slug;


-- ==============================================================================
-- 3. STORED PROCEDURE (TAMBAH PORTOFOLIO)
-- Fungsi: Menambah data portofolio aman (cek function slug dulu, jika ganda tolak)
-- ==============================================================================
DELIMITER $$

DROP PROCEDURE IF EXISTS TambahPortfolio$$
CREATE PROCEDURE TambahPortfolio(
    IN p_admin_id      BIGINT UNSIGNED,
    IN p_nama_umkm     VARCHAR(150),
    IN p_slug          VARCHAR(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
    IN p_bio           TEXT,
    IN p_whatsapp      VARCHAR(20),
    IN p_template_id   VARCHAR(50),
    IN p_status        VARCHAR(20)
)
BEGIN
    IF CekKetersediaanSlug(p_slug) > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Slug sudah digunakan!';
    ELSE
        INSERT INTO portfolios (admin_id, nama_umkm, slug, bio, whatsapp, template_id, status, created_at, updated_at)
        VALUES (p_admin_id, p_nama_umkm, p_slug, p_bio, p_whatsapp, p_template_id, p_status, NOW(), NOW());
    END IF;
END$$

DELIMITER ;

-- CARA PANGGIL:
CALL TambahPortfolio(1, 'Keripik Renyah', 'keripik-renyah', 'Camilan enak', '0895324392999', 'makanan', 'publish');


-- ==============================================================================
-- 4. OPERASI RELASIONAL (JOIN)
-- Fungsi: Menampilkan data gabungan antar tabel relasi
-- ==============================================================================
-- A. Portofolio + Nama Admin Pembuat
SELECT p.id, p.nama_umkm, p.slug, p.status, a.name AS nama_admin
FROM portfolios p
INNER JOIN admins a ON p.admin_id = a.id;

-- B. Riwayat Slug SEO 301 (3 Tabel)
SELECT sh.id, p.nama_umkm, sh.slug_lama, sh.slug_baru, a.name AS admin_pembuat
FROM slug_histories sh
INNER JOIN portfolios p ON sh.portfolio_id = p.id
INNER JOIN admins a ON p.admin_id = a.id;


-- ==============================================================================
-- 5. COMMIT & ROLLBACK (TRANSAKSI)
-- Fungsi: Batal simpan (ROLLBACK) atau simpan permanen (COMMIT)
-- ==============================================================================
-- A. DEMO ROLLBACK (Batal)
START TRANSACTION;
INSERT INTO portfolios (admin_id, nama_umkm, slug, template_id, status, created_at, updated_at)
VALUES (1, 'Toko Batal', 'toko-batal-99', 'makanan', 'draft', NOW(), NOW());
ROLLBACK;
SELECT * FROM portfolios WHERE slug = 'toko-batal-99'; -- Kosong

-- B. DEMO COMMIT (Permanen)
START TRANSACTION;
INSERT INTO portfolios (admin_id, nama_umkm, slug, template_id, status, created_at, updated_at)
VALUES (1, 'Toko Resmi', 'toko-resmi-99', 'makanan', 'publish', NOW(), NOW());
COMMIT;
SELECT * FROM portfolios WHERE slug = 'toko-resmi-99'; -- Tersimpan
