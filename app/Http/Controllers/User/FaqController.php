<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        return view('user.faq');
    }

}