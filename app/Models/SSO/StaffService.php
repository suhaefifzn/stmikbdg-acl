<?php

namespace App\Models\SSO;

use App\Models\MyWebService;

class StaffService extends MyWebService
{
    public function __construct()
    {
        parent::__construct('sso/staff');
    }

    public function getList() {
        return $this->get(null, '/list');
    }

    public function getDetail(int $id) {
        return $this->get(null, ('/detail?staff_id=' . $id));
    }

    public function add(array $payload) {
        return $this->post($payload, '/add');
    }

    public function update(array $payload) {
        return $this->put($payload, '/update');
    }

    public function deleteById(int $id) {
        return $this->delete([
            'staff_id' => $id,
        ], '/delete');
    }
}
