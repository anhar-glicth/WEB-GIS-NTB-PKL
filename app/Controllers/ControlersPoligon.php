<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKoordinat;

class ControlersPoligon extends BaseController
{
    public function index()
    {
        $model = new ModelKoordinat();
        $data = [
            "judul" => "Input Data Poligon",
            "page"  => "v_poligon", 
            "koordinat" => $model->findAll() // AMBIL DATA LAMA SEBAGAI REFERENSI
        ];
        // Pastikan view ini sesuai dengan nama file Anda (v_poligon.php atau poligon_view.php)
        return view('user/poligon_view', $data);
    }

    public function history()
    {
        $model = new ModelKoordinat();
        $data = [
            "judul" => "Riwayat Data Poligon",
            "koordinat" => $model->where('user_id', user_id())->findAll() // HANYA PUNYA SAYA
        ];
        return view('user/poligon_history', $data);
    }

    public function simpan()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(base_url('poligon'))->with('error', 'Akses tidak valid.');
        }

        $userId = user_id(); // AMBIL ID SAYA
        $model = new ModelKoordinat();
        
        // --- 1. Ambil Data Header ---
        $companyName = $this->request->getPost('companyName');
        $locationName = $this->request->getPost('locationName');
        $permit = $this->request->getPost('permit');
        
        // --- 2. Handle File Uploads ---
        $namaFoto = null;
        $foto = $this->request->getFile('foto_lokasi');
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/lokasi', $namaFoto); 
        }

        $namaDokumen = null;
        $dokumen = $this->request->getFile('dokumen_pendukung');
        if ($dokumen && $dokumen->isValid() && ! $dokumen->hasMoved()) {
            $namaDokumen = $dokumen->getRandomName();
            $dokumen->move('uploads/dokumen', $namaDokumen);
        }

        // --- 3. Ambil Data Array Koordinat ---
        $lat_deg = $this->request->getPost('lat_deg');
        $lat_min = $this->request->getPost('lat_min');
        $lat_sec = $this->request->getPost('lat_sec');
        $lat_dir = $this->request->getPost('lat_dir');
        
        $long_deg = $this->request->getPost('long_deg');
        $long_min = $this->request->getPost('long_min');
        $long_sec = $this->request->getPost('long_sec');
        $long_dir = $this->request->getPost('long_dir');

        $berhasil = false;

        // --- 4. Proses Insert ---
        if (is_array($lat_deg)) {
            foreach ($lat_deg as $key => $val) {
                if(isset($lat_deg[$key]) && $lat_deg[$key] !== '') {
                    
                    $dataSimpan = [
                        'user_id'           => $userId, // SIMPAN SIAPA PEMILIKNYA
                        'companyName'       => $companyName,
                        'locationName'      => $locationName,
                        'permit'            => $permit,
                        'foto_lokasi'       => $namaFoto,
                        'dokumen_pendukung' => $namaDokumen,
                        
                        'latitude_deg'      => $lat_deg[$key],
                        'latitude_min'      => $lat_min[$key],
                        'latitude_sec'      => $lat_sec[$key],
                        'latitude_dir'      => $lat_dir[$key],
                        
                        'longitude_deg'     => $long_deg[$key],
                        'longitude_min'     => $long_min[$key],
                        'longitude_sec'     => $long_sec[$key],
                        'longitude_dir'     => $long_dir[$key],
                    ];

                    if (!$model->insert($dataSimpan)) {
                        return redirect()->to(base_url('poligon'))->with('error', 'Gagal menyimpan ke database.');
                    }
                    $berhasil = true;
                }
            }
        }

        if ($berhasil) {
            return redirect()->to(base_url('poligon/riwayat'))->with('success', 'Data Berhasil Disimpan!');
        } else {
            return redirect()->to(base_url('poligon'))->with('error', 'Gagal menyimpan. Pastikan input terisi.');
        }
    }

    public function hapusByPermit($permit)
    {
        $model = new ModelKoordinat();
        
        // HANYA hapus JIKA permit tersebut adalah MILIK SAYA (user_id sama)
        $model->where('permit', $permit)
              ->where('user_id', user_id()) // SECURITY CHECK!
              ->delete();
              
        return redirect()->back()->with('success', 'Seluruh area poligon berhasil dihapus!');
    }
}