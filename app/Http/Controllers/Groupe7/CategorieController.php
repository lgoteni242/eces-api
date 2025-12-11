<?php

namespace App\Http\Controllers\Groupe7;

use App\Http\Controllers\Controller;
use App\Models\Groupe7Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Groupe7Categorie::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:depense,revenu',
            'couleur' => 'nullable|string',
        ]);

        $categorie = Groupe7Categorie::create($request->all());

        return response()->json($categorie, 201);
    }

    public function show($id)
    {
        $categorie = Groupe7Categorie::findOrFail($id);
        return response()->json($categorie);
    }

    public function update(Request $request, $id)
    {
        $categorie = Groupe7Categorie::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:depense,revenu',
            'couleur' => 'nullable|string',
        ]);

        $categorie->update($request->all());

        return response()->json($categorie);
    }

    public function destroy($id)
    {
        $categorie = Groupe7Categorie::findOrFail($id);
        $categorie->delete();

        return response()->json(['message' => 'Catégorie supprimée'], 200);
    }
}

