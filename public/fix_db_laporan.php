<?php
$mysqli = new mysqli("localhost", "root", "", "gis");
echo "🔧 Memperbaiki kolom status di tabel 'laporan'...\n";

// Ubah ENUM ke VARCHAR agar bebas menerima 'Disetujui' dan 'Ditolak'
$sql = "ALTER TABLE laporan MODIFY COLUMN status VARCHAR(50) DEFAULT 'Pending'";
if ($mysqli->query($sql)) {
    echo "✅ Kolom 'status' berhasil diubah menjadi VARCHAR(50)!\n";
} else {
    echo "❌ Gagal mengubah kolom: " . $mysqli->error . "\n";
}

// Pastikan catatan_penolakan juga ada
$check = $mysqli->query("SHOW COLUMNS FROM laporan LIKE 'catatan_penolakan'");
if ($check->num_rows == 0) {
    $mysqli->query("ALTER TABLE laporan ADD COLUMN catatan_penolakan TEXT AFTER status");
    echo "✅ Kolom 'catatan_penolakan' DITAMBAHKAN.\n";
}

echo "🔮 SISTEM LOGIN & VERIFIKASI SEKARANG SINKRON!";
$mysqli->close();
