<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2Presence;
use App\Models\Groupe2User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PresenceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'etudiant_id' => 'required|exists:groupe2_users,id',
                'classe_id' => 'required|exists:groupe2_classes,id',
                'date' => 'required|date',
                'statut' => 'required|in:present,absent,retarde,excusé',
                'commentaire' => 'nullable|string',
            ]);

            $presence = Groupe2Presence::create($request->all());

            return response()->json($presence->load(['etudiant.user', 'classe']), 201);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la présence: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de la présence',
                'errors' => [],
            ], 500);
        }
    }

    public function getPresences($etudiantId)
    {
        $etudiant = Groupe2User::where('id', $etudiantId)
            ->where('role', 'etudiant')
            ->with('user')
            ->firstOrFail();

        $presences = Groupe2Presence::where('etudiant_id', $etudiantId)
            ->with('classe')
            ->orderBy('date', 'desc')
            ->get();

        // Statistiques
        $total = $presences->count();
        $presents = $presences->where('statut', 'present')->count();
        $absents = $presences->where('statut', 'absent')->count();
        $retardes = $presences->where('statut', 'retarde')->count();
        $excuses = $presences->where('statut', 'excusé')->count();

        return response()->json([
            'etudiant' => [
                'id' => $etudiant->id,
                'name' => $etudiant->user->name,
                'email' => $etudiant->user->email,
            ],
            'statistiques' => [
                'total' => $total,
                'presents' => $presents,
                'absents' => $absents,
                'retardes' => $retardes,
                'excuses' => $excuses,
                'taux_presence' => $total > 0 ? round(($presents / $total) * 100, 2) : 0,
            ],
            'presences' => $presences,
        ]);
    }

    public function getAbsences($etudiantId)
    {
        $etudiant = Groupe2User::where('id', $etudiantId)
            ->where('role', 'etudiant')
            ->with('user')
            ->firstOrFail();

        $absences = Groupe2Presence::where('etudiant_id', $etudiantId)
            ->whereIn('statut', ['absent', 'retarde'])
            ->with('classe')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'etudiant' => [
                'id' => $etudiant->id,
                'name' => $etudiant->user->name,
                'email' => $etudiant->user->email,
            ],
            'absences' => $absences,
            'total_absences' => $absences->count(),
        ]);
    }
}
