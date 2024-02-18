<?php

namespace App\Models;

use App\Models\MyWebService;

class UserService extends MyWebService
{
    public function __construct() {
        parent::__construct('users');
    }

    public function getAllUsers() {
        $query = '?is_dosen=false&is_admin=false';

        return $this->get(null, $query);
    }
}
