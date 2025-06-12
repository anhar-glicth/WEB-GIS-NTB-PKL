<?php

namespace App\Controllers;
use App\Models\ModelLokasi;

class Lokasi extends BaseController
{
    protected $ModelLokasi;

    public function __construct()
    {
        $this->ModelLokasi = new ModelLokasi();
    }

    public function index(): string
    {
        $data = [
            "judul" => "Data Lokasi",
            "lokasi" => $this->ModelLokasi->getalldata()
        ];

       return view('user/lokasi/v_data_lokasi', $data);

    }
     public function dataLokasi(): string
    {
        $data = [
            "judul" => "Data Lokasi",
            "lokasi" => $this->ModelLokasi->getalldata()
        ];

       return view('user/lokasi/v_data_lokasi',  $data);

    }
    
    public function inputLokasi(): string
    {
        $data = [
            "judul" => "Input Lokasi",
             
        ];
return view('user/lokasi/v_input_lokasi', $data);


    }

    public function insertData()
    {
        helper(['form', 'url']);

        $validationRules = [
            'locationName' => 'required',
            'companyName'  => 'required',
            'latitude_deg' => 'required|integer',
            'latitude_min' => 'required|integer',
            'latitude_sec' => 'required|integer',
            'latitude_dir' => 'required|in_list[N,S]',
            'longitude_deg'=> 'required|integer',
            'longitude_min'=> 'required|integer',
            'longitude_sec'=> 'required|integer',
            'longitude_dir'=> 'required|in_list[E,W]',
            'foto_lokasi'  => 'uploaded[foto_lokasi]|is_image[foto_lokasi]|max_size[foto_lokasi,2048]|mime_in[foto_lokasi,image/jpg,image/jpeg,image/png]',
            'permit'      => 'required|alpha_numeric_space|min_length[3]|max_length[50]',
        ];

        if ($this->validate($validationRules)) {
            $file = $this->request->getFile('foto_lokasi');
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName); // pastikan folder 'public/uploads' ada dan writable

            $data = [
                'locationName'  => $this->request->getPost('locationName'),
                'companyName'   => $this->request->getPost('companyName'),
                'latitude_deg'  => $this->request->getPost('latitude_deg'),
                'latitude_min'  => $this->request->getPost('latitude_min'),
                'latitude_sec'  => $this->request->getPost('latitude_sec'),
                'latitude_dir'  => $this->request->getPost('latitude_dir'),
                'longitude_deg' => $this->request->getPost('longitude_deg'),
                'longitude_min' => $this->request->getPost('longitude_min'),
                'longitude_sec' => $this->request->getPost('longitude_sec'),
                'longitude_dir' => $this->request->getPost('longitude_dir'),
                'permit'       => $this->request->getPost('permit'),
                'foto_lokasi'  => $newName
            ];

            $this->ModelLokasi->insertData($data);

            return redirect()->to('/Lokasi/inputLokasi')->with('success', 'Data berhasil disimpan!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
     public function pemetaanLokasi(): string
    {
        $data = [
            "judul" => "Data Lokasi",
            "lokasi" => $this->ModelLokasi->getalldata()
        ];

       return view('user/lokasi/v_pemetaan_lokasi', $data);

    }
}
