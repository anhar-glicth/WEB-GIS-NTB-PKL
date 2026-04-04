<?php
// TEMPORARY SCRIPT - Hapus file ini setelah berhasil!
// Akses via: http://localhost:8080/seed_accounts.php

define('FCPATH', __DIR__ . '/');
require_once FCPATH . '../vendor/autoload.php';

// Pastikan CI sudah di-load
$pathsConfig = FCPATH . '../app/Config/Paths.php';
require_once $pathsConfig;
$paths = new Config\Paths();

// Connect langsung ke MySQL
$host   = 'localhost';
$db     = 'gis';
$user   = 'root';
$pass   = '';
$port   = 3306;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('<h2 style="color:red">Gagal konek DB: ' . $e->getMessage() . '</h2>');
}

// Generate hashes baru
$accounts = [
    ['id' => 100, 'email' => 'admin@admin.com',     'username' => 'Admin GIS',   'password' => 'admin123',   'group_id' => 1],
    ['id' => 101, 'email' => 'petugas@petugas.com', 'username' => 'Petugas GIS', 'password' => 'petugas123', 'group_id' => 3],
    ['id' => 102, 'email' => 'user@user.com',        'username' => 'User GIS',    'password' => 'user123',    'group_id' => 2],
];

$results = [];

foreach ($accounts as $acc) {
    $hash = password_hash($acc['password'], PASSWORD_BCRYPT);

    // Delete jika sudah ada
    $pdo->exec("DELETE FROM auth_groups_users WHERE user_id = {$acc['id']}");
    $pdo->exec("DELETE FROM users WHERE email = '{$acc['email']}'");

    // Insert user baru
    $stmt = $pdo->prepare("
        INSERT INTO users (id, email, username, user_image, password_hash, active, created_at, updated_at)
        VALUES (?, ?, ?, '', ?, 1, NOW(), NOW())
    ");
    $stmt->execute([$acc['id'], $acc['email'], $acc['username'], $hash]);

    // Assign role
    $pdo->exec("INSERT IGNORE INTO auth_groups_users (group_id, user_id) VALUES ({$acc['group_id']}, {$acc['id']})");

    $results[] = [
        'email'    => $acc['email'],
        'username' => $acc['username'],
        'password' => $acc['password'],
        'group_id' => $acc['group_id'],
        'hash'     => $hash,
        'status'   => '✅ Berhasil'
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seed Akun Demo - SIG-TAMBANG NTB</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #4e73df, #224abe); min-height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; padding: 20px; }
        .card { background: white; border-radius: 20px; padding: 40px; max-width: 700px; width: 100%; box-shadow: 0 20px 50px rgba(0,0,0,0.2); }
        h1 { color: #4e73df; font-weight: 700; margin-bottom: 5px; }
        p.sub { color: #858796; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th { background: #4e73df; color: white; padding: 12px 15px; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #e3e6f0; }
        tr:last-child td { border-bottom: none; }
        .badge { background: #1cc88a; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .role-admin  { background: #e8410a; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .role-petugas{ background: #f6c23e; color: #222; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .role-user   { background: #4e73df; color: white; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; }
        .warning { background: #fff3cd; border: 1px solid #ffc107; border-radius: 10px; padding: 15px 20px; margin-top: 25px; font-size: 0.85rem; color: #856404; }
        .btn { display: inline-block; margin-top: 25px; padding: 12px 30px; background: #4e73df; color: white; border-radius: 50px; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
<div class="card">
    <h1>✅ Akun Demo Berhasil Dibuat!</h1>
    <p class="sub">Semua akun di bawah siap digunakan untuk login ke sistem SIG-TAMBANG NTB.</p>

    <table>
        <thead>
            <tr>
                <th>Role</th>
                <th>Email</th>
                <th>Password</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $r): ?>
            <tr>
                <td>
                    <?php if ($r['group_id'] == 1): ?>
                        <span class="role-admin">👑 Admin</span>
                    <?php elseif ($r['group_id'] == 3): ?>
                        <span class="role-petugas">👮 Petugas</span>
                    <?php else: ?>
                        <span class="role-user">🏢 User</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><code><?= htmlspecialchars($r['password']) ?></code></td>
                <td><span class="badge"><?= $r['status'] ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="warning">
        ⚠️ <strong>PENTING:</strong> Hapus file <code>seed_accounts.php</code> dari folder <code>public/</code> setelah selesai menggunakan halaman ini untuk menjaga keamanan aplikasi!
    </div>

    <a href="http://localhost:8080/" class="btn">← Kembali ke Halaman Utama</a>
</div>
</body>
</html>
