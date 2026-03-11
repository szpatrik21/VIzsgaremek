<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auto;
use App\Models\Admin;

class AdminController extends Controller
{
    public function stats()
    {
        return response()->json([
            'usersCount' => User::count(),
            'carsCount' => Auto::count(),
            'availableCars' => Auto::count(),
            'adminsCount' => Admin::count(),
        ]);
    }
}