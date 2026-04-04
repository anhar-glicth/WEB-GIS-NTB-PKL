-- DATABASE FIX FINAL (RELATIONAL INTEGRITY + REAL AUTH DEMO) FOR WEB-GIS-NTB-PKL
-- Pastikan Anda telah memilih database 'gis' di phpMyAdmin sebelum menjalankan ini.

-- 1. FIX TABLE: koordinat (menambah ID primer, dokumen, dan owner identification)
ALTER TABLE `koordinat` 
ADD COLUMN IF NOT EXISTS `id` INT(11) AUTO_INCREMENT PRIMARY KEY FIRST,
ADD COLUMN IF NOT EXISTS `user_id` INT(11) UNSIGNED NULL AFTER `id`,
ADD COLUMN IF NOT EXISTS `dokumen_pendukung` VARCHAR(255) NULL AFTER `foto_lokasi`,
MODIFY COLUMN `permit` VARCHAR(100) NOT NULL;

-- 2. FIX TABLE: laporan (menambah detail teknis & audit trail)
ALTER TABLE `laporan`
ADD COLUMN IF NOT EXISTS `nama_blok` VARCHAR(255) NULL AFTER `user_id`,
ADD COLUMN IF NOT EXISTS `luas_ha` FLOAT NULL AFTER `nama_blok`,
ADD COLUMN IF NOT EXISTS `sd_tereka` FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS `sd_terunjuk` FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS `sd_terukur` FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS `cd_terkira` FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS `cd_terbukti` FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS `prod_tahunan` FLOAT DEFAULT 0,
ADD COLUMN IF NOT EXISTS `catatan_penolakan` TEXT NULL AFTER `status`,
ADD COLUMN IF NOT EXISTS `verified_at` DATETIME NULL AFTER `updated_at`;

-- 3. CREATE TABLE: perusahaan (Identitas Perusahaan)
CREATE TABLE IF NOT EXISTS `perusahaan` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT(11) UNSIGNED NOT NULL,
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

-- 5. RELATIONAL LOCKS (Foreign Keys)
ALTER TABLE `laporan` MODIFY COLUMN `user_id` INT(11) UNSIGNED NOT NULL;
ALTER TABLE `perusahaan` MODIFY COLUMN `user_id` INT(11) UNSIGNED NOT NULL;
ALTER TABLE `koordinat` MODIFY COLUMN `user_id` INT(11) UNSIGNED NULL;

-- 6. INSERT DEMO ACCOUNTS (Myth/Auth REAL HASHES)
-- Login Email: admin@admin.com / Password: admin123
-- Login Email: petugas@petugas.com / Password: petugas123
-- Login Email: user@user.com / Password: user123
INSERT IGNORE INTO `users` (`id`, `email`, `username`, `password_hash`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.com', 'admin', '$2y$10$WOxgJR0TT3xfukUrjiKhX.j2cjiK1.u9ON.XjSUH/yf55o.5Z6zCC2', 1, NOW(), NOW()),
(2, 'petugas@petugas.com', 'petugas', '$2y$10$kwSrz.nzlEHo2VCElnzL4Ok0h.y5klWFPmQOKlS2w8fCrQyTB5xkkW', 1, NOW(), NOW()),
(3, 'user@user.com', 'user', '$2y$10$nVsLwADI4uJHvaK6eHF68.S.Fh1fUcmhXqBt837kQ34YjmAlF1Wjjm', 1, NOW(), NOW());

-- 7. ASSIGN ROLES TO ACCOUNTS (1=admin, 2=petugas, 3=user)
INSERT IGNORE INTO `auth_groups_users` (`group_id`, `user_id`) VALUES 
(1, 1), (2, 2), (3, 3);

-- Default Settings
INSERT IGNORE INTO `web_settings` (`setting_key`, `setting_value`) VALUES 
('site_name', 'WEB-GIS NTB PKL'),
('hero_image', 'https://images.unsplash.com/photo-1578321272176-b7bbc0679853?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
