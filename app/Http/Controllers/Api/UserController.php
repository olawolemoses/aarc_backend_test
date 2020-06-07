<?php

namespace App\Http\Controllers\Api;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        $credentials = [
            'email' => request('email'), 
            'password' => request('password')
        ];

        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('MyApp')->accessToken;

            return response()->json(['status' => true, 'token' => $token, 'user' => Auth::user()]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $token = $user->createToken('MyApp')->accessToken;
        return response()->json(['status' => true, 'token' => $token, 'user' => $user]);
    }

    public function getDetails()
    {
        return response()->json(['success' => Auth::user()]);
    }
}