<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::select([
            'id',
            'profile_image',
            'username',
            'first_name',
            'last_name',
            'email',
            'phone',
            'birthdate',
            'address',
            'role',
            'created_at'
        ])
        ->orderBy('id', 'desc')
        ->get();

        return response()->json($users);
    }
}