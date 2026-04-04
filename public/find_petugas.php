<?php
// Script untuk intip User Petugas
define('FCPATH', __DIR__ . '/');
require_once FCPATH . '../vendor/autoload.php';

// Load CI4 Bootstrap
$pathsConfig = FCPATH . '../app/Config/Paths.php';
require_once $pathsConfig;
$paths = new Config\Paths();
$app = require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';
$app->initialize();

$db = \Config\Database::connect();

// Kueri: Cari user yang tergabung ke group petugas (ID: 3)
$builder = $db->table('users');
$builder->select('users.id as userid, username, email, name as role_name');
$builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
$builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
$builder->where('auth_groups.name', 'petugas'); // Cari berdasarkan nama grup
$query = $builder->get();

$petugasList = $query->getResultArray();

header('Content-Type: application/json');
echo json_encode($petugasList, JSON_PRETTY_PRINT);
exit;
