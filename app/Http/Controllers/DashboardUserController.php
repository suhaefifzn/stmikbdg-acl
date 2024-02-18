<?php

namespace App\Http\Controllers;

// * Service
use App\Models\SiteService;
use App\Models\UserService;

use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    protected $siteService;
    protected $userService;

    public function __construct() {
        $this->siteService = new SiteService();
        $this->userService = new UserService();
    }

    public function index() {
        $sites = $this->siteService->getAllSites()->getData('data');
        $users = $this->userService->getAllUsers()->getData('data');

        return view('dashboard.index', [
            'sites' => $sites['data']['sites'],
            'users' => $users['data']['users'],
        ]);
    }

    public function getUserBySiteId(Request $request) {
        $siteId = $request->query('site_id');

        if (!$siteId) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Nilai query site_id pada url diperlukan'
            ], 400);
        }

        return $this->siteService->getUserSites($siteId);
    }

    public function addUserSiteAccess(Request $request) {
        if (!$request->user_id or !$request->site_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Nilai payload user_id dan site_id diperlukan'
            ], 400);
        }

        return $this->siteService->addUserSiteAccess($request->user_id, $request->site_id);
    }
}
