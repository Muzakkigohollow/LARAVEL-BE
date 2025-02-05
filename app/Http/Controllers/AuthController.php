<?php

namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function profile(request $request){
        return Auth::user();
    }


    function register(request $request){
        $request->validate([
            'name' => 'required|string|min:2|max:58',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            return response([
                "message" => 'User registered successfully'
            ], 201);
    }

    function login(request $request){
        $request->validate([
            'email' =>'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::whereEmail($request->email)->first();

        if(!$user ||!Hash::check($request->password, $user->password)){
            return response([
                "message" => 'Invalid pass'
            ], 401);
        }

        $token = $user->createToken($user->name . '_AuthToken')->plainTextToken;

        return response([
            "message" => 'Logged in successfully',
            "access_token" => $token,

        ],201);
    }
}
