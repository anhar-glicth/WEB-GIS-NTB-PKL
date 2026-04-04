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
        $data['title'] = 'User List';

        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();

        $data['users'] = $query->getResult();

        return view('admin/index', $data);
    }

    public function detail($id)
    {
        $data['title'] = 'User Detail';

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data);
    }

    public function profile(): string
    {
        $data['title'] = 'My Admin Profile';
        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', user_id());
        $query = $this->builder->get();
        $data['user'] = $query->getRow();

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
            'username' => 'required|min_length[3]|alpha_numeric_space',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UserModel();
        $user = $users->find(user_id());
        
        $user->username = $this->request->getPost('username');
        $user->email = $this->request->getPost('email');

        if ($this->request->getPost('password')) {
            $user->setPassword($this->request->getPost('password'));
        }

        $users->save($user);

        return redirect()->to('/admin/profile')->with('message', 'Profil & Password Admin berhasil diperbarui!');
    }

    /**
     * CMS: PENGATURAN LANDING PAGE
     */
    public function settings()
    {
        $data['title'] = 'Web Site Settings';
        
        $settingsBuilder = $this->db->table('web_settings');
        $data['settings'] = $settingsBuilder->get()->getResultArray();
        
        // Transform to key-value
        $kvSettings = [];
        foreach ($data['settings'] as $s) {
            $kvSettings[$s['setting_key']] = $s['setting_value'];
        }
        $data['kv'] = $kvSettings;

        return view('admin/settings', $data);
    }

    /**
     * UPDATE CMS SETTINGS
     */
    public function updateSettings()
    {
        $settingsBuilder = $this->db->table('web_settings');

        // Update Site Name
        $siteName = $this->request->getPost('site_name');
        if ($siteName) {
            $settingsBuilder->where('setting_key', 'site_name')->update(['setting_value' => $siteName]);
        }

        // Handle Hero Image Upload
        $file = $this->request->getFile('hero_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/web/', $newName);
            
            // Simpan nama file baru ke database
            $settingsBuilder->where('setting_key', 'hero_image')->update(['setting_value' => base_url('uploads/web/' . $newName)]);
        }

        return redirect()->to('/admin/settings')->with('message', 'Pengaturan tampilan berhasil diperbarui!');
    }
}
