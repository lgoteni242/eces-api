<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2Note;
use App\Models\Groupe2Matiere;
use App\Models\Groupe2User;
use Illuminate\Http\Request;

class DashboardController extends Controller
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

            if ($groupe2User->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès réservé aux administrateurs.',
                    'errors' => [],
                ], 403);
            }

            $stats = [
                'total_matieres' => Groupe2Matiere::count(),
                'total_etudiants' => Groupe2User::where('role', 'etudiant')->count(),
                'total_professeurs' => Groupe2User::where('role', 'professeur')->count(),
                'total_notes' => Groupe2Note::count(),
                'moyenne_generale' => Groupe2Note::avg('note'),
                'notes_par_matiere' => Groupe2Note::selectRaw('matiere_id, AVG(note) as moyenne')
                    ->groupBy('matiere_id')
                    ->with('matiere')
                    ->get(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération du dashboard: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération du dashboard',
                'errors' => [],
            ], 500);
        }
    }
}
