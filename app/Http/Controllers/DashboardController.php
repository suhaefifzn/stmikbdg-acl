<?php

namespace App\Http\Controllers;

// * Service
use App\Models\SiteService;
use App\Models\UserService;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $siteService;
    protected $userService;

    public function __construct() {
        $this->siteService = new SiteService();
        $this->userService = new UserService();
    }

    public function index() {
        return view('dashboard.main', [
            'title' => 'Home'
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

    public function userAccess() {
        $sites = $this->siteService->getAllSites()->getData('data')['data']['sites'];
        $users = $this->userService->getAllUsers()->getData('data')['data']['users'];

        return view('dashboard.user-access.index', [
            'title' => 'Manage User Access',
            'sites' => $sites,
            'users' => $users,
        ]);
    }
}
