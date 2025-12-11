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
        $user = $request->user();
        $groupe2User = Groupe2User::where('user_id', $user->id)->first();

        if ($groupe2User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
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

        return response()->json($stats);
    }
}

