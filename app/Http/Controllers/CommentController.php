<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Pattern;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Pattern $pattern)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'pattern_id' => $pattern->id,
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Comentário adicionado com sucesso!');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comentário removido com sucesso!');
    }
}
