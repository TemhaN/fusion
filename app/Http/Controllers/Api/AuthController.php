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
}