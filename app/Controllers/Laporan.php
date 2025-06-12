<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use CodeIgniter\Controller;

class Laporan extends BaseController
{
    public function index()
{
    $laporanModel = new LaporanModel();

    $laporan = $laporanModel
        ->select('laporan.*, users.username')
        ->join('users', 'users.id = laporan.user_id')
        ->findAll();

    return view('petugas/laporan', [
        'title'  => 'Laporan',
        'laporan' => $laporan,
    ]);
}


    public function save()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'judul' => 'required',
            'file'  => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $file = $this->request->getFile('file');
        $newName = $file->getRandomName();
        $file->move('uploads', $newName);

        $model = new LaporanModel();
        $model->insert([
            'judul'    => $this->request->getPost('judul'),
            'file'     => $newName,
            'user_id'  => user_id(), // dari Myth/Auth
            'status'   => 'pending',
        ]);

        return redirect()->to('/laporan')->with('success', 'Laporan berhasil diunggah.');
    }
    public function insertLaporan()
    {
        if($this->validate([
            'judul' => 'required',
            'file'  => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,5120]',
        ])) {
            $laporanModel = new LaporanModel();
            $file = $this->request->getFile('file');
            $newName = $file->getRandomName();
            $file->move('uploads', $newName);

            $laporanData = [
                'judul'    => $this->request->getPost('judul'),
                'file'     => $newName,
                'user_id'  => user_id(), // dari Myth/Auth
                'status'   => 'pending',
            ];

            $laporanModel->insertLaporan($laporanData);
            return redirect()->to('/user/v_laporan')->with('success', 'Laporan berhasil diunggah.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}

