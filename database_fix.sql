-- DATABASE FIX FOR WEB-GIS-NTB-PKL
-- Pastikan Anda telah memilih database 'gis' di phpMyAdmin sebelum menjalankan ini.

-- 1. FIX TABLE: koordinat (menambah ID primer dan field dokumen)
ALTER TABLE `koordinat` 
ADD COLUMN `id` INT(11) AUTO_INCREMENT PRIMARY KEY FIRST,
ADD COLUMN `dokumen_pendukung` VARCHAR(255) NULL AFTER `foto_lokasi`,
MODIFY COLUMN `permit` VARCHAR(100) NOT NULL;

-- 2. FIX TABLE: laporan (menambah kolom detail data teknis tambang)
ALTER TABLE `laporan`
ADD COLUMN `nama_blok` VARCHAR(255) NULL AFTER `user_id`,
ADD COLUMN `luas_ha` FLOAT NULL AFTER `nama_blok`,
ADD COLUMN `sd_tereka_volume` FLOAT DEFAULT 0 AFTER `luas_ha`,
ADD COLUMN `sd_tereka_tonase` FLOAT DEFAULT 0 AFTER `sd_tereka_volume`,
ADD COLUMN `sd_terunjuk_volume` FLOAT DEFAULT 0 AFTER `sd_tereka_tonase`,
ADD COLUMN `sd_terunjuk_tonase` FLOAT DEFAULT 0 AFTER `sd_terunjuk_volume`,
ADD COLUMN `sd_terukur_volume` FLOAT DEFAULT 0 AFTER `sd_terunjuk_tonase`,
ADD COLUMN `sd_terukur_tonase` FLOAT DEFAULT 0 AFTER `sd_terukur_volume`,
ADD COLUMN `cd_terkira_volume` FLOAT DEFAULT 0 AFTER `sd_terukur_tonase`,
ADD COLUMN `cd_terkira_tonase` FLOAT DEFAULT 0 AFTER `cd_terkira_volume`,
ADD COLUMN `cd_terbukti_volume` FLOAT DEFAULT 0 AFTER `cd_terkira_tonase`,
ADD COLUMN `cd_terbukti_tonase` FLOAT DEFAULT 0 AFTER `cd_terbukti_volume`,
ADD COLUMN `prod_harian` FLOAT DEFAULT 0 AFTER `cd_terbukti_tonase`,
ADD COLUMN `prod_bulanan` FLOAT DEFAULT 0 AFTER `prod_harian`,
ADD COLUMN `prod_tahunan` FLOAT DEFAULT 0 AFTER `prod_bulanan`,
ADD COLUMN `umur_tambang` INT NULL AFTER `prod_tahunan`,
ADD COLUMN `catatan_penolakan` TEXT NULL AFTER `status`,
ADD COLUMN `verified_at` DATETIME NULL AFTER `updated_at`;

-- 3. CREATE TABLE: perusahaan (Data identitas lengkap perusahaan)
CREATE TABLE IF NOT EXISTS `perusahaan` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) NOT NULL,
  `nama_perusahaan` VARCHAR(255) NOT NULL,
  `alamat_perusahaan` TEXT NULL,
  `npwp` VARCHAR(50) NULL,
  `jenis_usaha` VARCHAR(100) NULL,
  `tahun_berdiri` INT(4) NULL,
  `nib` VARCHAR(100) NULL,
  `izin_usaha` VARCHAR(100) NULL,
  `masa_berlaku` DATE NULL,
  `nama_direktur` VARCHAR(150) NULL,
  `email_perusahaan` VARCHAR(150) NULL,
  `no_telepon` VARCHAR(25) NULL,
  `website` VARCHAR(150) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. CREATE TABLE: inputdatatambang (Tabel opsional untuk arsip riwayat)
CREATE TABLE IF NOT EXISTS `inputdatatambang` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) NOT NULL,
  `nama_blok` VARCHAR(255) NULL,
  `luas_ha` FLOAT NULL,
  `sd_tereka_volume` FLOAT DEFAULT 0,
  `sd_tereka_tonase` FLOAT DEFAULT 0,
  `sd_terunjuk_volume` FLOAT DEFAULT 0,
  `sd_terunjuk_tonase` FLOAT DEFAULT 0,
  `sd_terukur_volume` FLOAT DEFAULT 0,
  `sd_terukur_tonase` FLOAT DEFAULT 0,
  `cd_terkira_volume` FLOAT DEFAULT 0,
  `cd_terkira_tonase` FLOAT DEFAULT 0,
  `cd_terbukti_volume` FLOAT DEFAULT 0,
  `cd_terbukti_tonase` FLOAT DEFAULT 0,
  `prod_harian` FLOAT DEFAULT 0,
  `prod_bulanan` FLOAT DEFAULT 0,
  `prod_tahunan` FLOAT DEFAULT 0,
  `umur_tambang` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
