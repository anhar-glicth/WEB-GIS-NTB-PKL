<?php
// Perbaiki Jalur: Mundur Satu Langkah (../)
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::bootWeb($paths);

$db = \Config\Database::connect();
$forge = \Config\Database::forge();

echo "<h1>🛠️ PENAMBAL STRUKTUR DATABASE</h1>";
echo "<pre>";

// 1. Tambah Kolom 'status' & 'catatan_petugas' di tabel koordinat
$fields = [
    'status' => [
        'type'       => 'ENUM',
        'constraint' => ['Pending', 'Disetujui', 'Ditolak'],
        'default'    => 'Pending',
        'after'      => 'permit'
    ],
    'catatan_petugas' => [
        'type'       => 'TEXT',
        'null'       => true,
        'after'      => 'status'
    ]
];

if (!$db->fieldExists('status', 'koordinat')) {
    $forge->addColumn('koordinat', $fields);
    echo "✅ BERHASIL: Kolom 'status' & 'catatan_petugas' sudah ditambahkan ke tabel koordinat.\n";
} else {
    echo "ℹ️ INFO: Kolom sudah ada di tabel koordinat.\n";
}

// 2. Tambah Kolom 'laporan_id' di koordinat (Dibutuhkan untuk Relasi ACC) 
if (!$db->fieldExists('laporan_id', 'koordinat')) {
    $forge->addColumn('koordinat', [
        'laporan_id' => [
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
            'after'      => 'user_id'
        ]
    ]);
    echo "✅ BERHASIL: Relasi 'laporan_id' sudah disiapkan.\n";
}

echo "</pre>";
