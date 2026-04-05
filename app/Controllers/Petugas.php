<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use Myth\Auth\Models\UserModel;

class Petugas extends BaseController
{
    /**
     * Dashboard Petugas (Ringkasan)
     */
    public function dashboard()
    {
        $model = new LaporanModel();
        
        $data = [
            'title' => 'Dashboard Manajemen Wilayah',
            'totalLaporan' => $model->countAllResults(),
            // Tangkap semua variasi penulisan status
            'laporanPending' => $model->whereIn('status', ['pending', 'Pending', 'Menunggu'])->countAllResults(),
            'laporanAcc'     => $model->whereIn('status', ['acc', 'ACC', 'Disetujui', 'disetujui'])->countAllResults(),
            'laporanTolak'   => $model->whereIn('status', ['tolak', 'Tolak', 'Ditolak', 'ditolak'])->countAllResults(),
            'laporanTerbaru' => $model->select('laporan.*, users.username, users.email')
                               ->join('users', 'users.id = laporan.user_id')
                               ->orderBy('laporan.created_at', 'DESC')
                               ->limit(5)
                               ->findAll()
        ];

        return view('petugas/dashboard', $data);
    }

    /**
     * Daftar Seluruh Laporan
     */
    public function laporan()
    {
        $model = new LaporanModel();
        
        $data = [
            'title'   => 'Daftar Laporan Wilayah',
            'laporan' => $model->select('laporan.*, users.username, users.email')
                               ->join('users', 'users.id = laporan.user_id')
                               ->orderBy('laporan.created_at', 'DESC')
                               ->findAll()
        ];

        return view('petugas/laporan', $data);
    }

    /**
     * Detail Laporan & Identitas Perusahaan
     */
    public function detail($id)
    {
        $model = new LaporanModel();
        $db = \Config\Database::connect();
        
        $data['laporan'] = $model->select('laporan.*, users.username, users.email')
                               ->join('users', 'users.id = laporan.user_id')
                               ->where('laporan.id', $id)
                               ->first();
        
        if (!$data['laporan']) {
            return redirect()->to('/petugas/laporan')->with('error', 'Laporan tidak ditemukan.');
        }

        $data['title'] = 'Detail Verifikasi Laporan';
        
        // Ambil Data Perusahaan
        $data['perusahaan'] = $db->table('perusahaan')
                                 ->where('user_id', $data['laporan']['user_id'])
                                 ->get()
                                 ->getRowArray();

        return view('petugas/detail_laporan', $data);
    }

    /**
     * Aksi: ACC (Setujui Laporan)
     */
    public function acc($id)
    {
        $model = new \App\Models\LaporanModel();
        $model->update($id, [
            'status' => 'Disetujui',
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/laporan')->with('success', 'Laporan berhasil disetujui (ACC).');
    }

    /**
     * Aksi: Tolak Laporan (dengan catatan)
     */
    public function tolak($id)
    {
        $catatan = $this->request->getPost('catatan_penolakan');

        if (empty($catatan)) {
            return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $model = new LaporanModel();
        $model->update($id, [
            'status' => 'Ditolak',
            'catatan_penolakan' => $catatan,
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/laporan')->with('message', 'Laporan telah ditolak dengan catatan revisi.');
    }

    /**
     * Fitur Download Berkas Laporan
     */
    public function download($id)
    {
        $model = new LaporanModel();
        $laporan = $model->find($id);

        if (!$laporan || empty($laporan['file'])) {
            return redirect()->back()->with('error', 'Catatan: File tidak ditemukan di database.');
        }

        // Pastikan path sesuai dengan tempat penyimpanan (uploads/dokumen/)
        $filepath = 'uploads/dokumen/' . $laporan['file'];

        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'Maaf, file fisik (' . $laporan['file'] . ') tidak ditemukan di folder uploads/dokumen/.');
        }

        return $this->response->download($filepath, null);
    }

    /**
     * MANAJEMEN PROFILE PETUGAS
     */
    public function profile()
    {
        $data['title'] = 'My Profile (Petugas)';
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, username, email, name as role');
        $builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
        $builder->where('users.id', user_id());
        $data['user'] = $builder->get()->getRow();

        return view('petugas/profile', $data);
    }

    public function editProfile()
    {
        $data['title'] = 'Edit Profile Petugas';
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', user_id());
        $data['user'] = $builder->get()->getRow();

        return view('petugas/edit_profile', $data);
    }

    public function updateProfile()
    {
        $rules = [
            'username'   => 'required|min_length[3]|alpha_numeric_space',
            'email'      => 'required|valid_email',
            'password'   => 'permit_empty|min_length[8]',
            'user_image' => 'is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]|max_size[user_image,1024]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usersModel = new UserModel();
        $user = $usersModel->find(user_id());
        $db = \Config\Database::connect();

        $dataUpdate = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $user->setPassword($this->request->getPost('password'));
            $dataUpdate['password_hash'] = $user->password_hash;
        }

        $file = $this->request->getFile('user_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if (!is_dir('uploads/profile')) {
                mkdir('uploads/profile', 0777, true);
            }
            $file->move('uploads/profile/', $newName);

            if ($user->user_image != 'default.svg' && !empty($user->user_image)) {
                if (file_exists('uploads/profile/' . $user->user_image)) {
                    @unlink('uploads/profile/' . $user->user_image);
                }
            }
            $dataUpdate['user_image'] = $newName;
        }

        $db->table('users')->where('id', user_id())->update($dataUpdate);

        return redirect()->to('/petugas/profile')->with('message', 'Profil & Foto Petugas berhasil diperbarui!');
    }
}