<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'reqired|max:255',
            'email' => 'reqired|email|unique:users',
            'password' => 'reqired|confirmed'

        ]);

        $user = User::create($fields);
        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];

    }


    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'reqired|email|exisits:users',
            'password' => 'reqired'

        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::chack($request->password, 
        $user->password)){
            return [
                'message' => 'The provided credentials are inccorect.'
            ];
        }

        $token = $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];

    }






    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return [
            'message' => 'you are logged out.'
        ];

    }
}
