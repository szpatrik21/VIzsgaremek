<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = Admin::where('email', $data['email'])->first();

        if (!$admin || !Hash::check($data['password'], $admin->password)) {
            return response()->json([
                'message' => 'Hibás email vagy jelszó.',
            ], 401);
        }

        // Ha Sanctumot használsz:
        $token = $admin->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Sikeres belépés.',
            'token' => $token,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name ?? null,
                'email' => $admin->email,
            ]
        ]);
    }
}