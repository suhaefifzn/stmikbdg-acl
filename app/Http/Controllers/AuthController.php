<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// ? Services
use App\Models\AuthService;
use App\Models\UserService;

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

        // get user profile
        $userService = new UserService();
        $user = $userService->getMyProfile()->getData('data')['data'];
        $userRole = $user['account'];
        $userProfile = $user['profile'];

        // save user data to session, data is array
        Session::put('role', $userRole);
        Session::put('profile', $userProfile);
        Session::put('user_image', Session::get('role')['image']);
        Session::put('user_email', Session::get('role')['email']);

        return redirect()->route('home');
    }

    public function logout() {
        if (Session::exists('token')) {
            Session::remove('token');
            Session::remove('role');
            Session::remove('profile');
            Session::remove('user_image');
            Session::remove('user_email');
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
