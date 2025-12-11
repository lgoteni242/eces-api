<?php

namespace App\Http\Controllers\Groupe5;

use App\Http\Controllers\Controller;
use App\Models\Groupe5Tache;
use App\Models\Groupe5Projet;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index($projetId, Request $request)
    {
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($projetId);

        $taches = Groupe5Tache::where('projet_id', $projetId)
            ->with('user')
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
            'priorite' => 'nullable|in:low,medium,high',
        ]);

        $tache = Groupe5Tache::create([
            'projet_id' => $projetId,
            'titre' => $request->titre,
            'description' => $request->description,
            'status' => 'todo',
            'priorite' => $request->priorite ?? 'medium',
        ]);

        return response()->json($tache, 201);
    }

    public function update(Request $request, $id)
    {
        $tache = Groupe5Tache::findOrFail($id);
        
        // Vérifier que l'utilisateur a accès au projet
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priorite' => 'nullable|in:low,medium,high',
        ]);

        $tache->update($request->all());

        return response()->json($tache->load('user'));
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
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $tache = Groupe5Tache::findOrFail($id);
        
        // Vérifier que l'utilisateur a accès au projet
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($tache->projet_id);

        $tache->user_id = $request->user_id;
        $tache->save();

        return response()->json($tache->load('user'));
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
}

