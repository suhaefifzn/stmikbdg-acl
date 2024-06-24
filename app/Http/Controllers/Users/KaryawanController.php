<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// * Service
use App\Models\SSO\StaffService;

class KaryawanController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new StaffService();
    }

    public function index() {
        $listStaff = $this->service->getList()->getData('data')['data']['list_staff'];

        return view('dashboard.users.karyawan.index', [
            'title' => 'Karyawan',
            'data' => [
                'list_staff' => $listStaff
            ]
        ]);
    }

    public function detail(Request $request) {
        $staffId = $request->query('staff_id');
        $response = $this->service->getDetail((int) $staffId);
        return $response;
    }

    public function update(Request $request) {
        $data = $request->all();
        unset($data['_token']);
        unset($data['_method']);
        $response = $this->service->update($data);
        return $response;
    }

    public function add(Request $request) {
        $data = $request->all();
        unset($data['_token']);
        $response = $this->service->add($data);
        return $response;
    }

    public function delete(Request $request) {
        $staffId = $request->staff_id;
        $response = $this->service->deleteById((int) $staffId);
        return $response;
    }
}
