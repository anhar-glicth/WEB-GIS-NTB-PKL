<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\PerusahaanModel;
use App\Models\ModelKoordinat;

class Home extends BaseController
{
    /**
     * Halaman Utama / Landing Page
     */
    public function index()
    {
        $laporanModel = new LaporanModel();
        $perusahaanModel = new PerusahaanModel();
        $koordinatModel = new ModelKoordinat();

        // Menyusun data statistik untuk landing page
        $data = [
            'judul' => 'Beranda',
            'stats' => [
                'total_laporan'     => $laporanModel->countAllResults(),
                'total_perusahaan'  => $perusahaanModel->countAllResults(),
                'total_poligon'     => $koordinatModel->countAllResults(),
            ]
        ];
        
        return view('landing_page', $data);
    }

    /**
     * Pemetaan Seluruh Data (View Maps)
     */
    public function viewMaps()
    {
        $model = new ModelKoordinat();
        $data = [
            'judul' => 'Pemetaan Kawasan Pertambangan',
            'koordinat' => $model->findAll() 
        ];

        return view('user/v_viewmaps', $data);
    }

    /**
     * Pemetaan berbasis Marker
     */
    public function marker()
    {
        $model = new ModelKoordinat();
        $data = [
            'judul' => 'Pemetaan Kawasan Pertambangan (Marker)',
            'koordinat' => $model->findAll()
        ];

        return view('user/v_marker', $data);
    }

    /**
     * Halaman Input Poligon
     */
    public function poligon()
    {
        $data = [
            'judul' => 'Input Kawasan Pertambangan (Poligon)'
        ];

        return view('user/v_poligon', $data);
    }

    /**
     * Simpan Data Poligon & Metadata
     */
    public function simpanPoligon()
    {
        $model = new ModelKoordinat();

        $lat_deg = $this->request->getPost('lat_deg');
        $lat_min = $this->request->getPost('lat_min');
        $lat_sec = $this->request->getPost('lat_sec');
        $lat_dir = $this->request->getPost('lat_dir');

        $long_deg = $this->request->getPost('long_deg');
        $long_min = $this->request->getPost('long_min');
        $long_sec = $this->request->getPost('long_sec');
        $long_dir = $this->request->getPost('long_dir');

        $companyName = $this->request->getPost('companyName');
        $locationName = $this->request->getPost('locationName');
        $permit = $this->request->getPost('permit');

        // Handle Upload Foto
        $fileFoto = $this->request->getFile('foto_lokasi');
        $namaFoto = "";
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/lokasi', $namaFoto);
        }

        // Handle Upload Dokumen
        $fileDok = $this->request->getFile('dokumen_pendukung');
        $namaDok = "";
        if ($fileDok && $fileDok->isValid() && !$fileDok->hasMoved()) {
            $namaDok = $fileDok->getRandomName();
            $fileDok->move('uploads/dokumen', $namaDok);
        }

        // Simpan setiap titik koordinat
        if (is_array($lat_deg)) {
            foreach ($lat_deg as $key => $val) {
                if(!empty($lat_deg[$key])) {
                    $model->insert([
                        'latitude_deg'  => $lat_deg[$key],
                        'latitude_min'  => $lat_min[$key],
                        'latitude_sec'  => $lat_sec[$key],
                        'latitude_dir'  => $lat_dir[$key],
                        'longitude_deg' => $long_deg[$key],
                        'longitude_min' => $long_min[$key],
                        'longitude_sec' => $long_sec[$key],
                        'longitude_dir' => $long_dir[$key],
                        'companyName'   => $companyName,
                        'locationName'  => $locationName,
                        'permit'        => $permit,
                        'foto_lokasi'   => $namaFoto,
                        'dokumen_pendukung' => $namaDok
                    ]);
                }
            }
        }

        return redirect()->to(base_url('Home/viewMaps'))->with('success', 'Data Poligon berhasil disimpan.');
    }

    /**
     * Pilihan Basemaps
     */
    public function baseMaps()
    {
        $data = [
            'judul' => 'Pilihan Basemaps (SIG)'
        ];

        return view('user/v_basemaps', $data);
    }
}