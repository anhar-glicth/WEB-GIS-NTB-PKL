<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Myth\Auth\Exceptions\PermissionException;
use Myth\Auth\Filters\RoleFilter as BaseRoleFilter;

class RoleFilter extends BaseRoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $this->authenticate = service('authentication');
        $this->authorize     = service('authorization');

        if (! $this->authenticate->check()) {
            session()->set('redirect_url', current_url());
            return redirect()->to('/login')->with('error', lang('Auth.notLoggedIn'));
        }

        $userId = $this->authenticate->id();
        $role   = is_array($arguments) ? $arguments[0] : $arguments;

        if (! $this->authorize->inGroup($role, $userId)) {
            return redirect()->to('/')->with('error', 'Anda tidak punya akses.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu apa-apa di sini
    }
}
