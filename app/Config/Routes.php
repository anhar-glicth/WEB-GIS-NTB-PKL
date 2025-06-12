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
    $routes->get('/', 'Admin::index');
    $routes->get('detail/(:num)', 'Admin::detail/$1');

    // Profile
    $routes->get('profile', 'Admin::profile');
    $routes->get('editProfile', 'Admin::editProfile');
    $routes->post('updateProfile', 'Admin::updateProfile');

    // User Management
   
    $routes->get('user/insertUser', 'User::insertUser');
    $routes->get('user/editUser/(:any)', 'User::editUser/$1');
    $routes->POST('user/updateUser/(:any)', 'User::updateUser/$1');
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
    $routes->get('/', 'Petugas::index');
    $routes->get('laporan', 'Petugas::laporan');
    $routes->get('acc/(:num)', 'Petugas::acc/$1');
    $routes->get('tolak/(:num)', 'Petugas::tolak/$1');
    $routes->get('download/(:num)', 'Petugas::download/$1');
});

// ========================
// USER ROUTES
// ========================
$routes->group('user', ['filter' => 'role:user'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('laporan', 'Laporan::index');
    $routes->post('laporan/simpan', 'Laporan::simpan');
});

// Lapor routes (tetap di luar /user untuk akses langsung)
$routes->group('', ['filter' => 'role:user'], function($routes) {
    $routes->get('lapor', 'Home::lapor');
    $routes->post('lapor/save', 'Home::save');
});

// ========================
// LOKASI & PETA (UMUM)
// ========================
$routes->get('Home/viewMaps', 'Home::viewMaps');
$routes->get('Home/baseMaps', 'Home::baseMaps');
$routes->get('Home/marker', 'Home::marker');
$routes->get('Home/poligon', 'Home::poligon');

$routes->get('Lokasi', 'Lokasi::index');
$routes->get('Lokasi/inputLokasi', 'Lokasi::inputLokasi');
$routes->get('Lokasi/dataLokasi', 'Lokasi::dataLokasi');
$routes->get('Lokasi/pemetaanLokasi', 'Lokasi::pemetaanLokasi');
$routes->post('Lokasi/insertData', 'Lokasi::insertData');
$routes->get('laporan', 'Laporan::index', ['filter' => 'role:user']);
$routes->get('admin/create-user', 'Admin::createUser');
$routes->post('admin/saveUser', 'Admin::saveUser');
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('user-list', 'Admin::userList');
    $routes->get('create-user', 'Admin::createUser');
    $routes->post('saveUser', 'Admin::saveUser');
});
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    // ... existing routes ...
    $routes->get('createUser', 'Admin::createUser');
    $routes->post('saveUser', 'Admin::saveUser');
});
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('user', 'User::index');
    $routes->get('user/insertUser', 'User::insertUser');
    $routes->get('user/editUser/(:any)', 'User::editUser/$1');
    $routes->get('user/deleteUser/(:any)', 'User::deleteUser/$1');
    // dst...
});
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('user-list', 'Admin::userList');
    // ...
});
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('detail/(:num)', 'Admin::detail/$1');

    $routes->get('user-list', 'Admin::userList');       // user list
    $routes->get('create-user', 'Admin::createUser');   // create user form
    $routes->post('saveUser', 'Admin::saveUser');       // save user

    // profile
    $routes->get('profile', 'Admin::profile');
    $routes->get('editProfile', 'Admin::editProfile');
    $routes->post('updateProfile', 'Admin::updateProfile');

    // ... user list ...
     $routes->get('userList', 'Admin::userList');
    $routes->get('createUser', 'Admin::createUser');
    $routes->post('saveUser', 'Admin::saveUser');
});
$routes->get('laporan', 'Home::simpan', ['filter' => 'role:user']);
$routes->post('Home/simpan', 'Home::simpan');
 // jika handle upload
 $routes->post('Home/dokumen', 'Home::dokumen', ['filter' => 'role:user']);



$routes->group('petugas', ['filter' => 'role:petugas'], function($routes) {
    $routes->get('laporan', 'Petugas::laporan');
    // route lain khusus petugas bisa ditambahkan di sini
});


// Ubah default user dashboard ke controller lain
$routes->group('user', ['filter' => 'role:user'], function($routes) {
    $routes->get('/', 'Home::index'); // misalnya arahkan ke Home
});
$routes->get('Home/simpan', 'Home::simpan');
// Untuk User
$routes->get('/user/laporan', 'Home::laporanUser');
$routes->post('/user/laporan/upload', 'Home::dokumen');

// Untuk Petugas (diatur di controller Petugas)
$routes->get('/petugas/laporan', 'Petugas::laporan');
$routes->get('/petugas/acc/(:num)', 'Petugas::acc/$1');
$routes->get('/petugas/tolak/(:num)', 'Petugas::tolak/$1');
$routes->get('/petugas/download/(:num)', 'Petugas::download/$1');
$routes->get('user/v_laporan', 'Home::simpan');
 $routes->post('Laporan/insertLaporan', 'Laporan::insertLaporan');
$routes->get('petugas/laporan', 'Laporan::index', ['filter' => 'role:petugas']);
