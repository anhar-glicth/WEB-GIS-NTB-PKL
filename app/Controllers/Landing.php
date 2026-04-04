<?php

namespace App\Controllers;

use App\Models\PerusahaanModel;
use App\Models\LaporanModel;
use App\Models\ModelKoordinat;

class Landing extends BaseController
{
    public function index()
    {
        // Helper Auth
        helper('auth');

        // 1. Redirect jika sudah login (Admin/Petugas/User)
        if (logged_in()) {
            if (in_groups('admin')) {
                return redirect()->to('/admin');
            } elseif (in_groups('petugas')) {
                return redirect()->to('/petugas');
            } else {
                return redirect()->to('/user');
            }
        }

        // 2. Inisialisasi Model
        $perusahaanModel = new PerusahaanModel();
        $laporanModel    = new LaporanModel();
        $koordinatModel  = new ModelKoordinat();

        // 3. HITUNG DATA (Bagian ini yang sebelumnya mungkin kurang)
        $stats = [
            'total_perusahaan' => $perusahaanModel->countAllResults(), // Menghitung baris tabel perusahaan
            'total_laporan'    => $laporanModel->countAllResults(),    // Menghitung baris tabel laporan
            'total_poligon'    => $koordinatModel->countAllResults(),  // Menghitung baris tabel koordinat
        ];

        $koordinatRaw = $koordinatModel->whereIn('status', ['ACC', 'Disetujui'])->findAll();
        $koordinatFix = [];

        foreach ($koordinatRaw as $k) {
            // KONVERSI DMS KE DESIMAL (DD = DEG + MIN/60 + SEC/3600)
            $lat = (float)$k['latitude_deg'] + ((float)$k['latitude_min'] / 60) + ((float)$k['latitude_sec'] / 3600);
            $lng = (float)$k['longitude_deg'] + ((float)$k['longitude_min'] / 60) + ((float)$k['longitude_sec'] / 3600);
            
            // Handle Arah (S/W = Negatif)
            if (strtoupper($k['latitude_dir'] ?? '') == 'S') $lat *= -1;
            if (strtoupper($k['longitude_dir'] ?? '') == 'W') $lng *= -1;

            $k['latitude_decimal'] = $lat;
            $k['longitude_decimal'] = $lng;
            $koordinatFix[] = $k;
        }

        $config = config('Auth');

        $data = [
            'judul'           => 'SIG-TAMBANG NTB',
            'site_name'       => 'SIG-TAMBANG NTB',
            'hero_image'      => base_url('img/image.png'),
            'totalLaporan'    => $stats['total_laporan'],
            'totalPerusahaan' => $stats['total_perusahaan'],
            'totalTitik'      => $stats['total_poligon'],
            'config'          => $config, 
            'stats'           => $stats,
            // KIRIM DATA YANG SUDAH DIKONVERSI
            'koordinat'       => $koordinatFix,
        ];

        return view('landing_page', $data);
    }
}