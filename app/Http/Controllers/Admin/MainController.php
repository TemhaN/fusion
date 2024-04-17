<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $usersCount = User::count();

        return view('index', compact('usersCount'));
        // return view('/index');
    }
}
