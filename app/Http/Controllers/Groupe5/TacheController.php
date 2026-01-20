<?php

namespace App\Http\Controllers\Groupe5;

use App\Http\Controllers\Controller;
use App\Models\Groupe5Tache;
use App\Models\Groupe5Projet;
use App\Models\Groupe5Commentaire;
use App\Models\Groupe5Label;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index($projetId, Request $request)
    {
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($projetId);


        $taches = Groupe5Tache::where('projet_id', $projetId)
            ->with(['user', 'commentaires.user', 'assignes']) 
            ->get();

        return response()->json($taches);
    }

    public function store(Request $request, $projetId)
    {
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($projetId);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priorite' => 'nullable|in:low,medium,high',
            'labels' => 'nullable|array',
        ]);

        $tache = Groupe5Tache::create([
            'projet_id' => $projetId,
            'titre' => $request->titre,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'status' => 'todo',
            'priorite' => $request->priorite ?? 'medium',
        ]);

        if ($request->has('labels')) {
            $tache->labelsRelation()->attach($request->labels);
        }

        return response()->json($tache->load('labelsRelation'), 201);
    }

    // --- NOUVELLE MÉTHODE : AJOUTER UN COMMENTAIRE ---
    public function addCommentaire(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $tache = Groupe5Tache::findOrFail($id);

        $commentaire = $tache->commentaires()->create([
            'user_id' => $request->user()->id,
            'contenu' => $request->contenu,
        ]);

        return response()->json($commentaire->load('user'), 201);
    }

    public function update(Request $request, $id)
    {
        $tache = Groupe5Tache::findOrFail($id);
        
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'nullable|in:low,medium,high',
            'labels' => 'nullable|array',
            'deadline' => 'nullable|date',
        ]);

        $tache->update($request->except('labels'));

        if ($request->has('labels')) {
            $tache->labelsRelation()->sync($request->labels);
        }

        return response()->json($tache->load(['user', 'commentaires', 'labelsRelation']));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:todo,doing,done',
        ]);

        $tache = Groupe5Tache::findOrFail($id);
        
        // Vérifier que l'utilisateur a accès au projet
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        $tache->status = $request->status;
        $tache->save();

        return response()->json($tache->load('user'));
    }

    public function assign(Request $request, $id) 
    {
        $tache = Groupe5Tache::findOrFail($id);
        // On synchronise les IDs envoyés depuis le front
        $tache->assignes()->sync($request->user_ids); 
        return response()->json($tache->load('assignes'));
    }

    public function destroy($id, Request $request)
    {
        $tache = Groupe5Tache::findOrFail($id);
        
        // Vérifier que l'utilisateur a accès au projet
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        $tache->delete();

        return response()->json(['message' => 'Tâche supprimée'], 200);
    }

    public function uploadPieceJointe(Request $request, $tacheId)
    {
        $request->validate([
            'fichier' => 'required|file|max:10240', // Max 10Mo
        ]);

        $tache = Groupe5Tache::findOrFail($tacheId);
        
        // Vérifier que l'utilisateur a accès au projet
        Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            
            // Stockage dans storage/app/public/taches
            $path = $file->store('taches', 'public');

            $piece = $tache->piecesJointes()->create([
                'nom_original' => $file->getClientOriginalName(),
                'chemin' => $path,
                'type_mime' => $file->getClientMimeType(),
                'taille' => $file->getSize(),
            ]);

            return response()->json($piece, 201);
        }

        return response()->json(['message' => 'Aucun fichier fourni'], 400);
    }

    public function getPiecesJointes(Request $request, $tacheId)
    {
        $tache = Groupe5Tache::findOrFail($tacheId);
        
        // Vérifier que l'utilisateur a accès au projet
        Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        return response()->json($tache->piecesJointes);
    }

    public function deletePieceJointe(Request $request, $id)
    {
        $piece = \App\Models\Groupe5PieceJointe::findOrFail($id);
        $tache = Groupe5Tache::findOrFail($piece->tache_id);
        
        // Vérifier que l'utilisateur a accès au projet
        Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        // Supprimer le fichier du stockage
        \Illuminate\Support\Facades\Storage::disk('public')->delete($piece->chemin);
        
        $piece->delete();

        return response()->json(['message' => 'Pièce jointe supprimée'], 200);
    }

    public function getCommentaires($id)
    {
        $tache = Groupe5Tache::findOrFail($id);
        // Charger les commentaires avec les données utilisateur
        $commentaires = $tache->commentaires()->with('user')->get();
        return response()->json($commentaires);
    }

    /**
     * Voir les labels d'une tâche
     */
    public function getLabels($id)
    {
        $tache = Groupe5Tache::findOrFail($id);
        return response()->json($tache->labelsRelation);
    }

    /**
     * Ajouter un label à une tâche
     */
    public function addLabel(Request $request, $id)
    {
        $request->validate([
            'label_id' => 'required|exists:groupe5_labels,id',
        ]);

        $tache = Groupe5Tache::findOrFail($id);
        
        // Vérifier que l'utilisateur a accès au projet
        Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        // Vérifier si le label n'est pas déjà attaché
        if (!$tache->labelsRelation()->where('label_id', $request->label_id)->exists()) {
            $tache->labelsRelation()->attach($request->label_id);
        }

        return response()->json($tache->labelsRelation()->get());
    }

    /**
     * Retirer un label d'une tâche
     */
    public function removeLabel(Request $request, $id, $labelId)
    {
        $tache = Groupe5Tache::findOrFail($id);
        
        // Vérifier que l'utilisateur a accès au projet
        Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        $tache->labelsRelation()->detach($labelId);

        return response()->json(['message' => 'Label retiré de la tâche']);
    }

    /**
     * Modifier un commentaire
     */
    public function updateCommentaire(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $commentaire = Groupe5Commentaire::findOrFail($id);
        
        // Vérifier que l'utilisateur est l'auteur du commentaire
        if ($commentaire->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $commentaire->update(['contenu' => $request->contenu]);

        return response()->json($commentaire->load('user'));
    }

    /**
     * Supprimer un commentaire
     */
    public function deleteCommentaire(Request $request, $id)
    {
        $commentaire = Groupe5Commentaire::findOrFail($id);
        
        // Vérifier que l'utilisateur est l'auteur du commentaire ou propriétaire du projet
        $tache = Groupe5Tache::findOrFail($commentaire->tache_id);
        $isProjectOwner = Groupe5Projet::where('user_id', $request->user()->id)
            ->where('id', $tache->projet_id)
            ->exists();
        
        if ($commentaire->user_id !== $request->user()->id && !$isProjectOwner) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $commentaire->delete();

        return response()->json(['message' => 'Commentaire supprimé']);
    }

    /**
     * Lister tous les labels disponibles
     */
    public function getAllLabels()
    {
        $labels = Groupe5Label::all();
        return response()->json($labels);
    }

    public function storeLabel(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'couleur' => 'required|string',
        ]);

        $label = Groupe5Label::create($request->only(['nom', 'couleur']));
        return response()->json($label);
    }
}