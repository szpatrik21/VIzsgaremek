<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentApiController extends Controller
{
    public function index()
    {
        return Comment::with('user:id,username,first_name,last_name')
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ]);

        $user = auth('api')->user();

        $comment = Comment::create([
            'user_id' => $user->id,
            'content' => $request->content,
        ])->load('user:id,username,first_name,last_name');

        return response()->json([
            'message' => 'Komment mentve ✅',
            'comment' => $comment
        ], 201);
    }
}

