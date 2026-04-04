<?php
// TEMPORARY - Hapus setelah debug selesai!
// Akses via: http://localhost:8080/debug_login.php

// Bootstrap CI4
$minDir = __DIR__ . '/../';
chdir($minDir);

// Use CI4's boot process
require_once $minDir . 'vendor/autoload.php';

$paths = new Config\Paths();
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
$app = require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';
$app->initialize();

// Load auth helper
helper('auth');

echo "<style>body{font-family:'Segoe UI',sans-serif;padding:30px;background:#f4f4f4;} .card{background:white;border-radius:15px;padding:30px;max-width:700px;margin:auto;box-shadow:0 5px 30px rgba(0,0,0,.1);} .ok{color:green;font-weight:bold;} .fail{color:red;font-weight:bold;} table{width:100%;border-collapse:collapse;margin:15px 0;} th{background:#4e73df;color:white;padding:10px;text-align:left;} td{padding:10px;border-bottom:1px solid #eee;} h2{color:#4e73df;}</style>";
echo "<div class='card'>";
echo "<h2>🔍 App-Level Auth Debug</h2>";

// 1. Check logged_in
$isLoggedIn = logged_in();
echo "<table>";
echo "<tr><th>Test</th><th>Hasil</th></tr>";
echo "<tr><td>logged_in()</td><td>" . ($isLoggedIn ? "<span class='ok'>✅ TRUE</span>" : "<span class='fail'>❌ FALSE</span>") . "</td></tr>";

// 2. Check user()
$u = user();
echo "<tr><td>user()</td><td>" . ($u ? "<span class='ok'>✅ User ditemukan: ID={$u->id}, username={$u->username}, email={$u->email}</span>" : "<span class='fail'>❌ NULL (tidak login)</span>") . "</td></tr>";

// 3. Check user_id()
$uid = user_id();
echo "<tr><td>user_id()</td><td>" . ($uid ? "<span class='ok'>✅ ID = $uid</span>" : "<span class='fail'>❌ NULL</span>") . "</td></tr>";

// 4. Check in_groups
$groups = ['admin', 'petugas', 'user'];
foreach ($groups as $g) {
    $inG = in_groups($g);
    echo "<tr><td>in_groups('$g')</td><td>" . ($inG ? "<span class='ok'>✅ TRUE</span>" : "<span class='fail'>❌ FALSE</span>") . "</td></tr>";
}

// 5. Check services
$auth = service('authentication');
echo "<tr><td>Auth Service Class</td><td>" . get_class($auth) . "</td></tr>";
echo "<tr><td>Auth check()</td><td>" . ($auth->check() ? "<span class='ok'>✅ TRUE</span>" : "<span class='fail'>❌ FALSE</span>") . "</td></tr>";
echo "<tr><td>Auth id()</td><td>" . ($auth->id() ?? 'NULL') . "</td></tr>";

// 6. Check session
$session = session();
echo "<tr><td>Session ID</td><td>" . $session->session_id . "</td></tr>";
echo "<tr><td>Session logged_in</td><td>" . ($session->get('logged_in') ?? 'NOT SET') . "</td></tr>";

echo "</table>";

// 7. Direct DB check for the logged in user's groups
if ($uid) {
    $db = \Config\Database::connect();
    $builder = $db->table('auth_groups_users');
    $result = $builder->where('user_id', $uid)->get()->getResultArray();
    echo "<h3>Group assignments untuk user_id=$uid:</h3>";
    if (empty($result)) {
        echo "<p class='fail'>❌ TIDAK ADA GROUP ASSIGNMENT! Ini penyebab sidebar kosong.</p>";
    } else {
        echo "<table><tr><th>group_id</th><th>user_id</th></tr>";
        foreach ($result as $r) {
            echo "<tr><td>{$r['group_id']}</td><td>{$r['user_id']}</td></tr>";
        }
        echo "</table>";
    }
}

echo "<br><a href='http://localhost:8080/' style='color:#4e73df;font-weight:bold;'>← Kembali</a>";
echo "</div>";
