<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ? Web service
use App\Models\UserService;

class UserController extends Controller
{
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
}
