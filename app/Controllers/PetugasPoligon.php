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
            // Gabungkan Permit + Nama Lokasi agar area yang berbeda tidak bertumpuk
            $key = $row['permit'] . '_' . ($row['locationName'] ?? 'NoName');
            
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'companyName'       => $row['companyName'],
                    'locationName'      => $row['locationName'] ?? 'Tidak Diketahui',
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
     * SETUJUI KOORDINAT BERDASARKAN PERMIT & LOKASI
     */
    public function acc($permitHex, $locationHex)
    {
        $permit   = hex2bin($permitHex);
        $location = hex2bin($locationHex);
        
        $model = new ModelKoordinat();
        // Update SEMUA titik yang punya permit DAN lokasi yang sama
        $model->where('permit', $permit)
              ->where('locationName', $location)
              ->set([
                  'status'          => 'Disetujui',
                  'catatan_petugas' => 'Data koordinat telah diverifikasi valid dan sesuai dengan lokasi ' . $location
              ])->update();
        
        return redirect()->to(base_url('petugas/data-poligon'))->with('success', '✅ AREA (' . $permit . ' - ' . $location . ') telah DISETUJUI.');
    }

    /**
     * TOLAK KOORDINAT BERDASARKAN PERMIT & LOKASI
     */
    public function tolak($permitHex, $locationHex)
    {
        $permit   = hex2bin($permitHex);
        $location = hex2bin($locationHex);
        
        $model = new ModelKoordinat();
        $catatan = $this->request->getPost('catatan') ?: 'Data koordinat tidak valid untuk lokasi ' . $location;
        
        $model->where('permit', $permit)
              ->where('locationName', $location)
              ->set([
                  'status'          => 'Ditolak',
                  'catatan_petugas' => $catatan
              ])->update();
        
        return redirect()->to(base_url('petugas/data-poligon'))->with('error', '❌ AREA (' . $permit . ' - ' . $location . ') telah DITOLAK.');
    }

    /**
     * Hapus Data Berdasarkan Permit & Lokasi
     */
    public function hapus($permitHex, $locationHex)
    {
        $permit   = hex2bin($permitHex);
        $location = hex2bin($locationHex);
        
        $model = new ModelKoordinat();
        $data = $model->where('permit', $permit)->where('locationName', $location)->first();
        
        if ($data) {
            // Hapus file foto jika ada
            if ($data['foto_lokasi'] && file_exists('uploads/lokasi/' . $data['foto_lokasi'])) {
                @unlink('uploads/lokasi/' . $data['foto_lokasi']);
            }
            
            $model->where('permit', $permit)->where('locationName', $location)->delete();
            return redirect()->to(base_url('petugas/data-poligon'))->with('success', 'Data area (' . $location . ') berhasil dihapus.');
        }

        return redirect()->to(base_url('petugas/data-poligon'))->with('error', 'Data tidak ditemukan.');
    }
}