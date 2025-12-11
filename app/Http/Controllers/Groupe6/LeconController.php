<?php

namespace App\Http\Controllers\Groupe6;

use App\Http\Controllers\Controller;
use App\Models\Groupe6Lecon;
use App\Models\Groupe6Cours;
use App\Models\Groupe6User;
use Illuminate\Http\Request;

class LeconController extends Controller
{
    public function index($coursId)
    {
        $lecons = Groupe6Lecon::where('cours_id', $coursId)
            ->orderBy('ordre', 'asc')
            ->get();

        return response()->json($lecons);
    }

    public function show($coursId, $id, Request $request)
    {
        $lecon = Groupe6Lecon::where('cours_id', $coursId)
            ->findOrFail($id);

        // Enregistrer la progression si c'est un étudiant
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User && $groupe6User->role === 'etudiant') {
            $progression = $lecon->progressions()
                ->where('etudiant_id', $groupe6User->id)
                ->first();

            if (!$progression) {
                $lecon->progressions()->create([
                    'etudiant_id' => $groupe6User->id,
                    'termine' => true,
                ]);
            }
        }

        return response()->json($lecon);
    }

    public function store(Request $request, $coursId)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($coursId);

        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'video_url' => 'nullable|string',
            'ordre' => 'required|integer',
        ]);

        $lecon = Groupe6Lecon::create([
            'cours_id' => $coursId,
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'video_url' => $request->video_url,
            'ordre' => $request->ordre,
        ]);

        return response()->json($lecon, 201);
    }

    public function update(Request $request, $coursId, $id)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($coursId);

        $lecon = Groupe6Lecon::where('cours_id', $coursId)
            ->findOrFail($id);

        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'contenu' => 'sometimes|string',
            'video_url' => 'nullable|string',
            'ordre' => 'sometimes|integer',
        ]);

        $lecon->update($request->all());

        return response()->json($lecon);
    }

    public function destroy($coursId, $id, Request $request)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if ($groupe6User->role !== 'formateur') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $cours = Groupe6Cours::where('formateur_id', $groupe6User->id)
            ->findOrFail($coursId);

        $lecon = Groupe6Lecon::where('cours_id', $coursId)
            ->findOrFail($id);

        $lecon->delete();

        return response()->json(['message' => 'Leçon supprimée'], 200);
    }
}

