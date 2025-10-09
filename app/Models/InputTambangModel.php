<?php

namespace App\Models;

use CodeIgniter\Model;

class InputTambangModel extends Model
{
    protected $table = 'inputdatatambang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_blok',
        'luas_ha',
        'sd_tereka_volume',
        'sd_tereka_tonase',
        'sd_terunjuk_volume',
        'sd_terunjuk_tonase',
        'sd_terukur_volume',
        'sd_terukur_tonase',
        'cd_terkira_volume',
        'cd_terkira_tonase',
        'cd_terbukti_volume',
        'cd_terbukti_tonase',
        'prod_harian',
        'prod_bulanan',
        'prod_tahunan',
        'umur_tambang'
    ];
}
