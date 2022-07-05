<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Cookie;
use Illuminate\Support\Facades\DB;

class AuthController extends ApiController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users,user_email|max:50',
            'password' => 'required|string|max:50|min:8'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $user = user::create([
            'user_name' => $request->username,
            'user_email' => $request->email,
            'user_password' => hash::make($request->password),
            'user_status' => 1,
            'user_role' => 1,
        ]);
        $token = $user->createToken('myApp')->accessToken;
        return $this->successResponse([
            'token' => $token
        ], 200);
    }

    public function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $user = User::where('user_email', $request->email)->first();
        if ($user->user_status == 1) {
            if (!$user) {
                return $this->errorResponse('کاربری با این مشخصات یافت نشد', 401);
            }
            if (!Hash::check($request->password, $user->user_password)) {
                return $this->errorResponse('رمز عبور اشتباه است', 401);
            }
            $token = $user->createToken('myApp')->accessToken;
            return $this->successResponse([
                'token' => $token
            ], 200);
        } else {
            return $this->errorResponse('حساب کاربری شما غیرفعال است', 401);
        }
    }

    public function  logout()
    {
        auth()->guard('api')->user()->tokens()->delete();
        return $this->successResponse('logged out', 200);
    }


    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_back()
    {
        $google = Socialite::driver('google')->user();
        $user = user::where('user_email', $google->email)->orwhere('user_google', $google->token)->first();
        if ($user == null) {
            $create = user::create([
                'user_google' =>  $google->token,
                'user_name' =>  $google->name,
                'user_email' =>  $google->email,
                'user_status' =>  1,
                'user_role' =>  1,
            ]);
            $token = $create->createToken('myApp')->accessToken;
            Cookie::queue('user_token',  $token, 10080, null, null, false, false);
            return redirect('/');
        } else {
            if ($user->user_google == null) {
                user::where('user_email', $google->email)->update([
                    'user_google' =>  $google->token,
                ]);
            } else {
                if ($user->user_status == 1) {
                    $token = $user->createToken('myApp')->accessToken;
                    Cookie::queue('user_token',  $token, 10080, null, null, false, false);
                    return redirect('/');
                } else {
                    return redirect('/login?status=ban');
                }
            }
        }
    }


    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    public function github_back()
    {
        $github = Socialite::driver('github')->user();
        $user = user::where('user_email', $github->email)->orwhere('user_github', $github->token)->first();
        if ($user == null) {
            $create = user::create([
                'user_github' =>  $github->token,
                'user_name' =>  $github->name,
                'user_email' =>  $github->email,
                'user_status' =>  1,
                'user_role' =>  1,
            ]);
            $token = $create->createToken('myApp')->accessToken;
            Cookie::queue('user_token',  $token, 10080, null, null, false, false);
            return redirect('/');
        } else {
            if ($user->user_github == null) {
                user::where('user_email', $github->email)->update([
                    'user_github' =>  $github->token,
                ]);
            } else {
                if ($user->user_status == 1) {
                    $token = $user->createToken('myApp')->accessToken;
                    Cookie::queue('user_token',  $token, 10080, null, null, false, false);
                    return redirect('/');
                } else {
                    return redirect('/login?status=ban');
                }
            }
        }
    }
}
