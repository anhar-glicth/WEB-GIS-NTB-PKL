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

        // 4. Kirim data ke View
        $config = config('Auth');

        $data = [
            'judul'  => 'Web GIS NTB - Creative Solutions',
            'config' => $config, 
            'stats'  => $stats // <--- Variabel ini wajib dikirim agar View tidak menampilkan 0
        ];

        return view('landing_page', $data);
    }
}