-- DATABASE FIX FINAL (RELATIONAL INTEGRITY) FOR WEB-GIS-NTB-PKL
-- Pastikan Anda telah memilih database 'gis' di phpMyAdmin sebelum menjalankan ini.

-- 1. FIX TABLE: koordinat (menambah ID primer, dokumen, dan owner identification)
ALTER TABLE `koordinat` 
ADD COLUMN `id` INT(11) AUTO_INCREMENT PRIMARY KEY FIRST,
ADD COLUMN `user_id` INT(11) NULL AFTER `id`,
ADD COLUMN `dokumen_pendukung` VARCHAR(255) NULL AFTER `foto_lokasi`,
MODIFY COLUMN `permit` VARCHAR(100) NOT NULL;

-- 2. FIX TABLE: laporan (menambah detail teknis & audit trail)
ALTER TABLE `laporan`
ADD COLUMN `nama_blok` VARCHAR(255) NULL AFTER `user_id`,
ADD COLUMN `luas_ha` FLOAT NULL AFTER `nama_blok`,
ADD COLUMN `sd_tereka` FLOAT DEFAULT 0,
ADD COLUMN `sd_terunjuk` FLOAT DEFAULT 0,
ADD COLUMN `sd_terukur` FLOAT DEFAULT 0,
ADD COLUMN `cd_terkira` FLOAT DEFAULT 0,
ADD COLUMN `cd_terbukti` FLOAT DEFAULT 0,
ADD COLUMN `prod_tahunan` FLOAT DEFAULT 0,
ADD COLUMN `catatan_penolakan` TEXT NULL AFTER `status`,
ADD COLUMN `verified_at` DATETIME NULL AFTER `updated_at`;

-- 3. CREATE TABLE: perusahaan (Identitas Perusahaan)
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

-- 4. CREATE TABLE: web_settings (CMS)
CREATE TABLE IF NOT EXISTS `web_settings` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(100) UNIQUE NOT NULL,
  `setting_value` TEXT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. SETTING FOREIGN KEYS (Relational Locks)
-- Menghubungkan Laporan, Perusahaan, dan Koordinat ke Akun Users
ALTER TABLE `laporan` ADD CONSTRAINT `fk_laporan_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `perusahaan` ADD CONSTRAINT `fk_perusahaan_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `koordinat` ADD CONSTRAINT `fk_koordinat_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Default Settings
INSERT IGNORE INTO `web_settings` (`setting_key`, `setting_value`) VALUES 
('site_name', 'WEB-GIS NTB PKL'),
('hero_image', 'https://images.unsplash.com/photo-1578321272176-b7bbc0679853?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
