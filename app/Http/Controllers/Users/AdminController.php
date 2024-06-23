<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\SSO\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }
    public function index() {
        $listAdmin = $this->adminService->getList()->getData('data')['data']['list_admin'];
        $listSite = $this->adminService->getSites()->getData('data')['data']['list_sites'];

        return view('dashboard.users.admin.index', [
            'title' => 'Admin',
            'data' => [
                'list_admin' => $listAdmin,
                'list_site' => $listSite
            ]
        ]);
    }

    public function add(Request $request) {
        $data = [
            'kd_user' => $request->kd_user,
            'site_id' => $request->site_id,
            'email' => $request->email,
            'password' => $request->password
        ];

        $response = $this->adminService->add($data);

        return $response;
    }

    public function detail(Request $request) {
        $userId = $request->query('user_id');
        $response = $this->adminService->getDetail((int) $userId);
        return $response;
    }

    public function delete(Request $request) {
        $response = $this->adminService->deleteById((int) $request->user_id);
        return $response;
    }

    public function update(Request $request) {
        $data = [
            'site_id' => $request->site_id,
            'user_id' => $request->user_id,
            'kd_user' => $request->kd_user,
            'email' => $request->email
        ];

        $response = $this->adminService->update($data);

        return $response;
    }
}
