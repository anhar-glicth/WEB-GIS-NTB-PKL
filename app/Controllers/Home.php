<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Role-based redirect (prioritas utama)
        if (in_groups('admin')) {
            return redirect()->to('/admin');
        } elseif (in_groups('petugas')) {
            return redirect()->to('/petugas');
        } else {
            return redirect()->to('/user');
        }

        // Jika tidak pakai role, bisa fallback ke halaman dashboard
        // return view('index', [
        //     'judul' => 'Home',
        //     'page' => 'v_dashboard'
        // ]);
    }

    public function viewMaps(): string
    {
        $data = [
            "judul" => "View Maps",
            "page"  => "v_viewmaps",
        ];

        return view('user/v_viewmaps', $data);
    }

    public function baseMaps(): string
    {
        $data = [
            "judul" => "Base Maps",
            "page"  => "v_basemaps",
        ];

        return view('user/v_basemaps', $data);
    }

    public function marker(): string
    {
        $data = [
            "judul" => "Marker",
            "page"  => "v_marker",
        ];

        return view('user/v_marker', $data);
    }

    public function poligon(): string
    {
        $data = [
            "judul" => "Poligon",
            "page"  => "v_poligon",
        ];

        return view('user/v_poligon', $data);
    }

    public function registrasi(): string
    {
        return view('auth/registrasi');
    }

    public function users(): string
    {
        return view('users/index');
    }
    public function simpan(): string
{
    $laporanModel = new \App\Models\LaporanModel();  // Inisialisasi dulu

    $data = [
        "judul" => "Laporan",
        "laporan" => $laporanModel
                        ->join('users', 'users.id = laporan.user_id')
                        ->select('laporan.*, users.username')
                        ->findAll()
    ];

    return view('user/v_laporan', $data);
}
    
public function dokumen()
{
    $validation = \Config\Services::validation();
    $validation->setRules([
        'judul' => 'required',
        'file'  => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,10240]'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return view('user/v_laporan', ['validation' => $validation]);
    }

    $file = $this->request->getFile('file');
    $newName = $file->getRandomName();
    $file->move(WRITEPATH . 'uploads', $newName);

    $laporanModel = new \App\Models\LaporanModel();
    $laporanModel->save([
        'judul'    => $this->request->getPost('judul'),
        'file'     => $newName,
        'user_id'  => session()->get('user_id'),
        'status'   => 'pending'
    ]);

    return redirect()->to('/user/v_laporan')->with('success', 'Laporan berhasil diunggah.');
}

}
