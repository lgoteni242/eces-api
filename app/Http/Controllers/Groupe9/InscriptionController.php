<?php

namespace App\Http\Controllers\Groupe9;

use App\Http\Controllers\Controller;
use App\Models\Groupe9Inscription;
use App\Models\Groupe9Evenement;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        $inscriptions = Groupe9Inscription::where('user_id', $request->user()->id)
            ->with('evenement')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($inscriptions);
    }

    public function store(Request $request, $evenementId)
    {
        $evenement = Groupe9Evenement::findOrFail($evenementId);

        // Vérifier si l'événement est déjà passé
        if ($evenement->date < now()) {
            return response()->json(['message' => 'Impossible de s\'inscrire à un événement passé'], 400);
        }

        // Vérifier la capacité
        if ($evenement->capacite_max) {
            $inscriptionsCount = Groupe9Inscription::where('evenement_id', $evenementId)->count();
            if ($inscriptionsCount >= $evenement->capacite_max) {
                return response()->json(['message' => 'Événement complet'], 400);
            }
        }

        // Vérifier si déjà inscrit
        $existingInscription = Groupe9Inscription::where('user_id', $request->user()->id)
            ->where('evenement_id', $evenementId)
            ->first();

        if ($existingInscription) {
            return response()->json(['message' => 'Déjà inscrit à cet événement'], 400);
        }

        $inscription = Groupe9Inscription::create([
            'user_id' => $request->user()->id,
            'evenement_id' => $evenementId,
        ]);

        return response()->json($inscription->load('evenement'), 201);
    }

    public function destroy($evenementId, Request $request)
    {
        $inscription = Groupe9Inscription::where('user_id', $request->user()->id)
            ->where('evenement_id', $evenementId)
            ->firstOrFail();

        $inscription->delete();

        return response()->json(['message' => 'Inscription annulée'], 200);
    }
}

