<?php

namespace App\Http\Controllers;

// * Service
use App\Models\UserService;
use App\Models\SSO\UserService as SSOUserService;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userService;
    protected $ssoUserService;

    public function __construct() {
        $this->userService = new UserService();
        $this->ssoUserService = new SSOUserService();
    }

    public function index() {
        $userStatistik = $this->ssoUserService->getStatistik()->getData('data')['data'];

        return view('dashboard.home', [
            'title' => 'Home',
            'data' => $userStatistik
        ]);
    }

    public function account() {
        return view('dashboard.account.index', [
            'title' => 'Account'
        ]);
    }

    public function users() {
        $users = $this->userService->getAllUsers()->getData('data')['data']['users'];

        return view('dashboard.users.index', [
            'title' => 'Manage Users',
            'users' => $users,
        ]);
    }
}
