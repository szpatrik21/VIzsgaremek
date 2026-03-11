<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminCommentController extends Controller
{
    public function index()
    {
        $comments = DB::table('comments as c')
            ->leftJoin('users as u', 'u.id', '=', 'c.user_id')
            ->leftJoin('autok as a', 'a.id', '=', 'c.auto_id')
            ->select(
                'c.id',
                'c.content',
                'c.status',
                'c.created_at',
                'u.username',
                'u.first_name',
                'u.last_name',
                'a.marka',
                'a.modell'
            )
            ->orderByRaw("
                CASE
                    WHEN c.status = 'pending' THEN 1
                    WHEN c.status = 'approved' THEN 2
                    WHEN c.status = 'rejected' THEN 3
                    ELSE 4
                END
            ")
            ->orderByDesc('c.created_at')
            ->paginate(10);

        $comments->getCollection()->transform(function ($item) {
            $author = trim(($item->first_name ?? '') . ' ' . ($item->last_name ?? ''));
            $carName = trim(($item->marka ?? '') . ' ' . ($item->modell ?? ''));

            return [
                'id' => $item->id,
                'content' => $item->content,
                'status' => $item->status,
                'created_at' => $item->created_at,
                'author' => $author !== '' ? $author : ($item->username ?? 'Ismeretlen felhasználó'),
                'car_name' => $carName !== '' ? $carName : 'Nincs autó megadva',
            ];
        });

        return response()->json($comments);
    }

    public function approve($id)
    {
        DB::table('comments')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Komment jóváhagyva.'
        ]);
    }

    public function reject($id)
    {
        DB::table('comments')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Komment elutasítva.'
        ]);
    }

    public function destroy($id)
    {
        DB::table('comments')
            ->where('id', $id)
            ->delete();

        return response()->json([
            'message' => 'Komment törölve.'
        ]);
    }
}