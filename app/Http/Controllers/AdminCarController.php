<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use Illuminate\Http\Request;

class AdminCarController extends Controller
{
    /**
     * Összes autó listázása + filterek
     */
    public function apiIndex(Request $request)
    {
        $query = Auto::query()->where('raktaron', '>', 0);

        if ($request->filled('marka')) {
            $query->where('marka', $request->marka);
        }

        if ($request->filled('allapot')) {
            $query->where('allapot', $request->allapot);
        }

        if ($request->filled('kivitel')) {
            $query->where('kivitel', $request->kivitel);
        }

        if ($request->filled('szin')) {
            $query->where('szin', $request->szin);
        }

        $autok = $query
            ->orderByDesc('kiemelt')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => $autok,
            'filters' => [
                'markak' => Auto::select('marka')->distinct()->orderBy('marka')->pluck('marka'),
                'allapotok' => Auto::select('allapot')->distinct()->orderBy('allapot')->pluck('allapot'),
                'kivitelek' => Auto::select('kivitel')->distinct()->orderBy('kivitel')->pluck('kivitel'),
                'szinek' => Auto::select('szin')->distinct()->orderBy('szin')->pluck('szin'),
            ]
        ]);
    }

    /**
     * Kiemelt autók (homepage)
     */
    public function featuredCars()
    {
        $autok = Auto::where('kiemelt', 1)
            ->where('raktaron', '>', 0)
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        return response()->json($autok);
    }

    /**
     * Új autó feltöltése
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'marka' => 'required|string|max:100',
            'modell' => 'required|string|max:100',
            'evjarat' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kilometerora' => 'required|integer|min:0',
            'ajtok_szama' => 'required|integer|in:2,3,4,5',
            'uzemanyag' => 'required|string|max:50',
            'teljesitmeny' => 'required|integer|min:0|max:3000',
            'kivitel' => 'required|string|max:50',
            'allapot' => 'required|string|max:50',
            'szemelyek_szama' => 'required|integer|in:2,4,5',
            'szin' => 'required|string|max:50',
            'sebessegvalto' => 'required|string|max:50',
            'hengerurtartalom' => 'required|integer|min:0|max:10000',
            'raktaron' => 'required|integer|min:0',
            'ar' => 'required|integer|min:0',
            'kiemelt' => 'required|in:0,1',

            'image1' => 'required|image|mimes:jpg,jpeg,png,webp|max:8192',
            'image2' => 'required|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        $path1 = $request->file('image1')->store('cars', 'public');
        $path2 = $request->file('image2')->store('cars', 'public');

        $auto = Auto::create([
            'marka' => $data['marka'],
            'modell' => $data['modell'],
            'evjarat' => $data['evjarat'],
            'kilometerora' => $data['kilometerora'],
            'ajtok_szama' => $data['ajtok_szama'],
            'uzemanyag' => $data['uzemanyag'],
            'teljesitmeny' => $data['teljesitmeny'],
            'kivitel' => $data['kivitel'],
            'allapot' => $data['allapot'],
            'szemelyek_szama' => $data['szemelyek_szama'],
            'szin' => $data['szin'],
            'sebessegvalto' => $data['sebessegvalto'],
            'hengerurtartalom' => $data['hengerurtartalom'],
            'raktaron' => $data['raktaron'],
            'ar' => $data['ar'],
            'kiemelt' => $data['kiemelt'],
            'kep' => 'storage/' . $path1,
            'kep2' => 'storage/' . $path2,
        ]);

        return response()->json([
            'message' => 'Autó sikeresen feltöltve!',
            'auto' => $auto,
        ], 201);
    }

    /**
     * Autó módosítása
     */
    public function apiUpdate(Request $request, Auto $auto)
    {
        $data = $request->validate([
            'raktaron' => 'required|integer|min:0',
            'kiemelt' => 'required|in:0,1',
        ]);

        $auto->update($data);

        return response()->json([
            'message' => 'Autó frissítve!',
            'auto' => $auto,
        ]);
    }

    /**
     * Autó törlése
     */
    public function apiDestroy(Auto $auto)
    {
        $auto->delete();

        return response()->json([
            'message' => 'Autó törölve!'
        ]);
    }
}