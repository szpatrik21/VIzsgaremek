<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('user')->latest()->get();
        return view('comments.index', compact('comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|min:3'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('message', 'Komment elküldve!');
    }
}
