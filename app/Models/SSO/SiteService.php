<?php

namespace App\Models\SSO;

use App\Models\MyWebService;

class SiteService extends MyWebService
{
    public function __construct() {
        parent::__construct('sso/sites');
    }

    public function getAllSites() {
        return $this->get(null, '/list');
    }

    public function getUserSites($siteId) {
        $query = "/list?site_id=$siteId";

        return $this->get(null, $query);
    }

    public function addNewSite(array $payload) {
        return $this->post($payload, '/add');
    }

    public function addUserSiteAccess($userId, $siteId) {
        $payload = [
            'user_id' => $userId,
            'site_id' => $siteId,
        ];

        return $this->post($payload, '/user-access');
    }

    public function deleteAccessUser($userId, $siteId) {
        $payload = [
            'user_id' => $userId,
            'site_id' => $siteId,
        ];

        return $this->delete($payload, '/user-access');
    }

    public function importUserAccessFromExcel($filePath) {
        return $this->postFile($filePath, '/user-access?import=excel');
    }
}
