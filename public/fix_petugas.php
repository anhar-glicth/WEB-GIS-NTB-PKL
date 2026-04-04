<?php

// Script SUNTIK PETUGAS RESMI
define('FCPATH', __DIR__ . '/');
require_once FCPATH . '../vendor/autoload.php';

// Bootstrap CI4
$pathsConfig = FCPATH . '../app/Config/Paths.php';
require_once $pathsConfig;
$paths = new Config\Paths();
$app = require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';
$app->initialize();

// Gunakan MODEL RESMI Myth/Auth agar password-nya pas!
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

$users = new UserModel();

$email = 'petugas@petugas.com';
$pass  = 'petugas123';
$user  = 'Petugas NTB';

// 1. Cari dulu apa sudah ada? Jika ada hapus agar bersih
$existing = $users->where('email', $email)->first();
if ($u_id = $existing->id ?? null) {
    $db = \Config\Database::connect();
    $db->table('auth_groups_users')->where('user_id', $u_id)->delete();
    $users->delete($u_id, true); // permanent delete
}

// 2. Buat User Baru secara Resmi
$newUser = new User([
    'email'    => $email,
    'username' => 'petugas_gis',
    'active'   => 1
]);
$newUser->setPassword($pass);
$users->save($newUser);

// 3. Masukkan ke Group Petugas (ID: 3)
$db = \Config\Database::connect();
$newId = $users->getInsertID();

// Cek dulu ID Group Petugas berapa aslinya
$group = $db->table('auth_groups')->where('name', 'petugas')->get()->getRow();
$groupId = $group->id ?? 3;

$db->table('auth_groups_users')->insert([
    'group_id' => $groupId,
    'user_id'  => $newId
]);

echo "✅ PETUGAS BERHASIL DIBUAT secara RESMI!\n";
echo "Email: $email\n";
echo "Pass:  $pass\n";
echo "Group ID Terdeteksi: $groupId\n";
exit;
