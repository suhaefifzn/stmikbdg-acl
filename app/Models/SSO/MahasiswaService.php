<?php

namespace App\Models\SSO;

use App\Models\MyWebService;

class MahasiswaService extends MyWebService
{
    public function __construct()
    {
        parent::__construct('sso/mahasiswa');
    }

    public function getList() {
        return $this->get(null, '/list');
    }

    public function getDetail(int $id) {
        return $this->get(null, ('/detail?user_id=' . $id));
    }

    public function add(array $payload) {
        return $this->post($payload, '/add');
    }

    public function edit(array $payload) {
        return $this->put($payload, '/update');
    }

    public function deleteById(int $id) {
        return $this->delete([
            'user_id' => $id
        ], '/delete');
    }
}
