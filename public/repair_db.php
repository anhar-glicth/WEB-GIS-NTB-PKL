<?php
// Script Perbaikan Darurat
$mysqli = new mysqli("localhost", "root", "", "gis");
if ($mysqli->connect_errno) {
    die("Gagal konek: " . $mysqli->connect_error);
}

echo "Memperbaiki tabel 'koordinat'...\n";

// 1. Tambah Kolom status
$check = $mysqli->query("SHOW COLUMNS FROM koordinat LIKE 'status'");
if ($check->num_rows == 0) {
    $mysqli->query("ALTER TABLE koordinat ADD COLUMN status ENUM('Pending', 'Disetujui', 'Ditolak') DEFAULT 'Pending' AFTER permit");
    echo "✅ Kolom 'status' DITAMBAHKAN.\n";
} else {
    echo "ℹ️ Kolom 'status' SUDAH ADA.\n";
}

// 2. Tambah Kolom catatan_petugas
$check = $mysqli->query("SHOW COLUMNS FROM koordinat LIKE 'catatan_petugas'");
if ($check->num_rows == 0) {
    $mysqli->query("ALTER TABLE koordinat ADD COLUMN catatan_petugas TEXT AFTER status");
    echo "✅ Kolom 'catatan_petugas' DITAMBAHKAN.\n";
}

// 3. Tambah Kolom laporan_id
$check = $mysqli->query("SHOW COLUMNS FROM koordinat LIKE 'laporan_id'");
if ($check->num_rows == 0) {
    $mysqli->query("ALTER TABLE koordinat ADD COLUMN laporan_id INT(11) NULL AFTER user_id");
    echo "✅ Kolom 'laporan_id' DITAMBAHKAN.\n";
}

echo "🔥 Database SIAP DIGUNAKAN!";
$mysqli->close();
