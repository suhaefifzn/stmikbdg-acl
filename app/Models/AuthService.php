<?php

namespace App\Models;

use App\Models\MyWebService;

class AuthService extends MyWebService
{
    public function __construct() {
        parent::__construct('authentications');
    }

    public function validateUserSiteAccess($siteURL) {
        $query = "/check/site?url=$siteURL";

        return $this->get(null, $query);
    }

    public function checkToken($token) {
        $payload = [
            'token' => $token,
        ];

        return $this->get($payload, '/check');
    }
}
