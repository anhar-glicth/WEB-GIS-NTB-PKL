<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan'; // ✅ nama tabel di database
    protected $primaryKey = 'id'; // default 'id'

    protected $allowedFields = ['judul', 'file', 'user_id', 'status'];
    protected $useTimestamps = true; // jika pakai created_at & updated_at

    // Opsional, jika masih mau pakai custom insert
    public function insertLaporan($laporan)
    {
        return $this->insert($laporan); // lebih clean & pakai fitur CI4
    }
}
