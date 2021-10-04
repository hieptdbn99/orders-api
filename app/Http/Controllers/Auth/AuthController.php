<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!$token = JWTAuth::attempt($request->only(['email', 'password'])))
        {
            return response()->json([
                'errors' => [
                    'email' => ['There is something wrong! We could not verify details']
                ]], 422);
        }

        return (new UserResource($request->user()))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
                ]);
    }
    public function register(Request $request)
    {
        // validate dữ liệu
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // sau khi lưu dữ liệu user mới vào CSDL, tiến hành đăng nhập luôn rồi trả về token đăng nhập
        if(!$token = JWTAuth::attempt($request->only(['email', 'password'])))
        {
            return abort(401);
        }
        return (new UserResource($user))
            ->additional([
                'meta' => [
                    'token' => $token
                ]
            ]);
    }
    public function user()
    {
        return [
            'data' => JWTAuth::parseToken()->authenticate()
        ];
    }
}
