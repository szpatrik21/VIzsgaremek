<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    // ✅ Csak az adott autó kommentjei (GET: publikus)
    public function index(Auto $auto)
    {
        $query = Comment::with('user:id,username,first_name,last_name')
            ->where('auto_id', $auto->id);

        if (\Illuminate\Support\Facades\Schema::hasColumn('comments', 'status')) {
            $query->where('status', 'approved');
        }

        return $query->latest()->get();
    }

    // ✅ Komment mentése adott autóhoz (POST: JWT kell)
    public function store(Request $request, Auto $auto)
    {
        $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ]);

        $user = auth('api')->user(); // JWT guard

        if (!$user) {
            return response()->json([
                'message' => 'Nincs bejelentkezve.'
            ], 401);
        }

        // 🔥 FONTOS: $comment változó kell, mert ezt küldjük vissza
        $comment = Comment::create([
            'user_id' => $user->id,
            'auto_id' => $auto->id,
            'content' => $request->content,
        ])->load('user:id,username,first_name,last_name');

        return response()->json([
            'message' => 'Komment mentve ✅',
            'comment' => $comment
        ], 201);
    }
}