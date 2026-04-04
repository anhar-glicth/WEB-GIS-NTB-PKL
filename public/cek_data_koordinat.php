<?php
$mysqli = new mysqli("localhost", "root", "", "gis");
echo "🔍 MEMERIKSA STATUS POLIGON DI TABEL KOORDINAT...\n\n";

$res = $mysqli->query("SELECT status, count(*) as total, permit FROM koordinat GROUP BY status, permit");
if ($res) {
    while($row = $res->fetch_assoc()) {
        echo "Status: " . ($row['status'] ?: 'KOSONG') . " | Permit: " . $row['permit'] . " | Total Titik: " . $row['total'] . "\n";
    }
} else {
    echo "❌ Error: " . $mysqli->error;
}

$mysqli->close();
