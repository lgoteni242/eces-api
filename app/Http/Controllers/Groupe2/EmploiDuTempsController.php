<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2EmploiDuTemps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $emploisDuTemps = Groupe2EmploiDuTemps::with([
            'classe',
            'matiere',
            'professeur.user'
        ])->get();
        
        return response()->json($emploisDuTemps);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'classe_id' => 'required|exists:groupe2_classes,id',
                'matiere_id' => 'required|exists:groupe2_matieres,id',
                'professeur_id' => 'required|exists:groupe2_users,id',
                'jour_semaine' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
                'heure_debut' => 'required|date_format:H:i',
                'heure_fin' => 'required|date_format:H:i|after:heure_debut',
                'salle' => 'nullable|string|max:255',
            ]);

            $emploiDuTemps = Groupe2EmploiDuTemps::create($request->all());

            return response()->json($emploiDuTemps->load(['classe', 'matiere', 'professeur.user']), 201);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'emploi du temps: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de l\'emploi du temps',
                'errors' => [],
            ], 500);
        }
    }

    public function show($classeId)
    {
        $emploisDuTemps = Groupe2EmploiDuTemps::where('classe_id', $classeId)
            ->with(['matiere', 'professeur.user'])
            ->orderBy('jour_semaine')
            ->orderBy('heure_debut')
            ->get();
        
        return response()->json($emploisDuTemps);
    }

    public function update(Request $request, $id)
    {
        try {
            $emploiDuTemps = Groupe2EmploiDuTemps::findOrFail($id);

            $request->validate([
                'classe_id' => 'sometimes|exists:groupe2_classes,id',
                'matiere_id' => 'sometimes|exists:groupe2_matieres,id',
                'professeur_id' => 'sometimes|exists:groupe2_users,id',
                'jour_semaine' => 'sometimes|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
                'heure_debut' => 'sometimes|date_format:H:i',
                'heure_fin' => 'sometimes|date_format:H:i|after:heure_debut',
                'salle' => 'nullable|string|max:255',
            ]);

            $emploiDuTemps->update($request->all());

            return response()->json($emploiDuTemps->load(['classe', 'matiere', 'professeur.user']));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour de l\'emploi du temps: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour de l\'emploi du temps',
                'errors' => [],
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $emploiDuTemps = Groupe2EmploiDuTemps::findOrFail($id);
            $emploiDuTemps->delete();

            return response()->json(['message' => 'Emploi du temps supprimé avec succès'], 200);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de l\'emploi du temps: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de l\'emploi du temps',
                'errors' => [],
            ], 500);
        }
    }
}
