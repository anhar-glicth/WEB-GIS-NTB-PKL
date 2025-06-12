<?php

namespace App\Controllers;

use App\Models\LaporanModel;

class Petugas extends BaseController
{
    // Menampilkan daftar laporan
    public function index()
    {
        $laporanModel = new LaporanModel();

        $data = [
            'judul'   => 'Laporan',
            'laporan' => $laporanModel
                            ->join('users', 'users.id = laporan.user_id')
                            ->select('laporan.*, users.username')
                            ->findAll(),
        ];

        return view('petugas/laporan', $data);
    }

    // Approve laporan
    public function acc($id)
    {
        $model = new LaporanModel();
        $model->update($id, ['status' => 'acc']);
        return redirect()->back()->with('success', 'Laporan disetujui.');
    }

    // Tolak laporan
    public function tolak($id)
    {
        $model = new LaporanModel();
        $model->update($id, ['status' => 'tolak']);
        return redirect()->back()->with('success', 'Laporan ditolak.');
    }

    // Download file laporan
    public function download($id)
    {
        $model = new LaporanModel();
        $laporan = $model->find($id);

        if (!$laporan) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }

        // Path file ada di writable/uploads
        return $this->response->download(WRITEPATH . 'uploads/' . $laporan['file'], null);
    }
}
