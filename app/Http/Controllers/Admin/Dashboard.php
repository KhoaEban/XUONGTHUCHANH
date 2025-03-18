<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}
