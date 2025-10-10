<?php

namespace App\Controllers;

use App\Models\LaporanModel;

class Petugas extends BaseController
{
    /**
     * Menampilkan daftar laporan
     */
    public function index()
    {
        $laporanModel = new LaporanModel();

        $data = [
            'judul'   => 'Daftar Laporan Pengguna',
            'laporan' => $laporanModel
                ->join('users', 'users.id = laporan.user_id')
                ->select('laporan.*, users.username, users.email')
                ->findAll(),
        ];

        return view('petugas/laporan', $data);
    }

    /**
     * Menyetujui laporan (ACC)
     */
    public function acc($id)
    {
        $model = new LaporanModel();

        if (!$model->find($id)) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        $model->update($id, ['status' => 'acc']);
        return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
    }

    /**
     * Menolak laporan
     */
    public function tolak($id)
    {
        $model = new LaporanModel();

        if (!$model->find($id)) {
            return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
        }

        $model->update($id, ['status' => 'tolak']);
        return redirect()->back()->with('success', 'Laporan telah ditolak.');
    }

    /**
     * Menampilkan detail laporan (mirip tampilan profil akademik dua kolom)
     */
    public function detail($id)
    {
        $model = new LaporanModel();

        $laporan = $model->join('users', 'users.id = laporan.user_id')
            ->select('laporan.*, users.username, users.email')
            ->find($id);

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Laporan tidak ditemukan");
        }

        $data = [
            'judul'   => 'Detail Laporan',
            'laporan' => $laporan
        ];

        return view('petugas/detail_laporan', $data);
    }

    /**
     * Download file laporan
     */
    public function download($id)
    {
        $model = new LaporanModel();
        $laporan = $model->find($id);

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }

        $filePath = WRITEPATH . 'uploads/' . $laporan['file'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server.');
        }

        return $this->response->download($filePath, null);
    }
}
