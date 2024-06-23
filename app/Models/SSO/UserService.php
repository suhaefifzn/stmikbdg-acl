<?php

namespace App\Models\SSO;

use App\Models\MyWebService;

class UserService extends MyWebService
{
    public function __construct()
    {
        parent::__construct('sso');
    }

    public function getStatistik() {
        return $this->get(null, '/users/statistik');
    }
}
