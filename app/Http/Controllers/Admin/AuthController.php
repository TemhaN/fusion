<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        
        if (Auth::guard('admin')->check()) {
            return redirect()->intended(route('index'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('login');
    }

    public function createAdmin(Request $request)
    {
        $admin = Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'img_link'=> $request->img_link,
        ]);

        return redirect()->back()->with('message', 'Админ успешно создан!');
    }

    public function showAdmins() {
        
        $admins = Admin::all();
        
        return view('admin.index', compact('admins'));
    }

    public function getLoggedInAdmin()
    
    {
        $admin = Auth::guard('admin')->user();
        
        return view('admin.profile', ['admin' => $admin], compact('admin'));
    }

        public function updateAdmin(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:5'],
			'img_link'=>['string'],
        ]);

        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->img_link = $request->img_link;

        $admin->update([
            'password' => bcrypt($request->password),
        ]);


        Auth::guard('admin')->login($admin);

        return redirect()->back();
    }

}

