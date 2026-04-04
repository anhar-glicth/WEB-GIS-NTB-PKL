<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKoordinat;

class PetugasPoligon extends BaseController
{
    /**
     * Menampilkan daftar data poligon yang masuk (Dikelompokkan per Izin)
     */
    public function index()
    {
        $model = new ModelKoordinat();
        
        // Kita ambil semua data
        $allData = $model->orderBy('id', 'DESC')->findAll();

        // Kita kelompokkan secara manual di Controller agar lebih fleksibel
        $grouped = [];
        foreach ($allData as $row) {
            $key = $row['permit'];
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'companyName'       => $row['companyName'],
                    'locationName'      => $row['locationName'],
                    'permit'            => $row['permit'],
                    'status'            => $row['status'],
                    'catatan_petugas'   => $row['catatan_petugas'],
                    'foto_lokasi'       => $row['foto_lokasi'],
                    'dokumen_pendukung' => $row['dokumen_pendukung'],
                    'titik_count'       => 0,
                    'last_update'       => $row['id'] // Untuk urutan saja
                ];
            }
            $grouped[$key]['titik_count']++;
        }

        $data = [
            "title"   => "Daftar Titik Koordinat Masuk",
            "judul"   => "Koordinat Tambang",
            "poligon" => $grouped
        ];

        return view('petugas/v_data_poligon', $data);
    }

    /**
     * SETUJUI KOORDINAT BERDASARKAN PERMIT
     */
    public function acc($permit)
    {
        $model = new ModelKoordinat();
        // Update SEMUA baris yang punya nomor izin (permit) yang sama
        $model->where('permit', $permit)->set([
            'status'          => 'Disetujui',
            'catatan_petugas' => 'Data koordinat telah diverifikasi valid dan sesuai dengan dokumen.'
        ])->update();
        
        return redirect()->to(base_url('petugas/data-poligon'))->with('success', '✅ SELURUH AREA (' . $permit . ') telah DISETUJUI dan langsung muncul di peta.');
    }

    /**
     * TOLAK KOORDINAT BERDASARKAN PERMIT
     */
    public function tolak($permit)
    {
        $model = new ModelKoordinat();
        $catatan = $this->request->getPost('catatan') ?: 'Data koordinat tidak valid atau kurang lengkap.';
        
        // Update SEMUA baris yang punya nomor izin yang sama
        $model->where('permit', $permit)->set([
            'status'          => 'Ditolak',
            'catatan_petugas' => $catatan
        ])->update();
        
        return redirect()->to(base_url('petugas/data-poligon'))->with('error', '❌ AREA (' . $permit . ') telah DITOLAK.');
    }

    /**
     * Hapus Data Berdasarkan Permit
     */
    public function hapus($permit)
    {
        $model = new ModelKoordinat();
        $data = $model->where('permit', $permit)->first();
        
        if ($data) {
            if ($data['foto_lokasi'] && file_exists('uploads/lokasi/' . $data['foto_lokasi'])) {
                @unlink('uploads/lokasi/' . $data['foto_lokasi']);
            }
            $model->where('permit', $permit)->delete();
            return redirect()->to(base_url('petugas/data-poligon'))->with('success', 'Data area berhasil dihapus.');
        }

        return redirect()->to(base_url('petugas/data-poligon'))->with('error', 'Data tidak ditemukan.');
    }
}