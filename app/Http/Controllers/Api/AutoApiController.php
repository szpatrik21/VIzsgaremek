<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AutoApiController extends Controller
{
    public function featured(): JsonResponse
    {
        $autok = DB::table('autok')
            ->where('kiemelt', 1)
            ->orderByDesc('id')
            ->limit(8)
            ->get([
                'id', 'marka', 'modell', 'evjarat',
                'teljesitmeny', 'uzemanyag', 'ar',
                'kep', 'kep2'
            ])
            ->map(fn ($a) => $this->mapListItem($a));

        return response()->json($autok);
    }

    public function index(Request $request): JsonResponse
    {
        $query = DB::table('autok');

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
            ->orderByDesc('id')
            ->get([
                'id', 'marka', 'modell', 'evjarat',
                'teljesitmeny', 'uzemanyag', 'ar',
                'kep', 'kep2'
            ])
            ->map(fn ($a) => $this->mapListItem($a));

        $filters = [
            'markak' => DB::table('autok')->whereNotNull('marka')->where('marka', '!=', '')->distinct()->orderBy('marka')->pluck('marka')->values(),
            'allapotok' => DB::table('autok')->whereNotNull('allapot')->where('allapot', '!=', '')->distinct()->orderBy('allapot')->pluck('allapot')->values(),
            'kivitelek' => DB::table('autok')->whereNotNull('kivitel')->where('kivitel', '!=', '')->distinct()->orderBy('kivitel')->pluck('kivitel')->values(),
            'szinek' => DB::table('autok')->whereNotNull('szin')->where('szin', '!=', '')->distinct()->orderBy('szin')->pluck('szin')->values(),
        ];

        return response()->json([
            'data' => $autok,
            'filters' => $filters,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $a = DB::table('autok')->where('id', $id)->first();

        if (!$a) {
            return response()->json([
                'message' => 'Az autó nem található.'
            ], 404);
        }

        return response()->json([
            'id' => (int) $a->id,
            'marka' => $a->marka,
            'modell' => $a->modell,
            'evjarat' => (int) $a->evjarat,
            'kilometerora' => (int) $a->kilometerora,
            'ajtok_szama' => (int) $a->ajtok_szama,
            'uzemanyag' => $a->uzemanyag,
            'teljesitmeny' => (int) $a->teljesitmeny,
            'kivitel' => $a->kivitel,
            'allapot' => $a->allapot,
            'szemelyek_szama' => (int) $a->szemelyek_szama,
            'szin' => $a->szin,
            'sebessegvalto' => $a->sebessegvalto,
            'hengerurtartalom' => (int) $a->hengerurtartalom,
            'raktaron' => (int) $a->raktaron,
            'ar' => (int) $a->ar,
            'kiemelt' => (int) $a->kiemelt,
            'kep' => $a->kep ? asset($a->kep) : asset('images/no-image.png'),
            'kep2' => $a->kep2 ? asset($a->kep2) : null,
            'url' => url('/autok/' . $a->id),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image1' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image2' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],

            'marka' => ['required', 'string', 'max:100'],
            'modell' => ['required', 'string', 'max:100'],
            'evjarat' => ['required', 'integer', 'min:1900', 'max:2100'],
            'kilometerora' => ['required', 'integer', 'min:0'],
            'ajtok_szama' => ['required', 'integer', 'min:2', 'max:10'],
            'uzemanyag' => ['required', 'string', 'max:50'],
            'teljesitmeny' => ['required', 'integer', 'min:0'],
            'ar' => ['required', 'integer', 'min:0'],

            'kivitel' => ['required', 'string', 'max:100'],
            'allapot' => ['required', 'string', 'max:100'],
            'szemelyek_szama' => ['required', 'integer', 'min:1', 'max:20'],
            'szin' => ['required', 'string', 'max:100'],
            'sebessegvalto' => ['required', 'string', 'max:50'],
            'hengerurtartalom' => ['required', 'integer', 'min:0'],
            'raktaron' => ['required', 'integer', 'min:0'],
            'kiemelt' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validációs hiba.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $image1Path = $request->file('image1')->store('cars', 'public');
        $image2Path = $request->file('image2')->store('cars', 'public');

        $id = DB::table('autok')->insertGetId([
            'marka' => $data['marka'],
            'modell' => $data['modell'],
            'evjarat' => $data['evjarat'],
            'kilometerora' => $data['kilometerora'],
            'ajtok_szama' => $data['ajtok_szama'],
            'uzemanyag' => $data['uzemanyag'],
            'teljesitmeny' => $data['teljesitmeny'],
            'ar' => $data['ar'],
            'kivitel' => $data['kivitel'],
            'allapot' => $data['allapot'],
            'szemelyek_szama' => $data['szemelyek_szama'],
            'szin' => $data['szin'],
            'sebessegvalto' => $data['sebessegvalto'],
            'hengerurtartalom' => $data['hengerurtartalom'],
            'raktaron' => $data['raktaron'],
            'kiemelt' => (int) ($data['kiemelt'] ?? 0),
            'kep' => 'storage/' . $image1Path,
            'kep2' => 'storage/' . $image2Path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Az autó sikeresen létrejött.',
            'data' => [
                'id' => $id,
                'url' => url('/autok/' . $id),
                'api_url' => url('/api/autok/' . $id),
            ]
        ], 201);
    }

    private function mapListItem(object $a): array
    {
        return [
            'id' => (int) $a->id,
            'marka' => $a->marka,
            'modell' => $a->modell,
            'evjarat' => (int) $a->evjarat,
            'teljesitmeny' => (int) $a->teljesitmeny,
            'uzemanyag' => $a->uzemanyag,
            'ar' => (int) $a->ar,
            'kep' => $a->kep ? asset($a->kep) : asset('images/no-image.png'),
            'url' => url('/autok/' . $a->id),
        ];
    }
}