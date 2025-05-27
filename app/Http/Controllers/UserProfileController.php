<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('userprofile', ['user' => Auth::user()]);
    }
}