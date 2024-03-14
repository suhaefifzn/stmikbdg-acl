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

    public function getMyProfile() {
        return $this->get(null, '/me');
    }

    public function updateMyEmail($newEmail) {
        $payload = [
            'email' => $newEmail,
        ];

        return $this->put($payload, '/me');
    }

    public function updateMyPassword($currentPassword, $newPassword) {
        $payload = [
            'current_password' => $currentPassword,
            'new_password' => $newPassword,
        ];

        return $this->put($payload, '/me/password');
    }

    public function addNewUser($payload) {
        return $this->post($payload);
    }

    public function importUsersFromExcel($filePath) {
        return $this->postFile($filePath, '?import=excel');
    }

    public function deleteUserByUserId($userId) {
        return $this->delete(null, "/$userId");
    }
}
