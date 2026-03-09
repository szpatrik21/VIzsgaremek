<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auto;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function featured()
    {
        $cars = Auto::query()
            ->where('kiemelt', 1)         // vagy featured=1
            ->orderByDesc('id')
            ->take(8)
            ->get([
                'id','marka','modell','teljesitmeny','uzemanyag','ar','kep'
            ])
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'marka' => $a->marka,
                    'modell' => $a->modell,
                    'teljesitmeny' => $a->teljesitmeny,
                    'uzemanyag' => $a->uzemanyag,
                    'ar' => $a->ar,
                    'kep' => $a->kep ? asset($a->kep) : null, // ha DB-ben útvonal van
                    'url' => "/autok/{$a->id}",
                ];
            });

        return response()->json($cars);
    }
}