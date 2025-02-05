<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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
}
