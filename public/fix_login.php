<?php
// FINAL FIX SCRIPT - Akses via: http://localhost:8080/fix_login.php
// Hapus setelah selesai!

$host = 'localhost';
$db   = 'gis';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('DB Error: ' . $e->getMessage());
}

$results = [];

// 1. Bersihkan throttle/login attempts yang gagal
try {
    $pdo->exec("DELETE FROM auth_logins WHERE success = 0");
    $results[] = ['step' => 'Bersihkan login gagal', 'status' => '✅ OK'];
} catch (Exception $e) {
    $results[] = ['step' => 'Bersihkan login gagal', 'status' => '⚠️ ' . $e->getMessage()];
}

// 2. Bersihkan token lama
try {
    $pdo->exec("DELETE FROM auth_tokens");
    $results[] = ['step' => 'Bersihkan token lama', 'status' => '✅ OK'];
} catch (Exception $e) {
    $results[] = ['step' => 'Bersihkan token lama', 'status' => '⚠️ ' . $e->getMessage()];
}

// 3. Hapus akun demo lama dan buat ulang dengan data bersih
$accounts = [
    ['id' => 100, 'email' => 'admin@admin.com',     'username' => 'admin_gis',   'password' => 'admin123',   'group_id' => 1],
    ['id' => 101, 'email' => 'petugas@petugas.com', 'username' => 'petugas_gis', 'password' => 'petugas123', 'group_id' => 3],
    ['id' => 102, 'email' => 'user@user.com',       'username' => 'user_gis',    'password' => 'user123',    'group_id' => 2],
];

foreach ($accounts as $acc) {
    $hash = password_hash($acc['password'], PASSWORD_BCRYPT, ['cost' => 10]);
    
    // Hapus assignment group lama
    $pdo->exec("DELETE FROM auth_groups_users WHERE user_id = {$acc['id']}");
    // Hapus user lama
    $pdo->exec("DELETE FROM users WHERE id = {$acc['id']}");
    $pdo->exec("DELETE FROM users WHERE email = '{$acc['email']}'");
    
    // Insert ulang dengan SEMUA kolom terisi
    $stmt = $pdo->prepare("
        INSERT INTO users (id, email, username, user_image, password_hash, active, force_pass_reset, created_at, updated_at)
        VALUES (?, ?, ?, 'default.jpg', ?, 1, 0, NOW(), NOW())
    ");
    $stmt->execute([$acc['id'], $acc['email'], $acc['username'], $hash]);
    
    // Assign role
    $stmt = $pdo->prepare("INSERT INTO auth_groups_users (group_id, user_id) VALUES (?, ?)");
    $stmt->execute([$acc['group_id'], $acc['id']]);
    
    // Verify hash
    $verify = password_verify($acc['password'], $hash) ? '✅' : '❌';
    $results[] = ['step' => "Akun {$acc['email']} ({$acc['username']})", 'status' => "{$verify} Dibuat - Group {$acc['group_id']}"];
}

// 4. Hapus duplikat di auth_groups_users
try {
    $pdo->exec("
        DELETE t1 FROM auth_groups_users t1
        INNER JOIN auth_groups_users t2
        WHERE t1.group_id = t2.group_id 
          AND t1.user_id = t2.user_id
          AND t1.group_id > t2.group_id
    ");
    // Alternative: just recreate clean
    $pdo->exec("CREATE TEMPORARY TABLE tmp_gu AS SELECT DISTINCT group_id, user_id FROM auth_groups_users");
    $pdo->exec("DELETE FROM auth_groups_users");
    $pdo->exec("INSERT INTO auth_groups_users (group_id, user_id) SELECT group_id, user_id FROM tmp_gu");
    $pdo->exec("DROP TEMPORARY TABLE tmp_gu");
    $results[] = ['step' => 'Hapus duplikat group assignment', 'status' => '✅ OK'];
} catch (Exception $e) {
    $results[] = ['step' => 'Hapus duplikat group assignment', 'status' => '⚠️ ' . $e->getMessage()];
}

// 5. PERBAIKAN KHUSUS USER ID 103 (HAYYYA / LOGIN)
try {
    // Pastikan user 103 masuk ke grup 'user' (ID 2)
    $stmt = $pdo->prepare("INSERT IGNORE INTO auth_groups_users (group_id, user_id) VALUES (2, 103)");
    $stmt->execute();
    
    // Masukkan semua user lain yang belum punya grup ke grup 'user'
    $pdo->exec("
        INSERT IGNORE INTO auth_groups_users (group_id, user_id)
        SELECT 2, id FROM users 
        WHERE id NOT IN (SELECT user_id FROM auth_groups_users)
    ");
    
    $results[] = ['step' => 'Perbaikan Massal User Group', 'status' => '✅ OK (User 103 & lainnya dimasukkan ke Grup User)'];
} catch (Exception $e) {
    $results[] = ['step' => 'Perbaikan Massal User Group', 'status' => '⚠️ ' . $e->getMessage()];
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Fix Login</title>
<style>body{font-family:'Segoe UI',sans-serif;background:#4e73df;display:flex;justify-content:center;align-items:center;min-height:100vh;margin:0;padding:20px;} .card{background:white;border-radius:20px;padding:40px;max-width:600px;width:100%;box-shadow:0 20px 50px rgba(0,0,0,.2);} h1{color:#4e73df;} table{width:100%;border-collapse:collapse;margin:20px 0;} th{background:#4e73df;color:white;padding:10px 15px;text-align:left;} td{padding:10px 15px;border-bottom:1px solid #eee;} .info{background:#e8f5e9;border-radius:10px;padding:15px;margin:20px 0;} .warn{background:#fff3cd;border-radius:10px;padding:15px;margin:20px 0;font-size:.85rem;} .btn{display:inline-block;margin-top:15px;padding:12px 30px;background:#4e73df;color:white;border-radius:50px;text-decoration:none;font-weight:600;}</style>
</head><body>
<div class="card">
    <h1>🔧 Fix Login Selesai!</h1>
    <table>
        <tr><th>Langkah</th><th>Status</th></tr>
        <?php foreach ($results as $r): ?>
        <tr><td><?= $r['step'] ?></td><td><?= $r['status'] ?></td></tr>
        <?php endforeach; ?>
    </table>
    
    <div class="info">
        <strong>🔑 Akun Login:</strong><br>
        <code>admin@admin.com</code> / <code>admin123</code> (Admin)<br>
        <code>petugas@petugas.com</code> / <code>petugas123</code> (Petugas)<br>
        <code>user@user.com</code> / <code>user123</code> (User)
    </div>
    
    <div class="warn">⚠️ Hapus file <code>fix_login.php</code>, <code>seed_accounts.php</code>, dan <code>debug_login.php</code> dari folder public setelah selesai!</div>
    
    <a href="http://localhost:8080/" class="btn">← Coba Login Sekarang</a>
</div>
</body></html>
