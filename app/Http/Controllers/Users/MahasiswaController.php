<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// * Service
use App\Models\SSO\MahasiswaService;

class MahasiswaController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new MahasiswaService();
    }

    public function index() {
        $listMahasiswa = $this->service->getList()->getData('data')['data']['list_mahasiswa'];;

        return view('dashboard.users.mahasiswa.index', [
            'title' => 'Mahasiswa',
            'data' => [
                'list_mahasiswa' => $listMahasiswa
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
        $response = $this->service->edit($data);
        return $response;
    }

    public function delete(Request $request) {
        $response = $this->service->deleteById((int) $request->user_id);
        return $response;
    }
}
