<?php

namespace App\Http\Controllers;

use App\Models\Auto;

class AutoController extends Controller
{
    public function show($id)
    {
        $auto = Auto::findOrFail($id);
        return view('cars.show', compact('auto'));
    }
}

