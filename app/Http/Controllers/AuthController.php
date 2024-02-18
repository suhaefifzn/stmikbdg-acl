<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ? Services
use App\Models\AuthService;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $service;

    public function __construct() {
        $this->service = new AuthService();
    }

    public function checkToken(Request $request) {
        $token = $request->query('token');

        if (!$token) {
            return self::redirectToLogin();
        }

        $checkToken = $this->service->checkToken($token);

        if ($checkToken->getData('data')['status'] !== 'success') {
            return redirect()->route('logout');
        }

        // save token to session
        Session::put('token', $token);

        return redirect()->route('home');
    }

    public function logout() {
        if (Session::exists('token')) {
            Session::remove('token');
        } else {
            return self::redirectToLogin();
        }

        return self::redirectToLogout();
    }

    private function redirectToLogin() {
        return redirect()->away(
            config('myconfig.login.base_url') . 'login?site=' . config('app.url')
        );
    }

    private function redirectToLogout() {
        return redirect()->away(
            config('myconfig.login.base_url') . 'logout?site=' .  config('app.url')
        );
    }
}
