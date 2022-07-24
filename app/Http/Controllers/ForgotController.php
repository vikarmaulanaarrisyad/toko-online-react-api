<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Mail\ForgotMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotController extends Controller
{
    public function forgotPassword(ForgotRequest $request)
    {
        $email  =   $request->email;
        $user   = User::where('email', $email)->doesntExist();

        if ($user) {
            return response([
                'message'   =>  'Email Not Found'
            ], 404);
        }

        // Generate random token
        $token = rand(10, 1000000);


        try {
            DB::table('password_resets')->insert([
                'email' =>  $email,
                'token' =>  $token
            ]);

            // mail send to user
            Mail::to($email)->send(new ForgotMail($token));

            return response([
                'message'   =>  'Reset password main send on your email!'
            ], 200);
        } catch (\Throwable $th) {
            return response([
                'message'   =>  $th->getMessage()
            ], 400);
        }
    }
}
