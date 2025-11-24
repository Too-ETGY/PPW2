<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user_name = Auth::user()->name;
        $user_role = Auth::user()->role;
        $user_email = Auth::user()->email;

        return view('profile', compact('user_name', 'user_role', "user_email"));
    }
}
