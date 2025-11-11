<?php namespace App\Controllers;

use App\Models\PerusahaanModel;
use App\Models\LaporanModel;
use App\Controllers\BaseController;

class User extends BaseController
{
    protected $perusahaanModel;
    protected $laporanModel;

    public function __construct()
    {
        // Inisialisasi model di constructor agar bisa digunakan di semua method
        $this->perusahaanModel = new PerusahaanModel();
        $this->laporanModel = new LaporanModel();
    }
    
    // ======================
    // 1. DASHBOARD USER
    // ======================
    public function index()
    {
        $userId = user_id(); // Mendapatkan ID pengguna yang sedang login

        $data = [
            'judul' => 'Dashboard User',
            'totalLaporan'   => $this->laporanModel->where('user_id', $userId)->countAllResults(),
            // Menggunakan status 'acc' dan 'tolak' sesuai asumsi pada Controller Petugas
            'approvedLaporan'=> $this->laporanModel->where(['user_id' => $userId, 'status' => 'acc'])->countAllResults(),
            'rejectedLaporan'=> $this->laporanModel->where(['user_id' => $userId, 'status' => 'tolak'])->countAllResults(),
        ];
        return view('user/index', $data);
    }

    // ======================
    // 2. FORM INPUT TAMBANG
    // ======================
    public function inputTambang()
    {
        $data = [
            'judul' => 'Form Input Data Tambang',
            'validation' => \Config\Services::validation(),
        ];

        return view('user/v_input', $data);
    }

    // ======================
    // 3. SIMPAN DATA TAMBANG
    // ======================
    public function saveInputTambang()
    {
        $rules = [
            'nama_blok' => 'required|max_length[255]',
            'luas_ha' => 'required|numeric|greater_than_equal_to[0]',
            // Tambahkan semua aturan validasi lainnya sesuai kebutuhan form
            'sd_tereka_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_tereka_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terunjuk_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terunjuk_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terukur_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terukur_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terkira_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terkira_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terbukti_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terbukti_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_harian' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_bulanan' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_tahunan' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'umur_tambang' => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'validation' => $this->validator,
                'judul' => 'Form Input Data Tambang',
            ];
            return view('user/v_input', $data);
        }

        // Simpan data ke tabel laporan
        $this->laporanModel->save([
            'user_id' => user_id(),
            'nama_blok' => $this->request->getPost('nama_blok'),
            'luas_ha' => $this->request->getPost('luas_ha'),
            // Semua field lainnya...
            'sd_tereka_volume' => $this->request->getPost('sd_tereka_volume'),
            'sd_tereka_tonase' => $this->request->getPost('sd_tereka_tonase'),
            'sd_terunjuk_volume' => $this->request->getPost('sd_terunjuk_volume'),
            'sd_terunjuk_tonase' => $this->request->getPost('sd_terunjuk_tonase'),
            'sd_terukur_volume' => $this->request->getPost('sd_terukur_volume'),
            'sd_terukur_tonase' => $this->request->getPost('sd_terukur_tonase'),
            'cd_terkira_volume' => $this->request->getPost('cd_terkira_volume'),
            'cd_terkira_tonase' => $this->request->getPost('cd_terkira_tonase'),
            'cd_terbukti_volume' => $this->request->getPost('cd_terbukti_volume'),
            'cd_terbukti_tonase' => $this->request->getPost('cd_terbukti_tonase'),
            'prod_harian' => $this->request->getPost('prod_harian'),
            'prod_bulanan' => $this->request->getPost('prod_bulanan'),
            'prod_tahunan' => $this->request->getPost('prod_tahunan'),
            'umur_tambang' => $this->request->getPost('umur_tambang'),
            'status' => 'pending',
        ]);

        return redirect()->to(base_url('user/laporan'))->with('success', 'Data tambang berhasil disimpan!');
    }


    // ==========================================================
    // 4. FORM INPUT IDENTITAS PERUSAHAAN (Untuk Edit/Insert)
    // ==========================================================
    public function inputPerusahaan()
    {
        $userId = user_id();

        // Cek apakah data perusahaan sudah ada (untuk mengisi form jika edit)
        $perusahaan = $this->perusahaanModel->where('user_id', $userId)->first();
        
        $data = [
            'judul' => empty($perusahaan) ? 'Form Identitas Perusahaan' : 'Edit Identitas Perusahaan',
            'perusahaan' => $perusahaan,
            'validation' => \Config\Services::validation(),
        ];

        // View yang dituju: app/Views/user/input-perusahaan.php
        return view('user/input-perusahaan', $data);
    }

    // ==========================================================
    // 5. SIMPAN/UPDATE DATA IDENTITAS PERUSAHAAN
    // ==========================================================
    public function saveInputPerusahaan()
    {
        $userId = user_id();

        // Aturan validasi untuk data perusahaan
        $rules = [
            'nama_perusahaan'   => 'required|min_length[3]',
            'alamat_perusahaan' => 'required',
            'npwp'              => 'permit_empty',
            'jenis_usaha'       => 'required',
            'tahun_berdiri'     => 'required|numeric',
            'nib'               => 'permit_empty',
            'izin_usaha'        => 'permit_empty',
            'masa_berlaku'      => 'permit_empty|valid_date',
            'nama_direktur'     => 'required',
            'email_perusahaan'  => 'required|valid_email',
            'no_telepon'        => 'required|min_length[8]',
            'website'           => 'permit_empty|valid_url_strict'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan user ke form dengan data input sebelumnya
             $perusahaanData = [
                'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
                'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan'),
                'npwp' => $this->request->getPost('npwp'),
                'jenis_usaha' => $this->request->getPost('jenis_usaha'),
                'tahun_berdiri' => $this->request->getPost('tahun_berdiri'),
                'nib' => $this->request->getPost('nib'),
                'izin_usaha' => $this->request->getPost('izin_usaha'),
                'masa_berlaku' => $this->request->getPost('masa_berlaku'),
                'nama_direktur' => $this->request->getPost('nama_direktur'),
                'email_perusahaan' => $this->request->getPost('email_perusahaan'),
                'no_telepon' => $this->request->getPost('no_telepon'),
                'website' => $this->request->getPost('website'),
            ];

            return view('user/input-perusahaan', [
                'validation' => $this->validator,
                'judul' => 'Form Identitas Perusahaan',
                'perusahaan' => $perusahaanData 
            ]);
        }

        $data = [
            'user_id'           => $userId,
            'nama_perusahaan'   => $this->request->getPost('nama_perusahaan'),
            'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan'),
            'npwp'              => $this->request->getPost('npwp'),
            'jenis_usaha'       => $this->request->getPost('jenis_usaha'),
            'tahun_berdiri'     => $this->request->getPost('tahun_berdiri'),
            'nib'               => $this->request->getPost('nib'),
            'izin_usaha'        => $this->request->getPost('izin_usaha'),
            'masa_berlaku'      => $this->request->getPost('masa_berlaku'),
            'nama_direktur'     => $this->request->getPost('nama_direktur'),
            'email_perusahaan'  => $this->request->getPost('email_perusahaan'),
            'no_telepon'        => $this->request->getPost('no_telepon'),
            'website'           => $this->request->getPost('website')
        ];

        // Cek data yang sudah ada untuk menentukan insert atau update (Upsert Logic)
        $existingPerusahaan = $this->perusahaanModel->where('user_id', $userId)->first();
        
        if ($existingPerusahaan) {
            // Update data yang sudah ada
            $this->perusahaanModel->update($existingPerusahaan['id'], $data);
            $message = 'Data identitas perusahaan berhasil diperbarui!';
        } else {
            // Insert data baru
            $this->perusahaanModel->insert($data);
            $message = 'Data identitas perusahaan berhasil disimpan!';
        }

        // Redirect ke halaman detail setelah save/update
        return redirect()->to(base_url('user/detailPerusahaan'))->with('success', $message);
    }
    
    // ==========================================================
    // 6. TAMPILKAN DETAIL PERUSAHAAN (Untuk User yang sedang login)
    // ==========================================================
    public function detailPerusahaan()
    {
        $userId = user_id(); 

        // Cari data perusahaan berdasarkan user ID
        $perusahaan = $this->perusahaanModel->where('user_id', $userId)->first();
        
        // Jika data belum ada, arahkan ke form input
        if (!$perusahaan) {
            return redirect()->to(base_url('user/input-perusahaan'))->with('info', 'Mohon lengkapi data identitas perusahaan terlebih dahulu.');
        }

        $data = [
            'judul' => 'Detail Identitas Perusahaan',
            'perusahaan' => $perusahaan,
        ];

        // View yang dituju: app/Views/user/detail-perusahaan.php
        return view('user/detail-perusahaan', $data); 
    }
}