<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'carsCount' => DB::table('autok')->count(),
            'featuredCars' => DB::table('autok')->where('kiemelt', 1)->count(),
            'usersCount' => DB::table('users')->count(),
            'commentsCount' => DB::table('comments')->count(),
        ];

        $latestComments = DB::table('comments as c')
            ->leftJoin('users as u', 'u.id', '=', 'c.user_id')
            ->leftJoin('autok as a', 'a.id', '=', 'c.auto_id')
            ->select(
                'c.id',
                'c.content',
                'c.created_at',
                'u.username',
                'u.first_name',
                'u.last_name',
                'a.marka',
                'a.modell'
            )
            ->orderByDesc('c.created_at')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                $fullName = trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? ''));
                $carName = trim(($item->marka ?? '') . ' ' . ($item->modell ?? ''));

                return [
                    'id' => $item->id,
                    'author' => $fullName !== '' ? $fullName : ($item->username ?: 'Ismeretlen felhasználó'),
                    'car_name' => $carName !== '' ? $carName : 'Nincs autó megadva',
                    'content' => $item->content,
                    'created_at' => $item->created_at,
                    'is_new' => $item->created_at
                        ? Carbon::parse($item->created_at)->gt(now()->subDay())
                        : false,
                ];
            })
            ->values();

        return response()->json([
            'stats' => $stats,
            'latest_comments' => $latestComments,
        ]);
    }
}