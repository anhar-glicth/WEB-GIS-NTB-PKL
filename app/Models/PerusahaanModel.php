<?php

namespace App\Models;

use CodeIgniter\Model;

class PerusahaanModel extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_perusahaan',
        'alamat_perusahaan',
        'npwp',
        'jenis_usaha',
        'tahun_berdiri',
        'nib',
        'izin_usaha',
        'masa_berlaku',
        'nama_direktur',
        'email_perusahaan',
        'no_telepon',
        'website',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
