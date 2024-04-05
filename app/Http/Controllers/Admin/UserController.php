<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Gender;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $users = User::whereNull('deleted_at')->get();
        $genders = Gender::all();
        
        $deletedUsers = User::onlyTrashed()->get();
        return view('admins.users.index', compact('users', 'deletedUsers', 'genders'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $users = User::all();
        
        $genders = Gender::findOrFail($id);


        return view('admins.users.create', compact('users', 'user', 'genders')); 
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $genders = Gender::all();
        $request->validate([
            'fio' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'required|min:5',
            'birthday' => 'nullable|date',
            'gender_id' => 'nullable|integer',
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->fio = $request->fio;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->birthday = $request->birthday;
        $user->gender_id = $request->gender_id;

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fio' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'birthday' => 'nullable|date',
            'gender_id' => 'integer',
        ]);

        $user = new User;
        $user->fio = $request->fio;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->birthday = $request->birthday;
        $user->gender_id = $request->gender_id;

        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function adminban(User $user)
    {
        $user->delete();

        return back();
    }


    public function adminrestore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();

        return redirect('/admin/users');
    }
}
