<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2User;
use App\Models\Groupe2Note;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    public function show($etudiantId)
    {
        $etudiant = Groupe2User::where('id', $etudiantId)
            ->where('role', 'etudiant')
            ->with('user')
            ->firstOrFail();

        $notes = Groupe2Note::where('etudiant_id', $etudiantId)
            ->with(['matiere', 'professeur.user'])
            ->get();

        // Calculer les moyennes par matière
        $moyennesParMatiere = $notes->groupBy('matiere_id')->map(function ($notesMatiere) {
            $matiere = $notesMatiere->first()->matiere;
            $moyenne = $notesMatiere->avg('note');
            $nombreNotes = $notesMatiere->count();
            
            return [
                'matiere' => $matiere,
                'moyenne' => round($moyenne, 2),
                'nombre_notes' => $nombreNotes,
                'notes' => $notesMatiere->map(function ($note) {
                    return [
                        'id' => $note->id,
                        'note' => $note->note,
                        'commentaire' => $note->commentaire,
                        'professeur' => $note->professeur->user->name ?? null,
                        'created_at' => $note->created_at,
                    ];
                }),
            ];
        })->values();

        // Calculer la moyenne générale
        $moyenneGenerale = $notes->avg('note');

        return response()->json([
            'etudiant' => [
                'id' => $etudiant->id,
                'name' => $etudiant->user->name,
                'email' => $etudiant->user->email,
            ],
            'moyenne_generale' => round($moyenneGenerale, 2),
            'total_notes' => $notes->count(),
            'moyennes_par_matiere' => $moyennesParMatiere,
        ]);
    }
}
