<?php

namespace App\Http\Controllers\Groupe4;

use App\Http\Controllers\Controller;
use App\Models\Groupe4Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Groupe4Post::with(['user', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($posts);
    }

    public function feed(Request $request)
    {
        $posts = Groupe4Post::with(['user', 'likes', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $post = Groupe4Post::create([
            'user_id' => $request->user()->id,
            'contenu' => $request->contenu,
            'image' => $request->image,
        ]);

        return response()->json($post->load('user'), 201);
    }

    public function show($id)
    {
        $post = Groupe4Post::with(['user', 'likes', 'comments.user'])
            ->findOrFail($id);

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Groupe4Post::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $request->validate([
            'contenu' => 'sometimes|string',
            'image' => 'nullable|string',
        ]);

        $post->update($request->all());

        return response()->json($post->load('user'));
    }

    public function destroy($id, Request $request)
    {
        $post = Groupe4Post::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $post->delete();

        return response()->json(['message' => 'Post supprimé'], 200);
    }

    public function like($id, Request $request)
    {
        $post = Groupe4Post::findOrFail($id);

        $like = $post->likes()->where('user_id', $request->user()->id)->first();

        if ($like) {
            return response()->json(['message' => 'Déjà liké'], 400);
        }

        $post->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['message' => 'Post liké'], 201);
    }

    public function unlike($id, Request $request)
    {
        $post = Groupe4Post::findOrFail($id);

        $post->likes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Like retiré'], 200);
    }
}

