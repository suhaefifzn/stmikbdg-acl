<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index() {
        return view('dashboard.users.dosen.index', [
            'title' => 'Dosen'
        ]);
    }
}
