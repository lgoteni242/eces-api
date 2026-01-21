<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Groupe2Classe::with(['professeurPrincipal.user', 'etudiants.user'])
            ->get();
        
        return response()->json($classes);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'niveau' => 'nullable|string|max:255',
                'annee_scolaire' => 'nullable|string|max:255',
                'professeur_principal_id' => 'nullable|exists:groupe2_users,id',
                'description' => 'nullable|string',
            ]);

            $classe = Groupe2Classe::create($request->all());

            return response()->json($classe->load(['professeurPrincipal.user']), 201);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la classe: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de la classe',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id)
    {
        $classe = Groupe2Classe::with([
            'professeurPrincipal.user',
            'etudiants.user',
            'emploisDuTemps.matiere',
            'emploisDuTemps.professeur.user'
        ])->findOrFail($id);
        
        return response()->json($classe);
    }

    public function update(Request $request, $id)
    {
        try {
            $classe = Groupe2Classe::findOrFail($id);

            $request->validate([
                'nom' => 'sometimes|string|max:255',
                'niveau' => 'nullable|string|max:255',
                'annee_scolaire' => 'nullable|string|max:255',
                'professeur_principal_id' => 'nullable|exists:groupe2_users,id',
                'description' => 'nullable|string',
            ]);

            $classe->update($request->all());

            return response()->json($classe->load(['professeurPrincipal.user']));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de la classe: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour de la classe',
                'errors' => [],
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $classe = Groupe2Classe::findOrFail($id);
            $classe->delete();

            return response()->json(['message' => 'Classe supprimée avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la classe: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de la classe',
                'errors' => [],
            ], 500);
        }
    }
}
