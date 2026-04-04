<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = Services::routes();

// ========================
// DEFAULT ROUTE
// ========================
$routes->get('/', 'Landing::index');
// $routes->get('/', 'Home::index');

// Temporary Auth Fix for Petugas
$routes->get('authfix/seedPetugas', 'AuthFix::seedPetugas');
$routes->get('authfix/lantikPetugas', 'AuthFix::lantikPetugas');
$routes->get('authfix/pangkatAdmin', 'AuthFix::pangkatAdmin');

// ========================
// AUTH ROUTES
// ========================
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::attemptRegister');
$routes->get('logout', 'AuthController::logout');
$routes->get('forgotpassword', 'AuthController::forgotpassword');
$routes->get('resetpassword', 'AuthController::resetpassword');

// ========================
// ADMIN ROUTES
// ========================
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    // Dashboard & Detail
    $routes->get('/', 'Admin::index');
    $routes->get('detail/(:num)', 'Admin::detail/$1');

    // Profile Management
    $routes->get('profile', 'Admin::profile');
    $routes->get('editProfile', 'Admin::editProfile');
    $routes->post('updateProfile', 'Admin::updateProfile');

    // User Management
    // FIX 404: Menambahkan rute 'user-list' agar sesuai dengan link menu
    $routes->get('user-list', 'Admin::userList'); 
    $routes->get('userList', 'Admin::userList'); // Alias
    
    $routes->get('createUser', 'Admin::createUser');
    $routes->post('saveUser', 'Admin::saveUser');
    $routes->get('deleteUser/(:num)', 'Admin::deleteUser/$1');
    
    // Route User Management yang spesifik ke Controller User:
    $routes->get('user', 'User::index');
    $routes->get('user/insertUser', 'User::insertUser');
    $routes->get('user/editUser/(:any)', 'User::editUser/$1');
    $routes->post('user/updateUser/(:any)', 'User::updateUser/$1');
    $routes->get('user/deleteUser/(:any)', 'User::deleteUser/$1');
    $routes->get('user/insertUserRole/(:any)', 'User::insertUserRole/$1');
    $routes->get('user/editUserRole/(:any)', 'User::editUserRole/$1');
    $routes->get('user/updateUserRole/(:any)', 'User::updateUserRole/$1');

    // CMS & Web Settings
    $routes->get('settings', 'Admin::settings');
    $routes->post('updateSettings', 'Admin::updateSettings');

    // Role Management
    $routes->get('role', 'Role::index');
    $routes->get('role/insertRole', 'Role::insertRole');
    $routes->get('role/editRole/(:any)', 'Role::editRole/$1');
    $routes->get('role/updateRole/(:any)', 'Role::updateRole/$1');
    $routes->get('role/deleteRole/(:any)', 'Role::deleteRole/$1');

    // Permission Management
    $routes->get('permission', 'Permission::index');
    $routes->get('permission/insertPermission', 'Permission::insertPermission');
    $routes->get('permission/editPermission/(:any)', 'Permission::editPermission/$1');
    $routes->get('permission/updatePermission/(:any)', 'Permission::updatePermission/$1');
    $routes->get('permission/deletePermission/(:any)', 'Permission::deletePermission/$1');
});

// ========================
// PETUGAS ROUTES
// ========================
$routes->group('petugas', ['filter' => 'role:petugas'], function($routes) {

    // Dashboard utama
    $routes->get('/', 'Petugas::dashboard');

    // Laporan
    $routes->get('laporan', 'Petugas::laporan');
    $routes->get('detail_laporan/(:num)', 'Petugas::detail/$1'); // URL Baru
    $routes->get('detail/(:num)', 'Petugas::detail/$1');
    $routes->get('acc/(:num)', 'Petugas::acc/$1');
    $routes->post('tolak/(:num)', 'Petugas::tolak/$1');
//    $routes->get('tolak/(:num)', 'Petugas::tolak/$1');
    $routes->get('download/(:num)', 'Petugas::download/$1');

    // Data perusahaan
    $routes->get('perusahaan', 'Petugas::perusahaan');
    $routes->get('perusahaan/detail/(:num)', 'Petugas::detailPerusahaan/$1');
    $routes->get('perusahaan/edit/(:num)', 'Petugas::editPerusahaan/$1');
    $routes->get('perusahaan/hapus/(:num)', 'Petugas::hapusPerusahaan/$1');
    
    // Identitas Perusahaan
    $routes->get('identitas_perusahaan', 'Petugas::identitas_perusahaan'); 
    $routes->post('identitas_perusahaan', 'Petugas::simpan_identitas');

    $routes->get('profile', 'Petugas::profile');
    $routes->get('editProfile', 'Petugas::editProfile');
    $routes->post('updateProfile', 'Petugas::updateProfile');

    // Data Poligon (Hasil Inputan User) - Digabung kesini agar rapi
    $routes->get('data-poligon', 'PetugasPoligon::index');
    $routes->get('data-poligon/acc/(:any)', 'PetugasPoligon::acc/$1');
    $routes->post('data-poligon/tolak/(:any)', 'PetugasPoligon::tolak/$1');
    $routes->get('data-poligon/hapus/(:any)', 'PetugasPoligon::hapus/$1');
});

// ========================
// USER ROUTES
// ========================
$routes->group('user', ['filter' => 'role:user'], function($routes) {
    // Dashboard User
    $routes->get('/', 'User::index');
    
    // Laporan
    $routes->get('input-tambang', 'User::inputTambang');
    $routes->post('input-tambang', 'User::saveInputTambang');
    $routes->post('laporan/data', 'User::saveInputTambang');

    // Route untuk Laporan/Dokumen
    $routes->get('laporan-list', 'User::index');
    $routes->get('v_laporan', 'User::index');
    $routes->post('laporan/upload', 'Home::dokumen');
    
    // Rute Laporan lama
    $routes->get('laporan', 'Laporan::index');
    $routes->get('lapor', 'Home::lapor');
    $routes->post('lapor/save', 'Home::save');

    // Identitas Perusahaan
    $routes->get('detailPerusahaan', 'User::detailPerusahaan'); 
    $routes->get('input-perusahaan', 'User::inputPerusahaan');
    $routes->post('input-perusahaan', 'User::saveInputPerusahaan');

    // Profile & Settings
    $routes->get('profile', 'User::profile');
    $routes->get('editProfile', 'User::editProfile');
    $routes->post('updateProfile', 'User::updateProfile');
});

// ========================
// LOKASI & PETA (UMUM)
// ========================
$routes->get('Home/viewMaps', 'Home::viewMaps');
$routes->get('Home/baseMaps', 'Home::baseMaps');
$routes->get('Home/marker', 'Home::marker');
$routes->get('Home/poligon', 'Home::poligon'); // Rute lama (opsional)
$routes->get('Home/simpan', 'Home::simpan');

$routes->get('Lokasi', 'Lokasi::index');
$routes->get('Lokasi/inputLokasi', 'Lokasi::inputLokasi');
$routes->get('Lokasi/dataLokasi', 'Lokasi::dataLokasi');
$routes->get('Lokasi/pemetaanLokasi', 'Lokasi::pemetaanLokasi');
$routes->post('Lokasi/insertData', 'Lokasi::insertData');

// ========================
// RUTE POLIGON (INPUT DATA)
// ========================

// 1. Menampilkan Form Poligon
// 'poligon_view' dibutuhkan karena controller redirect kesini setelah simpan
$routes->get('poligon_view', 'ControlersPoligon::index'); 
$routes->get('poligon', 'ControlersPoligon::index'); // Alias
$routes->get('poligon/riwayat', 'ControlersPoligon::history'); // TAMBAHKAN INI

// 2. Memproses Simpan Poligon
$routes->post('poligon/simpan', 'ControlersPoligon::simpan');
$routes->post('Home/simpanPoligon', 'ControlersPoligon::simpan'); // TAMBAHKAN INI

// 3. Menghapus Poligon
$routes->get('poligon/hapus/(:any)', 'ControlersPoligon::hapusByPermit/$1');
