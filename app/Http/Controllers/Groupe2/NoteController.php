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
        try {
            $user = $request->user();
            $groupe2User = Groupe2User::where('user_id', $user->id)->first();

            if (!$groupe2User) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil utilisateur non trouvé. Veuillez vous réinscrire.',
                    'errors' => [],
                ], 404);
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

            return response()->json([
                'success' => true,
                'data' => $notes,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération des notes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des notes',
                'errors' => [],
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        if (!$groupe2User) {
            return response()->json([
                'success' => false,
                'message' => 'Profil utilisateur non trouvé. Veuillez vous réinscrire.',
                'errors' => [],
            ], 404);
        }

        if ($groupe2User->role !== 'professeur' && $groupe2User->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé',
                'errors' => [],
            ], 403);
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

        if (!$groupe2User) {
            return response()->json([
                'success' => false,
                'message' => 'Profil utilisateur non trouvé. Veuillez vous réinscrire.',
                'errors' => [],
            ], 404);
        }

        $note = Groupe2Note::with(['matiere', 'etudiant.user', 'professeur.user'])
            ->findOrFail($id);

        // Vérifier les permissions
        if ($groupe2User->role === 'etudiant' && $note->etudiant_id !== $groupe2User->id) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé',
                'errors' => [],
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $note,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        if ($groupe2User->role !== 'professeur' && $groupe2User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        try {
            $note = Groupe2Note::findOrFail($id);

            $request->validate([
                'note' => 'sometimes|numeric|min:0|max:20',
                'commentaire' => 'nullable|string',
            ]);

            $note->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Note mise à jour avec succès',
                'data' => $note->load(['matiere', 'etudiant.user']),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Note non trouvée',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la mise à jour de la note: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour de la note',
                'errors' => [],
            ], 500);
        }
    }
}
