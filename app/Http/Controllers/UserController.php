<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ? Web service
use App\Models\UserService;

class UserController extends Controller {
    protected $service;

    public function __construct() {
        $this->service = new UserService();
    }

    public function updateEmailAccount(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);
        $response = $this->service->updateMyEmail($request->email);

        return $response;
    }

    public function updatePasswordAccount(Request $request) {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8|max:64|regex:/^\S*$/u',
            're_enter_new_password' => 'required|same:new_password',
        ]);

        $response = $this->service->updateMyPassword($request->password, $request->new_password);

        return $response;
    }

    public function addUser(Request $request) {
        $payload = [
            'kd_user' => $request->kd_user,
            'email' => $request->email,
            'password' => $request->password,
            'is_mhs' => filter_var($request->is_mhs, FILTER_VALIDATE_BOOLEAN),
            'is_dosen' => filter_var($request->is_dosen, FILTER_VALIDATE_BOOLEAN),
            'is_doswal' => filter_var($request->is_doswal, FILTER_VALIDATE_BOOLEAN),
            'is_prodi' => filter_var($request->is_prodi, FILTER_VALIDATE_BOOLEAN),
            'is_admin' => filter_var($request->is_admin, FILTER_VALIDATE_BOOLEAN),
            'is_developer' => filter_var($request->is_developer, FILTER_VALIDATE_BOOLEAN)
        ];
        $response = $this->service->addNewUser($payload);

        return $response;
    }

    public function addUserFromExcel(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:2048'
        ]);

        $response = $this->service->importUsersFromExcel($request->file('file'));

        return $response;
    }
}
