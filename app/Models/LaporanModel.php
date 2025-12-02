<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';

    // PERBAIKAN: Menambahkan kolom data tambang agar BISA DISIMPAN
    protected $allowedFields = [
        // Data Utama
        'judul',
        'file',
        'user_id',
        'status',
        
        // Data Detail Tambang (Wajib ditambahkan disini)
        'nama_blok',
        'luas_ha',
        
        // Sumberdaya
        'sd_tereka_volume',
        'sd_tereka_tonase',
        'sd_terunjuk_volume',
        'sd_terunjuk_tonase',
        'sd_terukur_volume',
        'sd_terukur_tonase',
        
        // Cadangan
        'cd_terkira_volume',
        'cd_terkira_tonase',
        'cd_terbukti_volume',
        'cd_terbukti_tonase',
        
        // Produksi
        'prod_harian',
        'prod_bulanan',
        'prod_tahunan',
        'umur_tambang',

        // Timestamps
        'created_at',
        'updated_at',
        'verified_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getLaporanTerbaru($limit = 5)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->orderBy('laporan.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    public function insertLaporan($laporan)
    {
        return $this->insert($laporan);
    }

    public function getLaporanByStatus($status)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->where('status', $status)
                    ->orderBy('laporan.created_at', 'DESC')
                    ->findAll();
    }

    public function getDetailLaporan($id)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->where('laporan.id', $id)
                    ->first();
    }
}