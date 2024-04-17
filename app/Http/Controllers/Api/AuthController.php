<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signup(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        auth()->attempt(['email' => $data['email'], 'password' => $data['password']]);

        $token = auth()->user()->createToken($data['email']);

        return response([
            'status' => 'success',
            'token' => $token->plainTextToken,
            'id' => $user->id,
            'fio' => $user->fio
        ]);
    }
    public function signin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!auth()->attempt($credentials)) {

            return response([
                'status' => 'invalid',
                'message' => 'Wrong email or password',
            ], 401);
        }

        $token = auth()->user()->createToken($credentials['email']);

        return response([
            'status' => 'success',
            'token' => $token->plainTextToken,
            'id' => auth()->user()->id,
            'fio' => auth()->user()->fio,
        ]);
    }
    public function signout (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response(['status' => 'success']);
    }


}
