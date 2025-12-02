<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKoordinat;

class ControlersPoligon extends BaseController
{
    public function index()
    {
        $data = [
            "judul" => "Input Data Poligon",
            "page"  => "v_poligon", 
        ];
        // Pastikan view ini sesuai dengan nama file Anda (v_poligon.php atau poligon_view.php)
        return view('user/poligon_view', $data);
    }

    public function simpan()
    {
        if (!$this->request->is('post')) {
            return redirect()->to(base_url('poligon'))->with('error', 'Akses tidak valid.');
        }

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
                // Cek data tidak kosong
                if(isset($lat_deg[$key]) && $lat_deg[$key] !== '') {
                    
                    $dataSimpan = [
                        'companyName'       => $companyName,
                        'locationName'      => $locationName,
                        'permit'            => $permit, // Biarkan string, database akan handle conversion
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

                    // INSERT & CEK ERROR DB LANGSUNG
                    if (!$model->insert($dataSimpan)) {
                        // Ambil error langsung dari driver database
                        $dbError = $model->db->error(); 
                        
                        // TAMPILKAN ERROR KE LAYAR
                        dd([
                            'STATUS' => 'GAGAL MENYIMPAN KE DATABASE',
                            'Pesan Error Database' => $dbError['message'],
                            'Kode Error' => $dbError['code'],
                            'Query Terakhir' => $model->getLastQuery() ? $model->getLastQuery()->getQuery() : 'N/A',
                            'Data yang dikirim' => $dataSimpan,
                            'Error Validasi Model' => $model->errors()
                        ]);
                    }
                    
                    $berhasil = true;
                }
            }
        }

        if ($berhasil) {
            return redirect()->to(base_url('poligon'))->with('success', 'Data Berhasil Disimpan!');
        } else {
            return redirect()->to(base_url('poligon'))->with('error', 'Gagal menyimpan. Pastikan input terisi.');
        }
    }
}