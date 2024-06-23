<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ? Web Service
use App\Models\SSO\SiteService;
use App\Models\UserService;

class SiteController extends Controller
{
    protected $service;
    protected $userService;

    public function __construct() {
        $this->service = new SiteService();
        $this->userService = new UserService();
    }

    public function index() {
        $listSite = $this->service->getAllSites()->getData('data')['data']['sites'];
        $listUser = $this->userService->getAllUsers()->getData('data')['data']['users'];

        return view('dashboard.accesses.index', [
            'title' => 'Accesses',
            'data' => [
                'list_site' => $listSite,
                'list_user' => $listUser
            ]
        ]);
    }

    public function renderTable(Request $request) {
        $siteId = $request->query('site_id');
        $siteAccess = $this->service->getUserSites((int) $siteId)->getData('data')['data'];

        // check role site
        $filteredRoleSite = collect($siteAccess['site_detail'])->filter(function ($item) {
            if (is_bool($item)) {
                return $item;
            }
        });

        $tempRoleSite = [];

        foreach ($filteredRoleSite as $key => $value) {
            if ($value) {
                switch ($key) {
                    case 'is_admin':
                        array_push($tempRoleSite, 'Admin');
                        break;
                    case 'is_dosen':
                        array_push($tempRoleSite, 'Dosen');
                        break;
                    case 'is_doswal':
                        array_push($tempRoleSite, 'Dosen Wali');
                        break;
                    case 'is_prodi':
                        array_push($tempRoleSite, 'Prodi');
                        break;
                    case 'is_wk':
                        array_push($tempRoleSite, 'Wakil Ketua');
                        break;
                    case 'is_staff':
                        array_push($tempRoleSite, 'Staff');
                        break;
                    case 'is_secretary':
                        array_push($tempRoleSite, 'Sekretaris');
                        break;
                    case 'is_dev':
                        array_push($tempRoleSite, 'Developer');
                        break;
                    case 'is_mhs':
                        array_push($tempRoleSite, 'Mahasiswa');
                        break;
                    default:
                        array_push($tempRoleSite, '');
                        break;
                }
            }
        }

        $renderedView = view('dashboard.accesses.table', [
            'data' => [
                'site_role' => implode(', ', $tempRoleSite),
                'site_detail' => $siteAccess['site_detail'],
                'user_accesses' => $siteAccess['site_users']
            ]
        ])->render();

        return response()->json([
            'content' => $renderedView
        ]);
    }

    public function deleteAccess(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'site_id' => 'required',
        ]);

        $response = $this->service->deleteAccessUser($request->user_id, $request->site_id);

        return $response;
    }

    public function getUserBySiteId(Request $request) {
        $siteId = $request->query('site_id');

        if (!$siteId) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Nilai query site_id pada url diperlukan'
            ], 400);
        }

        return $this->service->getUserSites($siteId);
    }

    public function addUserSiteAccess(Request $request) {
        if (!$request->user_id or !$request->site_id) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Pastikan alamat web dan user telah dipilih'
            ], 400);
        }

        return $this->service->addUserSiteAccess($request->user_id, $request->site_id);
    }

    /**
     * belum diperbaiki
     */
    public function addUserAccessFromExcel(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv|max:2048'
        ]);

        $response = $this->service->importUserAccessFromExcel($request->file('file'));

        return $response;
    }

    public function addSite(Request $request) {
        $request->validate([
            'url' => 'required|string|regex:/^\S*$/u'
        ]);
        $isValidURL = filter_var($request->url, FILTER_VALIDATE_URL);

        if (!$isValidURL) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Format url tidak valid'
            ], 422);
        }

        $data = $request->all();
        unset($data['_token']);

        $response = $this->service->addNewSite($data);

        return $response;
    }
}
