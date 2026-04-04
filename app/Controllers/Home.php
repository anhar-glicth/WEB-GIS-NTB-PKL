<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\PerusahaanModel;
use App\Models\ModelKoordinat;

class Home extends BaseController
{
    /**
     * Halaman Depan (Landing Page) - Dinamis
     */
    public function index()
    {
        $laporanModel = new LaporanModel();
        $perusahaanModel = new PerusahaanModel();
        $koordinatModel = new ModelKoordinat();

        $data = [
            'totalLaporan' => $laporanModel->countAllResults(),
            'totalPerusahaan' => $perusahaanModel->countAllResults(),
            'totalTitik' => $koordinatModel->countAllResults(),
        ];

        $db = \Config\Database::connect();
        $settingsBuilder = $db->table('web_settings');
        $settings = $settingsBuilder->get()->getResultArray();
        
        $data['site_name'] = 'WEB-GIS NTB PKL';
        $data['hero_image'] = 'https://images.unsplash.com/photo-1578321272176-b7bbc0679853?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80';

        foreach ($settings as $s) {
            if ($s['setting_key'] == 'site_name') $data['site_name'] = $s['setting_value'];
            if ($s['setting_key'] == 'hero_image') $data['hero_image'] = $s['setting_value'];
        }

        return view('landing_page', $data);
    }

    /**
     * View Maps (Halaman Peta Publik)
     */
    public function viewMaps()
    {
        $model = new ModelKoordinat();
        $data = [
            'title' => 'Visualisasi Peta Wilayah',
            'koordinat' => $model->findAll()
        ];
        return view('user/v_viewmaps', $data);
    }

    /**
     * Marker (List Data Marker)
     */
    public function marker()
    {
        $model = new ModelKoordinat();
        $data = [
            'title' => 'Daftar Marker Wilayah',
            'koordinat' => $model->findAll()
        ];
        return view('user/v_marker', $data);
    }

    /**
     * Base Maps
     */
    public function baseMaps()
    {
        return view('user/v_basemaps', ['title' => 'Base Maps Selection']);
    }

    /**
     * Simpan Poligon Data SIG (Relational Update)
     */
    public function simpanPoligon()
    {
        $model = new ModelKoordinat();
        
        $latDeg = $this->request->getPost('lat_deg');
        $latMin = $this->request->getPost('lat_min');
        $latSec = $this->request->getPost('lat_sec');
        $latDir = $this->request->getPost('lat_dir');
        
        $lngDeg = $this->request->getPost('long_deg');
        $lngMin = $this->request->getPost('long_min');
        $lngSec = $this->request->getPost('long_sec');
        $lngDir = $this->request->getPost('long_dir');

        // Handle Foto Upload
        $fileFoto = $this->request->getFile('foto_lokasi');
        $namaFoto = null;
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/lokasi/', $namaFoto);
        }

        // Simpan setiap titik koordinat (relasi ke User yang login)
        if (is_array($latDeg)) {
            foreach ($latDeg as $key => $value) {
                $model->insert([
                    'user_id'        => user_id(), // Mencatat siapa yang menggambar
                    'companyName'    => $this->request->getPost('companyName'),
                    'locationName'   => $this->request->getPost('locationName'),
                    'permit'         => $this->request->getPost('permit'),
                    'latitude_deg'   => $latDeg[$key],
                    'latitude_min'   => $latMin[$key],
                    'latitude_sec'   => $latSec[$key],
                    'latitude_dir'   => $latDir[$key],
                    'longitude_deg'  => $lngDeg[$key],
                    'longitude_min'  => $lngMin[$key],
                    'longitude_sec'  => $lngSec[$key],
                    'longitude_dir'  => $lngDir[$key],
                    'foto_lokasi'    => $namaFoto
                ]);
            }
        }

        return redirect()->to(base_url('Home/viewMaps'))->with('message', 'Data Koordinat Berhasil Disimpan!');
    }

    /**
     * Poligon view wrapper
     */
    public function poligon()
    {
        return view('user/v_poligon', ['title' => 'Input Poligon Baru']);
    }
}