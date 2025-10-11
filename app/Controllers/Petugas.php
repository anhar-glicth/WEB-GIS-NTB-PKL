<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\PerusahaanModel;
use CodeIgniter\Files\File;

class Petugas extends BaseController
{
    protected $laporanModel;
    protected $perusahaanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->perusahaanModel = new PerusahaanModel();
    }

    /**
     * Dashboard Petugas
     * Menampilkan ringkasan dan laporan terbaru
     */
    public function index()
    {
        // Panggil fungsi dashboard langsung
        return $this->dashboard();
    }

    /**
     * Dashboard utama
     */
   public function dashboard()
{
    $data = [
        'judul'           => 'Dashboard Petugas',
        'totalLaporan'    => $this->laporanModel->countAllResults(),
        'laporanAcc'      => $this->laporanModel->where('status', 'acc')->countAllResults(),
        'laporanTolak'    => $this->laporanModel->where('status', 'tolak')->countAllResults(),
        'laporanPending'  => $this->laporanModel->where('status', 'pending')->countAllResults(),
        'laporanTerbaru'  => $this->laporanModel
            ->select('laporan.*, users.username')
            ->join('users', 'users.id = laporan.user_id', 'left')
            ->orderBy('laporan.created_at', 'DESC')
            ->limit(5)
            ->findAll(),
    ];

    return view('petugas/dashboard', $data);
}


    /**
     * Daftar semua laporan pengguna
     */
    public function laporan()
    {
        $data = [
            'judul'   => 'Daftar Laporan Pengguna',
            'laporan' => $this->laporanModel
                ->select('laporan.*, users.username, users.email')
                ->join('users', 'users.id = laporan.user_id', 'left')
                ->orderBy('laporan.created_at', 'DESC')
                ->findAll(),
        ];

        return view('petugas/laporan', $data);
    }

    /**
     * Detail laporan + identitas perusahaan
     */
    public function detail($id)
    {
        $laporan = $this->laporanModel
            ->select('laporan.*, users.username, users.email')
            ->join('users', 'users.id = laporan.user_id', 'left')
            ->where('laporan.id', $id)
            ->first();

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Laporan tidak ditemukan.');
        }

        $perusahaan = $this->perusahaanModel
            ->where('user_id', $laporan['user_id'])
            ->first();

        $data = [
            'judul' => 'Detail Laporan',
            'laporan' => $laporan,
            'perusahaan' => $perusahaan
        ];

        return view('petugas/detail_laporan', $data);
    }

    /**
     * ACC laporan
     */
    public function acc($id)
    {
        $laporan = $this->laporanModel->find($id);
        if (!$laporan) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        $this->laporanModel->update($id, [
            'status' => 'acc',
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('petugas'))->with('success', 'Laporan berhasil disetujui.');
    }

    /**
     * Tolak laporan
     */
    public function tolak($id)
    {
        $laporan = $this->laporanModel->find($id);
        if (!$laporan) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        $this->laporanModel->update($id, [
            'status' => 'tolak',
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('petugas'))->with('success', 'Laporan berhasil ditolak.');
    }

    /**
     * Download file laporan
     */
    public function download($id)
    {
        $laporan = $this->laporanModel->find($id);

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/' . $laporan['file'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return $this->response->download($filePath, null);
    }

    /**
     * Menampilkan laporan pending
     */
    public function pending()
    {
        $data = [
            'judul'   => 'Laporan Pending',
            'laporan' => $this->laporanModel
                ->where('status', 'pending')
                ->join('users', 'users.id = laporan.user_id', 'left')
                ->select('laporan.*, users.username, users.email')
                ->orderBy('laporan.created_at', 'DESC')
                ->findAll(),
        ];

        return view('petugas/laporan_pending', $data);
    }
     public function identitas_perusahaan()
    {
        // ambil data dari model kalau perlu
        $model = new PerusahaanModel();
        $data['perusahaan'] = $model->findAll();

        return view('petugas/identitas_perusahaan', $data);
    }

    public function simpan_identitas()
    {
        $model = new PerusahaanModel();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
        ];

        $model->insert($data);
        return redirect()->to(base_url('petugas/identitas_perusahaan'))->with('success', 'Data berhasil disimpan!');
    }
}
