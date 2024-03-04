<?php

namespace App\Models;

use App\Models\MyWebService;

class SiteService extends MyWebService
{
    public function __construct() {
        parent::__construct('sites');
    }

    public function getAllSites() {
        return $this->get();
    }

    public function getUserSites($siteId) {
        $query = "?site_id=$siteId";

        return $this->get(null, $query);
    }

    public function addNewSite($siteUrl) {
        $payload = [
            'url' => $siteUrl,
        ];

        return $this->post($payload);
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
