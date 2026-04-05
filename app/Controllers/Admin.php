<?php

namespace App\Controllers;

use App\Models\LaporanModel;
use Myth\Auth\Models\UserModel;

class Admin extends BaseController
{
    protected $db, $builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }

    public function index()
    {
        $data['title'] = 'Admin Dashboard';
        $data['total_users'] = $this->db->table('users')->countAllResults();
        $data['total_groups'] = $this->db->table('auth_groups')->countAllResults();

        // TAMBAHKAN STATISTIK LAPORAN GLOBAL
        $laporanModel = new LaporanModel();
        $data['total_laporan']   = $laporanModel->countAllResults();
        $data['pending_laporan'] = $laporanModel->whereIn('status', ['pending', 'Pending', 'Menunggu', ''])->countAllResults();
        $data['acc_laporan']     = $laporanModel->whereIn('status', ['acc', 'ACC', 'Disetujui', 'disetujui'])->countAllResults();
        $data['tolak_laporan']   = $laporanModel->whereIn('status', ['tolak', 'Tolak', 'Ditolak', 'ditolak'])->countAllResults();
        
        $this->builder->select('username, email, name as role, users.created_at');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->orderBy('users.created_at', 'DESC');
        $data['recent_users'] = $this->builder->get(5)->getResult();

        return view('admin/dashboard', $data);
    }

    public function userList()
    {
        $data['title'] = 'User List';
        $this->builder->select('users.id as userid, username, email, name as role');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $data['userList'] = $this->builder->get()->getResult();

        return view('admin/user_list', $data);
    }

    public function detail($id = null)
    {
        $this->builder->select('users.id as userid, username, email, user_image, name as role');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $data['user'] = $this->builder->get()->getRow();

        if (empty($data['user'])) return redirect()->to('/admin');
        
        $data['title'] = 'User Detail';
        return view('admin/detail', $data);
    }

    public function profile(): string
    {
        $data['title'] = 'My Admin Profile';
        $this->builder->select('users.id as userid, username, email, name as role');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
        $this->builder->where('users.id', user_id());
        $data['user'] = $this->builder->get()->getRow();

        return view('admin/profile', $data);
    }

    public function editProfile(): string
    {
        $data['title'] = 'Edit Profile Admin';
        $this->builder->where('id', user_id());
        $data['user'] = $this->builder->get()->getRow();
        return view('admin/edit_profile', $data);
    }

    public function updateProfile()
    {
        $rules = [
            'username'   => 'required|min_length[3]|alpha_numeric_space',
            'email'      => 'required|valid_email',
            'password'   => 'permit_empty|min_length[8]',
            'user_image' => 'is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]|max_size[user_image,1024]'
        ];

        if (!$this->validate($rules)) return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $userModel = new UserModel();
        $user = $userModel->find(user_id());
        $db = \Config\Database::connect();

        $dataUpdate = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $user->setPassword($this->request->getPost('password'));
            $dataUpdate['password_hash'] = $user->password_hash;
        }

        // --- HANDLE UPLOAD FOTO ADMIN ---
        $file = $this->request->getFile('user_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if (!is_dir('uploads/profile')) {
                mkdir('uploads/profile', 0777, true);
            }
            $file->move('uploads/profile/', $newName);

            // Hapus foto lama
            if ($user->user_image != 'default.svg' && !empty($user->user_image)) {
                if (file_exists('uploads/profile/' . $user->user_image)) {
                    @unlink('uploads/profile/' . $user->user_image);
                }
            }
            $dataUpdate['user_image'] = $newName;
        }

        $db->table('users')->where('id', user_id())->update($dataUpdate);

        return redirect()->to('/admin/profile')->with('message', 'Profil Admin berhasil diperbarui!');
    }

    public function settings()
    {
        $data['title'] = 'Web Site Settings';
        $data['kv'] = [];
        foreach ($this->db->table('web_settings')->get()->getResultArray() as $s) {
            $data['kv'][$s['setting_key']] = $s['setting_value'];
        }
        return view('admin/settings', $data);
    }

    public function updateSettings()
    {
        $settingsBuilder = $this->db->table('web_settings');
        $siteName = $this->request->getPost('site_name');
        if ($siteName) $settingsBuilder->where('setting_key', 'site_name')->update(['setting_value' => $siteName]);

        $file = $this->request->getFile('hero_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/web/', $newName);
            $settingsBuilder->where('setting_key', 'hero_image')->update(['setting_value' => base_url('uploads/web/' . $newName)]);
        }

        return redirect()->to('/admin/settings')->with('message', 'Pengaturan diperbarui!');
    }

    public function createUser()
    {
        $data['title']  = 'Tambah Akun Baru';
        $data['groups'] = $this->db->table('auth_groups')->get()->getResult();
        return view('admin/create_user', $data);
    }

    public function saveUser()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'group_id' => 'required'
        ];

        if (!$this->validate($rules)) return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $userModel = new UserModel();
        $user = new \Myth\Auth\Entities\User([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'active'   => 1
        ]);
        $user->setPassword($this->request->getPost('password'));
        
        if (!$userModel->save($user)) return redirect()->back()->withInput()->with('errors', $userModel->errors());

        $this->db->table('auth_groups_users')->insert([
            'group_id' => $this->request->getPost('group_id'),
            'user_id'  => $userModel->getInsertID()
        ]);

        return redirect()->to('/admin/user-list')->with('message', 'Akun berhasil didaftarkan!');
    }

    public function deleteUser($id)
    {
        // Cegah Admin menghapus dirinya sendiri (Sangat Berbahaya!)
        if ($id == user_id()) {
            return redirect()->back()->with('error', 'Cari masalah?! Anda tidak bisa menghapus diri Anda sendiri!');
        }

        // Hapus Role & User
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
        $this->db->table('users')->where('id', $id)->delete();

        return redirect()->to('/admin/user-list')->with('message', 'Akun telah terhapus permanen.');
    }
}
