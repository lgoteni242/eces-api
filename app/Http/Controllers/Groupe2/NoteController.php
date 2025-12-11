<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2Note;
use App\Models\Groupe2User;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        if (!$groupe2User) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $query = Groupe2Note::with(['matiere', 'etudiant.user']);

        // Si c'est un étudiant, ne voir que ses notes
        if ($groupe2User->role === 'etudiant') {
            $query->where('etudiant_id', $groupe2User->id);
        }
        // Si c'est un professeur, voir les notes de ses matières
        elseif ($groupe2User->role === 'professeur') {
            // Logique pour filtrer par matières du professeur si nécessaire
        }

        $notes = $query->get();

        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        if ($groupe2User->role !== 'professeur' && $groupe2User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'etudiant_id' => 'required|exists:groupe2_users,id',
            'matiere_id' => 'required|exists:groupe2_matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'commentaire' => 'nullable|string',
        ]);

        $note = Groupe2Note::create([
            'etudiant_id' => $request->etudiant_id,
            'matiere_id' => $request->matiere_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'professeur_id' => $groupe2User->id,
        ]);

        return response()->json($note->load(['matiere', 'etudiant.user']), 201);
    }

    public function show($id, Request $request)
    {
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        $note = Groupe2Note::with(['matiere', 'etudiant.user', 'professeur.user'])
            ->findOrFail($id);

        // Vérifier les permissions
        if ($groupe2User->role === 'etudiant' && $note->etudiant_id !== $groupe2User->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        return response()->json($note);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        if ($groupe2User->role !== 'professeur' && $groupe2User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $note = Groupe2Note::findOrFail($id);

        $request->validate([
            'note' => 'sometimes|numeric|min:0|max:20',
            'commentaire' => 'nullable|string',
        ]);

        $note->update($request->all());

        return response()->json($note->load(['matiere', 'etudiant.user']));
    }
}

