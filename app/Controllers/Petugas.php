<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use Myth\Auth\Models\UserModel;

class Petugas extends BaseController
{
    /**
     * Dashboard Petugas (List Laporan)
     */
    public function index()
    {
        $model = new LaporanModel();
        
        $data = [
            'title' => 'Dashboard Petugas',
            'totalLaporan' => $model->countAllResults(),
            'laporanPending' => $model->where('status', 'Pending')->countAllResults(),
            'laporanACC' => $model->where('status', 'ACC')->countAllResults(),
            'laporanTolak' => $model->where('status', 'Ditolak')->countAllResults(),
            'laporan' => $model->select('laporan.*, users.username, users.email')
                               ->join('users', 'users.id = laporan.user_id')
                               ->findAll()
        ];

        return view('petugas/index', $data);
    }

    /**
     * Tampilkan Detail Laporan
     */
    public function detail($id)
    {
        $model = new LaporanModel();
        $data = [
            'title' => 'Detail Laporan Wilayah',
            'laporan' => $model->select('laporan.*, users.username, users.email')
                               ->join('users', 'users.id = laporan.user_id')
                               ->where('laporan.id', $id)
                               ->first()
        ];
        
        if (!$data['laporan']) {
            return redirect()->to('/petugas')->with('error', 'Laporan tidak ditemukan.');
        }

        return view('petugas/detail', $data);
    }

    /**
     * Aksi: ACC (Setujui Laporan)
     */
    public function acc($id)
    {
        $model = new LaporanModel();
        $model->update($id, [
            'status' => 'ACC',
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas')->with('message', 'Laporan berhasil disetujui (ACC).');
    }

    /**
     * Aksi: Tolak Laporan (dengan alasan)
     */
    public function tolak()
    {
        $id = $this->request->getPost('id');
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

        return redirect()->to('/petugas')->with('message', 'Laporan telah ditolak dengan catatan revisi.');
    }

    /** 
     * MANAJEMEN PROFILE PETUGAS (Password Enabled)
     */
    public function profile(): string
    {
        $data['title'] = 'My Profile (Petugas)';
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, users.username, users.email, auth_groups.name as role');
        $builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
        $builder->where('users.id', user_id());

        $query = $builder->get();
        $data['user'] = $query->getRow();

        return view('petugas/profile', $data);
    }

    public function editProfile(): string
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
            'username' => 'required|min_length[3]|alpha_numeric_space',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[8]' // Validasi password minimal 8 karakter jika diisi
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UserModel();
        $user = $users->find(user_id());

        $user->username = $this->request->getPost('username');
        $user->email = $this->request->getPost('email');

        // Jika password diisi, update password
        if ($this->request->getPost('password')) {
            $user->setPassword($this->request->getPost('password'));
        }

        $users->save($user); // Myth/Auth handling hashing automatically via Entity

        return redirect()->to('/petugas/profile')->with('message', 'Profil & Password Petugas berhasil diperbarui!');
    }
}