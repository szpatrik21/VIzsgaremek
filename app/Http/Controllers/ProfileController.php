<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nincs bejelentkezett felhasználó.'
            ], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'A jelenlegi jelszó hibás.'
            ], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'A jelszó sikeresen módosítva.'
        ]);
    }

    public function myComments()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([], 401);
        }

        $comments = Comment::with('auto')
            ->where('user_id', $user->id)
            ->latest('id')
            ->get()
            ->map(function ($comment) {
                $marka = optional($comment->auto)->marka ?? '';
                $modell = optional($comment->auto)->modell ?? '';

                return [
                    'id' => $comment->id,
                    'content' => $comment->content ?? '',
                    'created_at' => $comment->created_at,
                    'auto_nev' => trim($marka . ' ' . $modell) ?: 'Ismeretlen autó',
                ];
            })
            ->values();

        return response()->json($comments);
    }

    public function deleteMyComment(Comment $comment)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Nincs bejelentkezett felhasználó.'
            ], 401);
        }

        if ((int) $comment->user_id !== (int) $user->id) {
            return response()->json([
                'message' => 'Ehhez nincs jogosultságod.'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Komment sikeresen törölve.'
        ]);
    }
}