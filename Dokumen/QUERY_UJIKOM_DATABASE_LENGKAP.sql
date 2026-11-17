-- ==============================================================================
-- QUERY DATABASE UJIKOM SMK RPL (DATABASE: db_cmswebbuilderhanan)
-- ==============================================================================

-- ==============================================================================
-- 1. TRIGGER (UTAMA: OTOMATIS CATAT LOG AKTIVITAS)
-- Fungsi: Setiap kali data portofolio DITAMBAH atau DIUBAH, sistem otomatis
--         mencatat audit jejak aktivitas ke tabel activity_logs.
-- ==============================================================================

DELIMITER $$

-- A. Trigger Setelah Tambah Data (AFTER INSERT)
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

-- B. Trigger Setelah Ubah Data (AFTER UPDATE)
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

-- CARA CEK TRIGGER:
SHOW TRIGGERS LIKE 'portfolios';
SELECT * FROM activity_logs ORDER BY id DESC LIMIT 3;


-- ==============================================================================
-- 2. STORED FUNCTION (CEK KETERSEDIAAN SLUG)
-- Fungsi: Mengecek apakah slug/URL sudah dipakai (0 = tersedia, > 0 = terpakai).
-- ==============================================================================

DELIMITER $$

DROP FUNCTION IF EXISTS CekKetersediaanSlug$$
CREATE FUNCTION CekKetersediaanSlug(p_slug VARCHAR(150))
RETURNS INT
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE total INT;
    SELECT COUNT(*) INTO total FROM portfolios WHERE slug = p_slug;
    RETURN total;
END$$

DELIMITER ;

-- CARA PANGGIL FUNCTION:
SELECT CekKetersediaanSlug('toko-roti-baru') AS status_slug;


-- ==============================================================================
-- 3. STORED PROCEDURE (TAMBAH PORTOFOLIO DENGAN VALIDASI)
-- Fungsi: Menambah portofolio secara aman. Jika slug sudah ada, transaksi ditolak.
-- ==============================================================================

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
    IF CekKetersediaanSlug(p_slug) > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Slug sudah digunakan!';
    ELSE
        INSERT INTO portfolios (admin_id, nama_umkm, slug, bio, whatsapp, template_id, status, created_at, updated_at)
        VALUES (p_admin_id, p_nama_umkm, p_slug, p_bio, p_whatsapp, p_template_id, p_status, NOW(), NOW());
    END IF;
END$$

DELIMITER ;

-- CARA PANGGIL PROCEDURE:
CALL TambahPortfolio(1, 'Keripik Renyah', 'keripik-renyah', 'Camilan enak', '0895324392999', 'makanan', 'publish');


-- ==============================================================================
-- 4. OPERASI RELASIONAL (JOIN ANTAR TABEL)
-- Fungsi: Menampilkan data gabungan antar tabel berelasi (FK).
-- ==============================================================================

-- A. Portofolio + Nama Admin Pembuat (INNER JOIN)
SELECT p.id, p.nama_umkm, p.slug, p.status, a.name AS nama_admin
FROM portfolios p
INNER JOIN admins a ON p.admin_id = a.id;

-- B. Riwayat Perubahan Slug SEO 301 (JOIN 3 Tabel)
SELECT sh.id, p.nama_umkm, sh.slug_lama, sh.slug_baru, a.name AS admin_pembuat
FROM slug_histories sh
INNER JOIN portfolios p ON sh.portfolio_id = p.id
INNER JOIN admins a ON p.admin_id = a.id;


-- ==============================================================================
-- 5. COMMIT & ROLLBACK (TRANSAKSI DATABASE)
-- Fungsi: Membatalkan perubahan (ROLLBACK) atau menyimpan permanen (COMMIT).
-- ==============================================================================

-- A. DEMO ROLLBACK (Batal Simpan)
START TRANSACTION;
INSERT INTO portfolios (admin_id, nama_umkm, slug, template_id, status, created_at, updated_at)
VALUES (1, 'Toko Batal', 'toko-batal-99', 'makanan', 'draft', NOW(), NOW());
ROLLBACK;
SELECT * FROM portfolios WHERE slug = 'toko-batal-99'; -- Hasil: Kosong

-- B. DEMO COMMIT (Simpan Permanen)
START TRANSACTION;
INSERT INTO portfolios (admin_id, nama_umkm, slug, template_id, status, created_at, updated_at)
VALUES (1, 'Toko Resmi', 'toko-resmi-99', 'makanan', 'publish', NOW(), NOW());
COMMIT;
SELECT * FROM portfolios WHERE slug = 'toko-resmi-99'; -- Hasil: Tersimpan
