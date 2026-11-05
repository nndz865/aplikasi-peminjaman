-- =====================================================
-- DATABASE: db_peminjaman
-- Uji Kompetensi Keahlian (UKK) RPL 2026/2027
-- =====================================================

CREATE DATABASE IF NOT EXISTS db_peminjaman CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_peminjaman;

-- Hapus tabel dan prosedur jika sudah ada (untuk keperluan re-import bersih)
DROP TRIGGER IF EXISTS trg_kurangi_stok;
DROP TRIGGER IF EXISTS trg_tambah_stok;
DROP PROCEDURE IF EXISTS sp_pinjam_alat;
DROP FUNCTION IF EXISTS hitung_denda;
DROP TABLE IF EXISTS log_aktivitas;
DROP TABLE IF EXISTS peminjaman;
DROP TABLE IF EXISTS alat;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS users;

-- 1. TABEL USERS
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'petugas', 'peminjam') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB;

-- 2. TABEL KATEGORI
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. TABEL ALAT
CREATE TABLE alat (
    id_alat INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    nama_alat VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    stok INT NOT NULL CHECK (stok >= 0),
    kondisi VARCHAR(50) NOT NULL DEFAULT 'Baik',
    lokasi VARCHAR(100) NOT NULL,
    gambar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_kategori (id_kategori),
    INDEX idx_nama_alat (nama_alat)
) ENGINE=InnoDB;

-- 4. TABEL PEMINJAMAN
CREATE TABLE peminjaman (
    id_peminjaman INT AUTO_INCREMENT PRIMARY KEY,
    kode_peminjaman VARCHAR(30) NOT NULL UNIQUE,
    id_user INT NOT NULL,
    id_alat INT NOT NULL,
    jumlah INT NOT NULL CHECK (jumlah > 0),
    tanggal_pinjam DATE NOT NULL,
    tanggal_rencana_kembali DATE NOT NULL,
    tanggal_kembali_aktual DATE NULL,
    keperluan TEXT NOT NULL,
    status ENUM('menunggu', 'disetujui', 'selesai', 'ditolak') NOT NULL DEFAULT 'menunggu',
    denda DECIMAL(12,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_alat) REFERENCES alat(id_alat) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_status (status),
    INDEX idx_tanggal (tanggal_pinjam),
    INDEX idx_user (id_user),
    INDEX idx_alat (id_alat)
) ENGINE=InnoDB;

-- 5. TABEL LOG_AKTIVITAS
CREATE TABLE log_aktivitas (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    aktivitas VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE,
    INDEX idx_user_log (id_user),
    INDEX idx_created (created_at)
) ENGINE=InnoDB;

-- =====================================================
-- STORED FUNCTION: hitung_denda
-- =====================================================
DELIMITER //
CREATE FUNCTION hitung_denda(p_rencana DATE, p_aktual DATE)
RETURNS DECIMAL(12,2)
DETERMINISTIC
BEGIN
    DECLARE v_selisih INT;
    DECLARE v_denda DECIMAL(12,2);
    
    IF p_aktual > p_rencana THEN
        SET v_selisih = DATEDIFF(p_aktual, p_rencana);
        SET v_denda = v_selisih * 5000.00;
    ELSE
        SET v_denda = 0.00;
    END IF;
    
    RETURN v_denda;
END //
DELIMITER ;

-- =====================================================
-- STORED PROCEDURE: sp_pinjam_alat
-- =====================================================
DELIMITER //
CREATE PROCEDURE sp_pinjam_alat(
    IN p_id_user INT,
    IN p_id_alat INT,
    IN p_jumlah INT,
    IN p_tanggal_pinjam DATE,
    IN p_tanggal_rencana_kembali DATE,
    IN p_keperluan TEXT,
    OUT p_result INT,
    OUT p_message VARCHAR(255)
)
proc_label: BEGIN
    DECLARE v_stok_tersedia INT;
    DECLARE v_kode VARCHAR(30);
    
    -- Handler untuk SQL Exception / Error
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_result = 0;
        SET p_message = 'Terjadi kesalahan pada database saat memproses pengajuan.';
    END;

    START TRANSACTION;

    -- Validasi jumlah harus > 0
    IF p_jumlah <= 0 THEN
        SET p_result = 0;
        SET p_message = 'Jumlah peminjaman harus lebih dari nol.';
        ROLLBACK;
        LEAVE proc_label;
    END IF;

    -- Validasi tanggal rencana kembali harus setelah atau sama dengan tanggal pinjam
    IF p_tanggal_rencana_kembali < p_tanggal_pinjam THEN
        SET p_result = 0;
        SET p_message = 'Tanggal rencana kembali tidak boleh sebelum tanggal peminjaman.';
        ROLLBACK;
        LEAVE proc_label;
    END IF;

    -- Periksa ketersediaan stok alat saat ini (lock baris dengan FOR UPDATE)
    SELECT stok INTO v_stok_tersedia FROM alat WHERE id_alat = p_id_alat FOR UPDATE;
    
    IF v_stok_tersedia IS NULL THEN
        SET p_result = 0;
        SET p_message = 'Alat tidak ditemukan.';
        ROLLBACK;
        LEAVE proc_label;
    END IF;

    IF v_stok_tersedia < p_jumlah THEN
        SET p_result = 0;
        SET p_message = 'Stok Tidak Cukup.';
        ROLLBACK;
        LEAVE proc_label;
    END IF;

    -- Generate kode peminjaman unik, misal: PJM-YYYYMMDD-XXXX
    SET v_kode = CONCAT('PJM-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', FLOOR(1000 + RAND() * 9000));

    -- Insert ke tabel peminjaman dengan status menunggu
    INSERT INTO peminjaman (
        kode_peminjaman, id_user, id_alat, jumlah, 
        tanggal_pinjam, tanggal_rencana_kembali, keperluan, status
    ) VALUES (
        v_kode, p_id_user, p_id_alat, p_jumlah, 
        p_tanggal_pinjam, p_tanggal_rencana_kembali, p_keperluan, 'menunggu'
    );

    COMMIT;
    SET p_result = 1;
    SET p_message = 'Pengajuan peminjaman berhasil dikirim.';
END //
DELIMITER ;

-- =====================================================
-- TRIGGER: trg_kurangi_stok
-- Mengurangi stok alat ketika status berubah dari 'menunggu' menjadi 'disetujui'
-- =====================================================
DELIMITER //
CREATE TRIGGER trg_kurangi_stok
AFTER UPDATE ON peminjaman
FOR EACH ROW
BEGIN
    DECLARE v_stok_sekarang INT;
    
    IF OLD.status = 'menunggu' AND NEW.status = 'disetujui' THEN
        SELECT stok INTO v_stok_sekarang FROM alat WHERE id_alat = NEW.id_alat;
        
        IF v_stok_sekarang < NEW.jumlah THEN
            SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Stok Tidak Cukup untuk menyetujui peminjaman ini.';
        ELSE
            UPDATE alat SET stok = stok - NEW.jumlah WHERE id_alat = NEW.id_alat;
        END IF;
    END IF;
END //
DELIMITER ;

-- =====================================================
-- TRIGGER: trg_tambah_stok
-- Menambahkan stok alat kembali ketika status berubah dari 'disetujui' menjadi 'selesai'
-- =====================================================
DELIMITER //
CREATE TRIGGER trg_tambah_stok
AFTER UPDATE ON peminjaman
FOR EACH ROW
BEGIN
    IF OLD.status = 'disetujui' AND NEW.status = 'selesai' THEN
        UPDATE alat SET stok = stok + NEW.jumlah WHERE id_alat = NEW.id_alat;
    END IF;
END //
DELIMITER ;

-- =====================================================
-- SEED DATA (DATA AWAL)
-- Password di-hash menggunakan password_hash() dengan BCRYPT.
-- Password demo: 
-- Admin: Admin123! ($2y$10$...)
-- Petugas: Petugas123! ($2y$10$...)
-- Peminjam: Peminjam123! ($2y$10$...)
-- =====================================================

INSERT INTO users (nama_lengkap, username, password, role) VALUES
('Administrator Utama', 'admin', '$2y$10$Jf7EIV50sf2wdg7ms6RMH.ZrbSU3RMrEZ01Xm.6EVQNqua/N4o0TS', 'admin'),
('Petugas Lab RPL', 'petugas', '$2y$10$3t6fmNAQuC6GilRKYJW3Q.cFoGMep3.dx3M3/IfGc4gK0wYq2e8oa', 'petugas'),
('Siswa Peminjam', 'peminjam', '$2y$10$pcomxLhL123Tf7kTIQz3uOBat1Pkl1y5/kDDXhrrHdKBMYqxQncca', 'peminjam');

INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Networking', 'Peralatan jaringan komputer seperti router, switch, crimping tool, dan LAN tester'),
('Electronics & Microcontroller', 'Peralatan mikrokontroler, Arduino, ESP32, sensor, dan kit elektronika'),
('Multimedia', 'Peralatan kamera, tripod, lighting, dan audio recorder'),
('Computer Hardware', 'Peralatan pendukung hardware komputer, multimeter, solder, dan power supply');

INSERT INTO alat (id_kategori, nama_alat, deskripsi, stok, kondisi, lokasi, gambar) VALUES
(1, 'Router Cisco 2911', 'Router modular untuk praktikum jaringan komputer TKJ/RPL', 5, 'Baik', 'Lemari A1 Lab Jaringan', 'assets/img/alat/router-cisco-2911.svg'),
(1, 'LAN Tester NF-468', 'Tester kabel UTP RJ45 dan RJ11', 10, 'Baik', 'Rak B2 Lab Jaringan', 'assets/img/alat/lan-tester-nf-468.svg'),
(2, 'Arduino Uno R3 Starter Kit', 'Kit lengkap mikrokontroler Arduino Uno dengan sensor dasar', 15, 'Baik', 'Lemari C1 Lab RPL', 'assets/img/alat/arduino-uno-r3.svg'),
(2, 'Multimeter Digital DT-830D', 'Alat ukur tegangan dan arus listrik digital', 12, 'Baik', 'Rak C2 Lab RPL', 'assets/img/alat/multimeter-dt-830d.svg'),
(3, 'Kamera DSLR Canon EOS 3000D', 'Kamera dokumentasi kegiatan dan praktikum multimedia', 3, 'Baik', 'Lemari Multimedia M1', 'assets/img/alat/kamera-canon-eos-3000d.svg'),
(4, 'Solder Station 936', 'Alat solder temperatur terkontrol untuk perakitan komponen', 8, 'Baik', 'Rak Toolkit Utama', 'assets/img/alat/solder-station-936.svg');

INSERT INTO log_aktivitas (id_user, aktivitas, deskripsi, ip_address) VALUES
(1, 'SEEDING', 'Inisialisasi database dan data awal sistem', '127.0.0.1');
