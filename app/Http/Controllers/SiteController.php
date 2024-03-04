<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ? Web Service
use App\Models\SiteService;

class SiteController extends Controller
{
    protected $service;

    public function __construct() {
        $this->service = new SiteService();
    }

    public function deleteUserSiteAccess(Request $request) {
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

        $response = $this->service->addNewSite($request->url);

        return $response;
    }
}
