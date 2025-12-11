<?php

namespace App\Http\Controllers\Groupe5;

use App\Http\Controllers\Controller;
use App\Models\Groupe5Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index(Request $request)
    {
        $projets = Groupe5Projet::where('user_id', $request->user()->id)
            ->with('taches')
            ->get();

        return response()->json($projets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $projet = Groupe5Projet::create([
            'user_id' => $request->user()->id,
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return response()->json($projet, 201);
    }

    public function show($id, Request $request)
    {
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->with('taches.user')
            ->findOrFail($id);

        return response()->json($projet);
    }

    public function update(Request $request, $id)
    {
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $projet->update($request->all());

        return response()->json($projet);
    }

    public function destroy($id, Request $request)
    {
        $projet = Groupe5Projet::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $projet->delete();

        return response()->json(['message' => 'Projet supprimé'], 200);
    }
}

