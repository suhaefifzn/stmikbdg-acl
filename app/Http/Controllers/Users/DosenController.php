<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\SSO\DosenService;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new DosenService();
    }

    public function index() {
        $listDosen = $this->service->getList()->getData('data')['data']['list_dosen'];

        return view('dashboard.users.dosen.index', [
            'title' => 'Dosen',
            'data' => [
                'list_dosen' => $listDosen
            ]
        ]);
    }

    public function detail(Request $request) {
        $userId = $request->query('user_id');
        $response = $this->service->getDetail((int) $userId);
        return $response;
    }

    public function add(Request $request) {
        $data = $request->all();
        unset($data['_token']);
        $response = $this->service->add($data);
        return $response;
    }

    public function update(Request $request) {
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        $response = $this->service->update($data);
        return $response;
    }

    public function delete(Request $request) {
        $userId = $request->user_id;
        $response = $this->service->deleteById((int) $userId);
        return $response;
    }
}
