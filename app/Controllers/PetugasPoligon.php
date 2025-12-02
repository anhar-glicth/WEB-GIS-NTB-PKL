<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelKoordinat;

class PetugasPoligon extends BaseController
{
    /**
     * Menampilkan daftar data poligon yang masuk
     */
    public function index()
    {
        $model = new ModelKoordinat();
        
        // Mengambil semua data diurutkan dari yang terbaru
        $dataPoligon = $model->orderBy('id', 'DESC')->findAll();

        $data = [
            "judul"   => "Data Poligon Masuk",
            // Pastikan path view ini nanti sesuai dengan file yang kita buat
            "page"    => "petugas/v_data_poligon", 
            "poligon" => $dataPoligon
        ];

        // Sesuaikan folder template Anda, biasanya petugas punya folder view sendiri
        return view('petugas/v_data_poligon', $data);
    }

    /**
     * (Opsional) Fitur Hapus Data untuk Petugas
     */
    public function hapus($id)
    {
        $model = new ModelKoordinat();
        
        // Cek data dulu untuk menghapus file gambar/dokumen jika perlu
        $data = $model->find($id);
        
        if ($data) {
            // Hapus File Foto jika ada
            if ($data['foto_lokasi'] && file_exists('uploads/lokasi/' . $data['foto_lokasi'])) {
                unlink('uploads/lokasi/' . $data['foto_lokasi']);
            }
            // Hapus File Dokumen jika ada
            if ($data['dokumen_pendukung'] && file_exists('uploads/dokumen/' . $data['dokumen_pendukung'])) {
                unlink('uploads/dokumen/' . $data['dokumen_pendukung']);
            }

            $model->delete($id);
            return redirect()->to(base_url('petugas/data-poligon'))->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to(base_url('petugas/data-poligon'))->with('error', 'Data tidak ditemukan.');
    }
}