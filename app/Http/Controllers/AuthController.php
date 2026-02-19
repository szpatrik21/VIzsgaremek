<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:6',

            // ÚJ MEZŐK
            'phone' => 'required|string|max:20',
            'birthdate' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),

            // ÚJ MEZŐK
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
        ]);

        return response()->json([
            'message' => 'Sikeres regisztráció.'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'error' => 'Hibás felhasználónév vagy jelszó.'
            ], 401);
        }

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function user()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => 'Sikeres kijelentkezés.'
        ]);
    }
}
