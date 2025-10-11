<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\PerusahaanModel; // ✅ tambahkan ini untuk model perusahaan

class User extends BaseController
{
    // ======================
    // DASHBOARD USER
    // ======================
    public function index()
    {
        $laporanModel = new LaporanModel();
        $userId = user_id(); // dari Myth/Auth

        $data = [
            'judul' => 'Dashboard User',
            'totalLaporan'   => $laporanModel->where('user_id', $userId)->countAllResults(),
            'approvedLaporan'=> $laporanModel->where(['user_id' => $userId, 'status' => 'approved'])->countAllResults(),
            'rejectedLaporan'=> $laporanModel->where(['user_id' => $userId, 'status' => 'rejected'])->countAllResults(),
        ];

        return view('user/index', $data);
    }

    // ======================
    // FORM INPUT TAMBANG
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
    // SIMPAN DATA TAMBANG
    // ======================
    public function saveInputTambang()
    {
        $laporanModel = new LaporanModel();

        $rules = [
            'nama_blok' => 'required|max_length[255]',
            'luas_ha' => 'required|numeric|greater_than_equal_to[0]',
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
            return view('user/v_input', [
                'validation' => $this->validator
            ]);
        }

        $laporanModel->save([
            'user_id' => user_id(),
            'nama_blok' => $this->request->getPost('nama_blok'),
            'luas_ha' => $this->request->getPost('luas_ha'),
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
    // FORM INPUT IDENTITAS PERUSAHAAN
    // ==========================================================
    public function inputPerusahaan()
    {
        $data = [
            'judul' => 'Form Identitas Perusahaan',
            'validation' => \Config\Services::validation(),
        ];

        return view('user/input-perusahaan', $data);
    }

    // ==========================================================
    // SIMPAN DATA IDENTITAS PERUSAHAAN
    // ==========================================================
    public function saveInputPerusahaan()
    {
        $perusahaanModel = new PerusahaanModel();

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
            return view('user/input-perusahaan', [
                'validation' => $this->validator
            ]);
        }

        $data = [
            'user_id'           => user_id(),
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

        $perusahaanModel->insert($data);

        return redirect()->to(base_url('user/input-perusahaan'))->with('success', 'Data identitas perusahaan berhasil disimpan!');
    }
}
