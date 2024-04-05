<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Easter_EggController extends Controller
{
    public function index()  
    {
        return view('admins.easter_egg.index');
    }
}
