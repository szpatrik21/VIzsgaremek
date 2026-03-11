<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Auto;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($autoId)
    {
        $comments = Comment::with('user')
            ->where('auto_id', $autoId)
            ->where('status', 'approved')
            ->latest()
            ->get();

        return response()->json($comments);
    }

    public function store(Request $request, $autoId)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:2', 'max:1000'],
        ]);

        $auto = Auto::findOrFail($autoId);
        $user = $request->user();

        Comment::create([
            'user_id' => $user->id,
            'auto_id' => $auto->id,
            'content' => $request->content,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'A komment rögzítve lett, admin jóváhagyás után jelenik meg.'
        ], 201);
    }
}