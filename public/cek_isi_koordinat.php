<?php
$mysqli = new mysqli("localhost", "root", "", "gis");
echo "🔍 AUDIT DATA KOORDINAT (POLIGON)...\n\n";

$res = $mysqli->query("SELECT permit, companyName, status, count(*) as total_titik FROM koordinat GROUP BY permit, companyName, status");
if ($res) {
    echo str_pad("PERMIT", 15) . " | " . str_pad("PERUSAHAAN", 25) . " | " . str_pad("STATUS", 15) . " | TOTAL TITIK\n";
    echo str_repeat("-", 80) . "\n";
    while($row = $res->fetch_assoc()) {
        $pr = $row['permit'] === '' ? '(KOSONG)' : $row['permit'];
        echo str_pad($pr, 15) . " | " . str_pad($row['companyName'], 25) . " | " . str_pad($row['status'], 15) . " | " . $row['total_titik'] . "\n";
    }
} else {
    echo "❌ Error: " . $mysqli->error;
}

$mysqli->close();
echo "\n\nJika angka di atas hanya satu baris, berarti data Anda menumpuk di nomor izin yang sama! 🚀";
