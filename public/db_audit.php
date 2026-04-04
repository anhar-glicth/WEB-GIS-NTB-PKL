<?php
// Perbaiki Jalur: Mundur Satu Langkah (../)
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::bootWeb($paths);

$db = \Config\Database::connect();
$tables = ['users', 'auth_groups', 'auth_groups_users', 'laporan', 'perusahaan', 'titik_poligon'];

echo "<h1>📊 AUDIT INTEGRITAS DATABASE</h1>";
echo "<pre>";

foreach ($tables as $table) {
    echo "<h3>Tabel: " . strtoupper($table) . "</h3>";
    
    // 1. Cek Primary Key & Kolom
    $fields = $db->getFieldData($table);
    echo "<b>KOLOM & KUNCI UTAMA (PRIMARY):</b>\n";
    foreach ($fields as $field) {
        $pk = ($field->primary_key) ? " [PRIMARY KEY]" : "";
        echo "- {$field->name} ({$field->type}){$pk}\n";
    }

    // 2. Cek Foreign Key (Relasi)
    $fks = $db->getForeignKeyData($table);
    echo "\n<b>RELASI (FOREIGN KEY) KE TABEL LAIN:</b>\n";
    if (empty($fks)) {
        echo "(Tidak ada Relasi Langsung/Manual)\n";
    } else {
        foreach ($fks as $fk) {
            echo "- {$fk->column_name} -> {$fk->foreign_table_name}({$fk->foreign_column_name})\n";
        }
    }
    echo "<hr>";
}

echo "</pre>";
