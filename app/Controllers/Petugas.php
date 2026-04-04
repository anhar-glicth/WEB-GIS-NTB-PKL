<?php namespace App\Controllers;

use App\Models\LaporanModel;
use App\Models\PerusahaanModel;
use CodeIgniter\Files\File;
use App\Controllers\BaseController;

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
     */
    public function index()
    {
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

    public function detail($id)
    {
        $laporan = $this->laporanModel
            ->select('laporan.*, users.username, users.email')
            ->join('users', 'users.id = laporan.user_id', 'left')
            ->where('laporan.id', $id)
            ->first();

        if (!$laporan) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
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

        return redirect()->to(base_url('petugas/laporan'))->with('success', 'Laporan berhasil disetujui.');
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

        $catatan = $this->request->getPost('catatan_penolakan');

        if (empty($catatan)) {
            return redirect()->back()->with('error', 'Wajib menyertakan alasan penolakan.');
        }

        $this->laporanModel->update($id, [
            'status' => 'tolak',
            'catatan_penolakan' => $catatan,
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('petugas/laporan'))->with('success', 'Laporan ditolak.');
    }

    /**
     * Download file laporan
     */
    public function download($id)
    {
        $laporan = $this->laporanModel->find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data laporan tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/' . $laporan['file'];

        if (!file_exists($filePath)) {
            $publicPath = FCPATH . 'uploads/' . $laporan['file'];
            if (file_exists($publicPath)) {
                return $this->response->download($publicPath, null);
            }
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        return $this->response->download($filePath, null);
    }

    /**
     * Menampilkan daftar identitas perusahaan (Untuk Petugas)
     */
    public function identitas_perusahaan()
    {
        $data = [
            'judul' => 'Daftar Identitas Perusahaan',
            'perusahaan' => $this->perusahaanModel->findAll()
        ];

        return view('petugas/identitas_perusahaan', $data);
    }

    /**
     * Melihat detail perusahaan tertentu bagi petugas
     */
    public function detailPerusahaan($id)
    {
        $perusahaan = $this->perusahaanModel->find($id);
        
        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $data = [
            'judul' => 'Detail Perusahaan',
            'perusahaan' => $perusahaan
        ];

        // Petugas bisa meminjam view detail milik user atau punya sendiri
        return view('user/detail-perusahaan', $data); 
    }
}