<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{

    public function user_update(Request $request)
    {
        $user =   user::where('user_id', auth()->guard('api')->user()->user_id)->first();
        if ($request->last_password === null && $request->new_password === null) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:50',
                'email' => 'required|email|max:50',
                'user_bio' => 'string|max:200'
            ]);
            if ($validator->fails()) {
                return $this->errorResponse($validator->messages(), 422);
            }
            user::where('user_id', auth()->guard('api')->user()->user_id)->update([
                'user_email' => $request->email,
                'user_name' => $request->username,
                'user_bio' => $request->bio,
            ]);
            return $this->successResponse('user data updated', 201);
        } else {
            if ($request->new_password === null) {
                return $this->errorResponse('پسورد جدید را وارد کنید', 500);
            } else {
                if ($user->user_password === null) {
                    user::where('user_id', auth()->guard('api')->user()->user_id)->update([
                        'user_email' => $request->email,
                        'user_name' => $request->username,
                        'user_bio' => $request->bio,
                        'user_password' => hash::make($request->new_password),
                    ]);
                } else {
                    if (Hash::check($request->last_password, $user->user_password)) {
                        user::where('user_id', auth()->guard('api')->user()->user_id)->update([
                            'user_email' => $request->email,
                            'user_name' => $request->username,
                            'user_bio' => $request->bio,
                            'user_password' => hash::make($request->new_password),
                        ]);
                        return $this->successResponse('user data updated', 201);
                    } else {
                        return $this->errorResponse('پسورد فعلی اشتباه است', 500);
                    }
                }
            }
        }
    }

    public function rolecheck()
    {
        if (auth()->guard('api')->user()->user_role == 2 or 3) {
            return   [
                'admin' => true,
            ];
        } else {
            return   [
                'admin' => false,
            ];
        }
    }

    public function userinfo()
    {
        $user = user::select('user_id', 'user_name', 'user_email', 'user_bio', 'user_role')->where('user_id', auth()->guard('api')->user()->user_id)->first();
        return $this->successResponse([
            'user' =>  $user,
        ], 201, 'success response');
    }

    public function getusers(Request $request)
    {
        $users = user::where('user_role', 'LIKE', $request->role)
            ->where('user_status', 'LIKE', $request->status)
            ->where('user_email', 'LIKE', "%{$request->search}%")
            ->orderby('created_at', $request->order)
            ->paginate(6);
        return $this->successResponse([
            'users' =>  $users,
        ], 201, 'success response');
    }
    public function update_user_status($id, $status)
    {
        user::where('user_id', $id)->update([
            'user_status' => $status
        ]);
        DB::table('oauth_access_tokens')->where('user_id', $id)->delete();
        return $this->successResponse('user status updated', 201);
    }
    public function delete_user($id)
    {
        user::where('user_id', $id)->delete();
        DB::table('oauth_access_tokens')->where('user_id', $id)->delete();
        return $this->successResponse('user status deleted', 201);
    }
    public function user_by_id($id)
    {
        $user = user::where('user_id', $id)->first();
        return $this->successResponse([
            'user' =>  $user,
        ], 201, 'success response');
    }

    public function user_update_by_id(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'user_bio' => 'string|max:200'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        user::where('user_id', $id)->update([
            'user_name' => $request->username,
            'user_email' => $request->email,
            'user_role' => $request->role,
            'user_status' => $request->status,
            'user_bio' => $request->bio,
        ]);
        return $this->successResponse('user data updated', 201);
    }
}
