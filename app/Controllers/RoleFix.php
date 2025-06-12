<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RoleFix extends BaseController
{
    public function index()
    {
        $auth = service('authorization');
        $userId = user_id(); // atau bisa gunakan ID spesifik, misalnya: 1

        // Assign role 'user' jika belum punya
        if (! in_groups('user')) {
            $auth->addUserToGroup($userId, 'user');
            return 'Role "user" berhasil ditambahkan ke user ID: ' . $userId;
        }

        return 'User sudah memiliki role "user".';
    }
}
