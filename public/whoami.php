<?php
// Perbaiki Jalur: Mundur Satu Langkah (../)
require __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';
$auth = service('authentication');

echo "<div style='font-family: Arial; padding: 20px; border: 1px solid #ccc; max-width:600px; margin: 30px auto;'>";
echo "<h1>📋 DIAGNOSA LOGIN</h1>";

if (!$auth->check()) {
    echo "<p style='color:red;'>⚠️ STATUS: ANDA BELUM LOGIN.</p>";
    echo "<a href='/login' style='background:blue; color:white; padding:5px 10px; text-decoration:none;'>Log In Kembali</a>";
} else {
    $user = $auth->user();
    $db = \Config\Database::connect();
    
    // Ambil Role
    $groups = $db->table('auth_groups_users')
                 ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
                 ->where('user_id', $user->id)
                 ->get()->getResultArray();
    
    $roleNames = array_column($groups, 'name');

    echo "<h3>Detail Akun Aktif:</h3>";
    echo "<ul>";
    echo "<li><b>USER ID:</b> {$user->id}</li>";
    echo "<li><b>EMAIL:</b> {$user->email}</li>";
    echo "<li><b>ROLE SAAT INI:</b> " . (count($roleNames) > 0 ? implode(', ', $roleNames) : 'TIDAK PUNYA PANGKAT') . "</li>";
    echo "</ul>";

    echo "<hr>";
    echo "<p>💡 <b>Catatan:</b> Jika ROLE di atas sudah benar (ada tulisan 'petugas') tapi tetap dilarang akses, berarti sistem masih memakai data sesi lama Anda.</p>";
    
    echo "<form method='post'><button name='clear' type='submit' style='background:#e74c3c; color:white; padding:12px 20px; border:none; cursor:pointer; font-weight:bold; border-radius:5px;'>HAPUS SESI & LOGOUT PAKSA</button></form>";

    if (isset($_POST['clear'])) {
        session()->destroy();
        echo "<script>alert('Sesi Berhasil Dihapus! Silakan Login Kembali.'); window.location.href='/login';</script>";
    }
}
echo "</div>";
