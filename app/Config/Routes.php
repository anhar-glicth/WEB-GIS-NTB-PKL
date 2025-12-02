<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = Services::routes();

// ========================
// DEFAULT ROUTE
// ========================
$routes->get('/', 'Home::index');

// ========================
// AUTH ROUTES
// ========================
$routes->get('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
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

    // User Management (Di dalam group 'admin' untuk akses 'admin/user/*')
    $routes->get('userList', 'Admin::userList');     // OK (camelCase)
    $routes->get('createUser', 'Admin::createUser'); // FIX: Diubah menjadi 'createUser' agar sesuai dengan permintaan Anda
    $routes->post('saveUser', 'Admin::saveUser');    // Simpan user baru/edit
    
    // Route User Management yang spesifik ke Controller User:
    $routes->get('user', 'User::index'); // User Management Dashboard
    $routes->get('user/insertUser', 'User::insertUser');
    $routes->get('user/editUser/(:any)', 'User::editUser/$1');
    $routes->post('user/updateUser/(:any)', 'User::updateUser/$1'); // POST untuk update
    $routes->get('user/deleteUser/(:any)', 'User::deleteUser/$1');
    $routes->get('user/insertUserRole/(:any)', 'User::insertUserRole/$1');
    $routes->get('user/editUserRole/(:any)', 'User::editUserRole/$1');
    $routes->get('user/updateUserRole/(:any)', 'User::updateUserRole/$1');

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
    $routes->get('detail/(:num)', 'Petugas::detail/$1');
    $routes->get('acc/(:num)', 'Petugas::acc/$1');
    $routes->get('tolak/(:num)', 'Petugas::tolak/$1');
    $routes->get('download/(:num)', 'Petugas::download/$1');

    // Data perusahaan (opsional, kalau sudah ada)
    $routes->get('perusahaan', 'Petugas::perusahaan');
    $routes->get('perusahaan/detail/(:num)', 'Petugas::detailPerusahaan/$1');
    $routes->get('perusahaan/edit/(:num)', 'Petugas::editPerusahaan/$1');
    $routes->get('perusahaan/hapus/(:num)', 'Petugas::hapusPerusahaan/$1');
    // Tambahkan dua route ini
    $routes->get('identitas_perusahaan', 'Petugas::identitas_perusahaan'); 
    $routes->post('identitas_perusahaan', 'Petugas::simpan_identitas');
    
});

// ========================
// USER ROUTES (TERMASUK PERUSAHAAN DAN DETAIL BARU)
// ========================
$routes->group('user', ['filter' => 'role:user'], function($routes) {
    // Dashboard User
    $routes->get('/', 'User::index'); // Menggantikan $routes->get('/', 'Home::index'); untuk user
    
    // --- Rute Laporan User ---
    
    // FIX 1 (GET): Rute untuk link sidebar 'Input Data Tambang' -> /user/input-tambang
    // Rute untuk halaman input data tambang
    $routes->get('input-tambang', 'Home::lapor');
    $routes->post('input-tambang', 'Home::insertLaporan');
    
    // FIX 3 (POST): Memperbaiki rute lama agar mengarah ke metode yang benar (Home::insertLaporan)
    // Asumsi 'InputData' adalah typo dari 'insertLaporan'
    $routes->post('laporan/data', 'Home::insertLaporan');

    // Route untuk Laporan/Dokumen
    $routes->get('laporan-list', 'Home::simpan'); // Melihat laporan (Home::simpan)
    $routes->get('v_laporan', 'Home::simpan'); // Rute lama dipertahankan, mengarah ke Home::simpan
    $routes->post('laporan/upload', 'Home::dokumen'); // Upload dokumen/bukti
    
    // Rute Laporan lama (dipertahankan)
    $routes->get('laporan', 'Laporan::index'); // Laporan::index() untuk daftar laporan user
    $routes->get('lapor', 'Home::lapor'); // Form membuat laporan baru (dipertahankan)
    $routes->post('lapor/save', 'Home::save'); // Simpan laporan dari form 'lapor' (dipertahankan)

    // ===================================
    // RUTE BARU & PERBAIKAN IDENTITAS PERUSAHAAN
    // ===================================
    // Menampilkan detail perusahaan (Rute yang tadinya hilang)
    $routes->get('detailPerusahaan', 'User::detailPerusahaan'); 
    
    // Form Input Identitas Perusahaan (Dipindahkan ke dalam group)
    $routes->get('input-perusahaan', 'User::inputPerusahaan');
    $routes->post('input-perusahaan', 'User::saveInputPerusahaan');
});


// ========================
// LOKASI & PETA (UMUM)
// ========================
$routes->get('Home/viewMaps', 'Home::viewMaps');
$routes->get('Home/baseMaps', 'Home::baseMaps');
$routes->get('Home/marker', 'Home::marker');
$routes->get('Home/poligon', 'Home::poligon');

// Rute untuk link sidebar 'Laporan Pertambangan' di menu collapse
// Dipertahankan di sini agar base_url('Home/simpan') tetap berfungsi di luar group.
$routes->get('Home/simpan', 'Home::simpan');

$routes->get('Lokasi', 'Lokasi::index');
$routes->get('Lokasi/inputLokasi', 'Lokasi::inputLokasi');
$routes->get('Lokasi/dataLokasi', 'Lokasi::dataLokasi');
$routes->get('Lokasi/pemetaanLokasi', 'Lokasi::pemetaanLokasi');
$routes->post('Lokasi/insertData', 'Lokasi::insertData');

$routes->get('poligon', 'ControlersPoligon::index');


$routes->post('poligon/simpan', 'ControlersPoligon::simpan');
// ... di dalam group petugas ...
$routes->group('petugas', ['filter' => 'role:petugas'], function($routes) {
    // ... route petugas yang lain ...

    // Rute Baru untuk Data Poligon
    $routes->get('data-poligon', 'PetugasPoligon::index');
    $routes->get('data-poligon/hapus/(:num)', 'PetugasPoligon::hapus/$1');

});
