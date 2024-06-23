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

    public function updatePasswordAccount(Request $request) {
        $request->validate([
            'password_sekarang' => 'required',
            'password_baru' => 'required|min:8|max:64|regex:/^\S*$/u',
            'konfirmasi_password_baru' => 'required|same:password_baru',
        ]);

        $response = $this->service->updateMyPassword($request->password_sekarang, $request->password_baru);

        return $response;
    }

    /**
     * belum diperbaiki
     */
    public function addUserFromExcel(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:2048'
        ]);

        $response = $this->service->importUsersFromExcel($request->file('file'));

        return $response;
    }
}
