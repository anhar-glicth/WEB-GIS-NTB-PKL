<?php

namespace App\Controllers;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\GroupModel;

class Admin extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Admin Dashboard';

        $db = \Config\Database::connect();
       $builder = $db->table('users');
$builder->select('users.id as userid, users.username, users.email, auth_groups.name as role');
$builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
$builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
$builder->groupBy('users.id');

        $query = $builder->get();
        $data['users'] = $query->getResult();

        return view('admin/index', $data);
    }
    public function detail($id): string
{
    $data['title'] = 'Detail User';

    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->select('users.id as userid, users.username, users.email, auth_groups.name as role');
    $builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
    $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
    $builder->where('users.id', $id); // Gunakan $id dari URL

    $query = $builder->get();
    $data['user'] = $query->getRow();

    if (!$data['user']) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User dengan ID $id tidak ditemukan.");
    }

    return view('admin/detail', $data);
}
public function profile(): string
{
    $data['title'] = 'My Profile';

    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->select('users.id as userid, users.username, users.email, auth_groups.name as role');
    $builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
    $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
    $builder->where('users.id', user_id()); // ambil user yang sedang login

    $query = $builder->get();
    $data['user'] = $query->getRow();

    return view('admin/profile', $data);
}
public function editProfile(): string
{
    $data['title'] = 'Edit Profile';

    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->where('id', user_id());
    $data['user'] = $builder->get()->getRow();

    return view('admin/edit_profile', $data);
}

public function updateProfile()
{
    $validation = \Config\Services::validation();

    $rules = [
        'username' => 'required|min_length[3]',
        'email'    => 'required|valid_email'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $userModel = new \Myth\Auth\Models\UserModel();

    $userModel->update(user_id(), [
        'username' => $this->request->getPost('username'),
        'email'    => $this->request->getPost('email')
    ]);

    return redirect()->to('/admin')->with('message', 'User berhasil ditambahkan!');

}
public function createUser()
{
    return view('admin/create_user');
}

public function saveUser()
{
    $users = new \Myth\Auth\Models\UserModel();

    $user = new \Myth\Auth\Entities\User([
        'email'    => $this->request->getPost('email'),
        'username' => $this->request->getPost('username'),
        'password' => $this->request->getPost('password'),
        'active'   => 1,
    ]);

    // Simpan user dan pastikan berhasil
    if (!$users->save($user)) {
        return redirect()->back()->with('error', 'Gagal menyimpan user.');
    }

    // Ambil ID user yang baru disimpan
    $userId = $users->getInsertID();

    // Ambil nama role dari form
    $role = $this->request->getPost('role');

    // Cari data grup berdasarkan nama role
    $groupModel = new \Myth\Auth\Models\GroupModel();
    $group = $groupModel->where('name', $role)->first();

    if (!$group) {
        return redirect()->back()->with('error', 'Role tidak valid');
    }

    // Tambahkan user ke grup
    $groupModel->addUserToGroup($userId, $group->id);

    return redirect()->to('admin/user-list')->with('message', 'User berhasil ditambahkan!');
}


public function userList()
{
    $data['title'] = 'User List';

    $db = \Config\Database::connect();
    $builder = $db->table('users');
    $builder->select('users.id as userid, users.username, users.email, auth_groups.name as role');
    $builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
    $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
    $builder->groupBy('users.id');

    $query = $builder->get();
    $data['users'] = $query->getResult();
    

    return view('admin/index', $data);
}


}
