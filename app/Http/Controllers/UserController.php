<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\NewAccessToken;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');


       if(!Auth::guard('web')->attempt(['email' => $email, 'password' => $password])){
           return response()->json([
               'message' => 'Неверный логин или пароль',
           ], 401);
       };

       $user = Auth::guard('web')->user();

       $token = $user->createToken('login');

       $user->update(['api_token' => $token->plainTextToken]);

       return ['token'=>$token->plainTextToken];

    }
}
