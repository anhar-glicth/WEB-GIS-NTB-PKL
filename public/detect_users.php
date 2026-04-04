<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';
$db = \Config\Database::connect();

echo "--- DAFTAR ROLE TERDAFTAR ---\n";
$groups = $db->table('auth_groups')->get()->getResultArray();
foreach($groups as $g) echo "ID: {$g['id']} | ROLE: {$g['name']}\n";

echo "\n--- DAFTAR AKUN ---\n";
$users = $db->table('users')->select('id, email, username')->get()->getResultArray();
foreach($users as $u) {
    // Cari role si user ini
    $rel = $db->table('auth_groups_users')
              ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
              ->where('user_id', $u['id'])
              ->get()->getRowArray();
    $role = $rel['name'] ?? 'TIDAK PUNYA ROLE';
    echo "ID: {$u['id']} | EMAIL: {$u['email']} | ROLE: $role\n";
}
