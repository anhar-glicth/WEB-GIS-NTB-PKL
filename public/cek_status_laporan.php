<?php
$mysqli = new mysqli("localhost", "root", "", "gis");
echo "🔍 MEMERIKSA STATUS DI TABEL LAPORAN...\n\n";

$res = $mysqli->query("SELECT status, count(*) as total FROM laporan GROUP BY status");
if ($res) {
    while($row = $res->fetch_assoc()) {
        $st = $row['status'] === null ? 'NULL' : ($row['status'] === '' ? 'STRING KOSONG' : $row['status']);
        echo "Status Asli: [" . $st . "] | Total: " . $row['total'] . "\n";
    }
} else {
    echo "❌ Error: " . $mysqli->error;
}

$mysqli->close();
