<?php

namespace App\Http\Controllers;

use App\Models\Auto;

class AutoController extends Controller
{
    public function index()
    {
        // ha csak kiemelteket akarsz:
        // $autok = Auto::where('kiemelt', 1)->get();

        $autok = Auto::all();
        return view('autok', compact('autok')); // autok.blade.php
    }

    public function show($id)
    {
        $auto = Auto::findOrFail($id);
        return view('cars.show', compact('auto'));
    }
}
