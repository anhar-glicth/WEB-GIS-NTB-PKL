<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';

    /**
     * Field yang diizinkan untuk disimpan ke database.
     * Mencakup data dokumen, identitas user, status verifikasi, dan data teknis tambang.
     */
    protected $allowedFields = [
        // Informasi Dokumen Dasar
        'judul',
        'file',
        'user_id',
        'status',
        
        // Catatan Verifikasi (Petugas)
        'catatan_penolakan',
        'verified_at',

        // Data Teknis Tambang
        'nama_blok',
        'luas_ha',
        
        // Sumberdaya (Resources)
        'sd_tereka_volume',
        'sd_tereka_tonase',
        'sd_terunjuk_volume',
        'sd_terunjuk_tonase',
        'sd_terukur_volume',
        'sd_terukur_tonase',
        
        // Cadangan (Reserves)
        'cd_terkira_volume',
        'cd_terkira_tonase',
        'cd_terbukti_volume',
        'cd_terbukti_tonase',
        
        // Rencana Produksi & Umur Tambang
        'prod_harian',
        'prod_bulanan',
        'prod_tahunan',
        'umur_tambang',

        // Timestamps
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil 5 laporan terbaru dengan data user (Join).
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
     * Menghitung jumlah laporan berdasarkan status (pending, acc, tolak).
     */
    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    /**
     * Mengambil semua laporan dengan status tertentu (Join User).
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
     * Mengambil detail laporan lengkap berdasarkan ID.
     */
    public function getDetailLaporan($id)
    {
        return $this->select('laporan.*, users.username, users.email')
                    ->join('users', 'users.id = laporan.user_id', 'left')
                    ->where('laporan.id', $id)
                    ->first();
    }
}