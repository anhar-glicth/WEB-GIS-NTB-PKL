<?php
$mysqli = new mysqli("localhost", "root", "", "gis");
echo "🔍 MEMBERSIHKAN STATUS KOSONG DI TABEL LAPORAN...\n\n";

$res = $mysqli->query("UPDATE laporan SET status = 'pending' WHERE status = '' OR status IS NULL");
if ($res) {
    echo "✅ BERHASIL: " . $mysqli->affected_rows . " laporan telah diubah statusnya menjadi 'pending'!\n";
} else {
    echo "❌ Error: " . $mysqli->error . "\n";
}

$mysqli->close();
echo "\nDashboard Petugas sekarang seharusnya sudah terisi angkanya! 🚀";
