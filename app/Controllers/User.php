<?php

namespace App\Controllers;

use App\Models\LaporanModel;

class User extends BaseController
{
  

public function index()
{
    $laporanModel = new LaporanModel();
    $userId = user_id(); // dari Myth/Auth

    $data = [
        'judul' => 'Dashboard User',
        'totalLaporan' => $laporanModel->where('user_id', $userId)->countAllResults(),
        'approvedLaporan' => $laporanModel->where(['user_id' => $userId, 'status' => 'approved'])->countAllResults(),
        'rejectedLaporan' => $laporanModel->where(['user_id' => $userId, 'status' => 'rejected'])->countAllResults(),
    ];

    return view('user/index', $data);
}


    // Tambahkan method lain sesuai kebutuhan: insertUser, editUser, dll
}
