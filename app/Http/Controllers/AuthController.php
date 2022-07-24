<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
                    if (Auth::attempt($request->only('email','password'))) {
            $user   = Auth::user();
            $token  = $user->createToken('app')->accessToken;

            return response([
                'message'   =>  'SuccessFully Login',
                'token'     =>  $token,
                'user'      =>  $user
            ], 400);
        }
        } catch (\Throwable $th) {
            return response([
                'message'   => $th->getMessage()
            ],400);
        }

        return response([
            'message'   =>  'Invalid Email Or Password'
        ],401);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user =  User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token  = $user->createToken('app')->accessToken;

            return response([
                'message'   =>  'SuccessFully Registration',
                'token'     =>  $token,
                'user'      =>  $user
            ],400);
        } catch (\Throwable $th) {
            return response([
                'message'   =>  'SuccessFully Registration',
                'token'     =>  $token,
                'user'      =>  $user
            ],401);
        }

    }
}
