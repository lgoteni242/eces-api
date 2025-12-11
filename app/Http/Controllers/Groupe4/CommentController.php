<?php

namespace App\Http\Controllers\Groupe4;

use App\Http\Controllers\Controller;
use App\Models\Groupe4Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($postId)
    {
        $comments = Groupe4Comment::where('post_id', $postId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($comments);
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $comment = Groupe4Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $postId,
            'contenu' => $request->contenu,
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function destroy($id, Request $request)
    {
        $comment = Groupe4Comment::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé'], 200);
    }
}

