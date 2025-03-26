<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Dashboard extends Controller
{
    public function index()
    {
        // Logic for admin dashboard page
        if (Auth::user()->role != 'admin') {
            return redirect()->route('home');
        }
        return view('admin.dashboard'); 
    }
}
