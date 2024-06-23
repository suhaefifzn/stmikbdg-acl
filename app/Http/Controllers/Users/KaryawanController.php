<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index() {
        return view('dashboard.users.karyawan.index', [
            'title' => 'Karyawan'
        ]);
    }
}
