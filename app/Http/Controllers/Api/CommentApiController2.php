<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentApiController2 extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $comments = Comment::with(['user', 'auto'])
            ->latest()
            ->paginate(10);

        return response()->json($comments);
    }

    public function destroy(int $id): JsonResponse
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'A komment nem található.'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Komment sikeresen törölve.']);
    }
}