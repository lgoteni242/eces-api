<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index()
    {
        $matieres = Groupe2Matiere::all();
        return response()->json($matieres);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $matiere = Groupe2Matiere::create($request->all());

        return response()->json($matiere, 201);
    }

    public function show($id)
    {
        $matiere = Groupe2Matiere::with('notes')->findOrFail($id);
        return response()->json($matiere);
    }

    public function update(Request $request, $id)
    {
        $matiere = Groupe2Matiere::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $matiere->update($request->all());

        return response()->json($matiere);
    }

    public function destroy($id)
    {
        $matiere = Groupe2Matiere::findOrFail($id);
        $matiere->delete();

        return response()->json(['message' => 'Matière supprimée'], 200);
    }
}

