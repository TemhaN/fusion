<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function countUsers()
    {
        $usersCount = User::count();

        return view('/', compact('usersCount'));
    }

}
