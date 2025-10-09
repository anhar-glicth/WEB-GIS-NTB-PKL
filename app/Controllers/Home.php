<?php

namespace App\Controllers;

use App\Models\LaporanModel; // Diperlukan untuk mengakses model laporan
use CodeIgniter\Files\File; // Diperlukan untuk penanganan file

class Home extends BaseController
{
    /**
     * Fungsi utama, menangani pengalihan berdasarkan peran pengguna
     */
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
    }

    // ====================================
    // FUNGSI-FUNGSI TAMPILAN PETA (USER)
    // ====================================

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

    // ====================================
    // FUNGSI-FUNGSI LAPORAN (REPORTING)
    // ====================================
    
    /**
     * BARU: Menampilkan formulir input data tambang.
     * Ini yang seharusnya dipanggil oleh URI /input-tambang (GET).
     */
    public function lapor(): string
    {
        $data = [
            "judul" => "Input Data Tambang",
            // Kirim validator agar view bisa menampilkan error jika ada
            "validation" => \Config\Services::validation() 
        ];
        // Pastikan v_input.php ada di app/Views/v_input.php
        return view('user/v_input', $data); 
    }

    /**
     * Menampilkan daftar laporan yang telah disimpan oleh pengguna.
     * Ini dipetakan ke URI /user/laporan.
     */
    public function simpan(): string
    {
        $laporanModel = new LaporanModel(); // Menggunakan use statement
        
        $data = [
            "judul" => "Laporan Pertambangan Saya",
            "laporan" => $laporanModel
                            ->join('users', 'users.id = laporan.user_id')
                            ->select('laporan.*, users.username')
                            ->findAll()
        ];
        // Pastikan v_laporan.php ada di app/Views/user/v_laporan.php
        return view('user/v_laporan', $data);
    }

    /**
     * Mengelola pengunggahan dokumen/file bukti (POST).
     */
    public function dokumen()
    {
        // Pastikan request adalah POST
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Metode request tidak valid.');
        }

        $validation = \Config\Services::validation();
        $rules = [
            'judul' => 'required',
            'file'  => 'uploaded[file]|ext_in[file,pdf,doc,docx]|max_size[file,10240]'
        ];
        
        // Jika validasi gagal, kembalikan ke halaman laporan dengan error
        if (!$this->validate($rules)) {
            // Asumsi v_laporan adalah halaman tempat form upload berada
            return view('user/v_laporan', ['validation' => $this->validator]);
        }

        $file = $this->request->getFile('file');
        $newName = $file->getRandomName();
        
        // Pindahkan file ke folder writable/uploads
        $file->move(WRITEPATH . 'uploads', $newName);

        $laporanModel = new LaporanModel();
        $laporanModel->save([
            'judul'     => $this->request->getPost('judul'),
            'file'      => $newName,
            'user_id'   => user_id(), // Asumsi menggunakan user_id() dari autentikasi
            'status'    => 'pending'
        ]);

        // PERBAIKAN REDIRECT: Mengalihkan ke rute /user/laporan (yang memanggil simpan())
        return redirect()->to(base_url('user/laporan'))->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Mengelola penyimpanan data numerik formulir input tambang (POST).
     * Dipetakan ke URI /user/laporan/insertLaporan.
     */
    public function insertLaporan()
    {
        // Pastikan request adalah POST
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Metode request tidak valid.');
        }

        $laporanModel = new LaporanModel();
        
        // ===================================
        // 1. DEFINISI RULES VALIDASI
        // ===================================
        $rules = [
            // Informasi Umum
            'nama_blok' => 'required|max_length[255]',
            'luas_ha'   => 'required|numeric|greater_than_equal_to[0]',
            
            // Sumberdaya & Cadangan (dibiarkan kosong tapi harus angka jika diisi)
            'sd_tereka_volume'      => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_tereka_tonase'      => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terunjuk_volume'    => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terunjuk_tonase'    => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terukur_volume'     => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terukur_tonase'     => 'permit_empty|numeric|greater_than_equal_to[0]',
            
            'cd_terkira_volume'     => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terkira_tonase'     => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terbukti_volume'    => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terbukti_tonase'    => 'permit_empty|numeric|greater_than_equal_to[0]',
            
            // Rencana Produksi
            'prod_harian'           => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_bulanan'          => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_tahunan'          => 'permit_empty|numeric|greater_than_equal_to[0]',
            'umur_tambang'          => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        // ===================================
        // 2. JALANKAN VALIDASI
        // ===================================
        if (!$this->validate($rules)) {
            // Jika validasi gagal, tampilkan view form lagi dengan pesan error dan data lama
            return view('user/v_input', [
                'validation' => $this->validator
            ]);
        }

        // ===================================
        // 3. AMBIL DAN SIAPKAN DATA
        // ===================================
        $data_input = [
            'nama_blok'             => $this->request->getPost('nama_blok'),
            'luas_ha'               => $this->request->getPost('luas_ha'),
            'sd_tereka_volume'      => $this->request->getPost('sd_tereka_volume'),
            'sd_tereka_tonase'      => $this->request->getPost('sd_tereka_tonase'),
            'sd_terunjuk_volume'    => $this->request->getPost('sd_terunjuk_volume'),
            'sd_terunjuk_tonase'    => $this->request->getPost('sd_terunjuk_tonase'),
            'sd_terukur_volume'     => $this->request->getPost('sd_terukur_volume'),
            'sd_terukur_tonase'     => $this->request->getPost('sd_terukur_tonase'),
            'cd_terkira_volume'     => $this->request->getPost('cd_terkira_volume'),
            'cd_terkira_tonase'     => $this->request->getPost('cd_terkira_tonase'),
            'cd_terbukti_volume'    => $this->request->getPost('cd_terbukti_volume'),
            'cd_terbukti_tonase'    => $this->request->getPost('cd_terbukti_tonase'),
            'prod_harian'           => $this->request->getPost('prod_harian'),
            'prod_bulanan'          => $this->request->getPost('prod_bulanan'),
            'prod_tahunan'          => $this->request->getPost('prod_tahunan'),
            'umur_tambang'          => $this->request->getPost('umur_tambang'),
            
            'user_id' => user_id(), // user_id() otomatis dari sistem autentikasi
            'status'  => 'pending', // Status awal saat data di-submit
        ];

        // ===================================
        // 4. SIMPAN DATA KE DATABASE
        // ===================================
        $laporanModel->save($data_input);

        // ===================================
        // 5. BERIKAN RESPON
        // ===================================
        // Redirect ke halaman daftar laporan
        // ✅ KODE PERBAIKAN
// ✅ KODE PERBAIKAN
return redirect()->to(base_url('user/input-tambang'))->with('success', 'Data Tambang berhasil disimpan!');
    }
}
