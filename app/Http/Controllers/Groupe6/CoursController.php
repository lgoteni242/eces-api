<?php

namespace App\Http\Controllers\Groupe6;

use App\Http\Controllers\Controller;
use App\Models\Groupe6Cours;
use App\Models\Groupe6User;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Groupe6Cours::with('formateur.user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($cours);
    }

    public function show($id)
    {
        $cours = Groupe6Cours::with(['formateur.user', 'lecons', 'quiz'])
            ->findOrFail($id);

        return response()->json($cours);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $cours = Groupe6Cours::create([
            'formateur_id' => $groupe6User->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'image' => $request->image,
        ]);

        return response()->json($cours->load('formateur.user'), 201);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($id);

        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'image' => 'nullable|string',
        ]);

        $cours->update($request->all());

        return response()->json($cours->load('formateur.user'));
    }

    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($id);

        $cours->delete();

        return response()->json(['message' => 'Cours supprimé'], 200);
    }
}

