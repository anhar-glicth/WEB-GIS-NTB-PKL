<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKoordinat extends Model
{
    protected $table            = 'koordinat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Pastikan ini FALSE karena di tabel Anda tidak ada kolom created_at/updated_at
    protected $useTimestamps    = false; 
    
    protected $allowedFields    = [
        'latitude_deg', 
        'latitude_min', 
        'latitude_sec', 
        'latitude_dir',
        'longitude_deg', 
        'longitude_min', 
        'longitude_sec', 
        'longitude_dir',
        'foto_lokasi',
        'dokumen_pendukung',
        'locationName',
        'companyName',
        'permit'
    ];
}