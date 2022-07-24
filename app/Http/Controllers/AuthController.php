<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
