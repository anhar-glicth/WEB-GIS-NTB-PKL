<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class AuthFix extends BaseController
{
    /**
     * ALAT SAKTI: LANTIK PETUGAS
     * Panggil URL: localhost:8080/authfix/lantikPetugas
     */
    public function lantikPetugas()
    {
        $db = \Config\Database::connect();
        
        // 1. Temukan ID Petugas
        $user = $db->table('users')->where('email', 'petugas@petugas.com')->get()->getRowArray();
        
        if (!$user) {
            return "ERROR: Akun 'petugas@petugas.com' tidak ditemukan di database. Mohon Register dulu.";
        }

        // 2. Hubungkan ke Group ID 3 (Petugas)
        $db->table('auth_groups_users')->ignore(true)->insert([
            'group_id' => 3,
            'user_id'  => $user['id']
        ]);

        return "SUKSES! User ID {$user['id']} sekarang sudah resmi menjadi PETUGAS. Silakan Refresh halaman Dashboard Anda.";
    }

    /**
     * ALAT SAKTI 2: LANTIK ADMIN (Diri Sendiri)
     * Panggil URL: localhost:8080/authfix/pangkatAdmin
     */
    public function pangkatAdmin()
    {
        if (!logged_in()) {
            return "ERROR: Silakan Login dulu ke akun Anda.";
        }

        $db = \Config\Database::connect();
        $myId = user_id();

        // 1. Masukkan ke Group 1 (Admin)
        $db->table('auth_groups_users')->ignore(true)->insert([
            'group_id' => 1,
            'user_id'  => $myId
        ]);

        return "MANDAT DITERIMA! ID Anda ({$myId}) sekarang sudah punya kekuasaan Admin penuh. Silakan kembali ke Dashboard Admin.";
    }
}
