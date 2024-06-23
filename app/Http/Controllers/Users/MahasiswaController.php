<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index() {
        return view('dashboard.users.mahasiswa.index', [
            'title' => 'Mahasiswa'
        ]);
    }
}
