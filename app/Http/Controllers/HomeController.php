<?php

namespace App\Http\Controllers;

use App\Models\Auto;

class HomeController extends Controller
{
    public function index()
    {
        $autok = Auto::where('raktaron', '>', 0)
            ->orderByDesc('kiemelt')
            ->latest()
            ->take(4)
            ->get();

        return view('main_page', compact('autok'));
    }
}
