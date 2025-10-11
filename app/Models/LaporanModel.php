<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';          // Nama tabel di database
    protected $primaryKey = 'id';          // Primary key

    // Kolom yang boleh diisi (sesuaikan dengan tabel kamu)
    protected $allowedFields = [
        'judul',
        'file',
        'user_id',
        'status',
        'created_at',
        'updated_at',
        'verified_at'
    ];

    // Mengaktifkan fitur timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil laporan terbaru untuk dashboard petugas
     * @param int $limit jumlah laporan yang diambil (default 5)
     */
    public function getLaporanTerbaru($limit = 5)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->orderBy('laporan.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Hitung jumlah laporan berdasarkan status
     */
    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    /**
     * Insert laporan baru (lebih clean)
     */
    public function insertLaporan($laporan)
    {
        return $this->insert($laporan);
    }

    /**
     * Ambil laporan berdasarkan status tertentu
     */
    public function getLaporanByStatus($status)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->where('status', $status)
                    ->orderBy('laporan.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil detail laporan lengkap (dengan data user)
     */
    public function getDetailLaporan($id)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->where('laporan.id', $id)
                    ->first();
    }
}
