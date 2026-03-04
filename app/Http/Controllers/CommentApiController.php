<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    //  Csak az adott autó kommentjei 
    public function index(Auto $auto)
    {
        return Comment::with('user:id,username,first_name,last_name')
            ->where('auto_id', $auto->id)
            ->latest()
            ->get();
    }

    // Komment mentése megadott  autóhoz (POST: JWT kell)
    public function store(Request $request, Auto $auto)
    {
        $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ]);

        $user = auth('api')->user(); 

        if (!$user) {
            return response()->json([
                'message' => 'Nincs bejelentkezve.'
            ], 401);
        }

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