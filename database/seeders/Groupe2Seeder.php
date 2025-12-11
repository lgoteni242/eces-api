<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des matières
        $matieres = [
            ['nom' => 'Mathématiques', 'description' => 'Cours de mathématiques avancées : algèbre, géométrie, calcul'],
            ['nom' => 'Informatique', 'description' => 'Programmation et algorithmes : Python, Java, structures de données'],
            ['nom' => 'Anglais', 'description' => 'Cours d\'anglais niveau avancé : grammaire, conversation, business'],
            ['nom' => 'Physique', 'description' => 'Physique générale : mécanique, électricité, optique'],
            ['nom' => 'Chimie', 'description' => 'Chimie organique et inorganique'],
        ];

        $matiereIds = [];
        foreach ($matieres as $matiere) {
            $m = \App\Models\Groupe2Matiere::create($matiere);
            $matiereIds[] = $m->id;
        }

        // Créer des utilisateurs (étudiants et professeurs)
        $professeurUser = User::create([
            'name' => 'Prof. Martin',
            'email' => 'prof.martin@example.com',
            'password' => Hash::make('password123'),
        ]);

        $professeur = \App\Models\Groupe2User::create([
            'user_id' => $professeurUser->id,
            'role' => 'professeur',
        ]);

        $etudiants = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Étudiant {$i}",
                'email' => "etudiant{$i}@example.com",
                'password' => Hash::make('password123'),
            ]);

            \App\Models\Groupe2User::create([
                'user_id' => $user->id,
                'role' => 'etudiant',
            ]);

            $etudiants[] = $user->id;

            // Créer des notes pour chaque étudiant
            foreach ($matiereIds as $matiereId) {
                \App\Models\Groupe2Note::create([
                    'etudiant_id' => \App\Models\Groupe2User::where('user_id', $user->id)->first()->id,
                    'professeur_id' => $professeur->id,
                    'matiere_id' => $matiereId,
                    'note' => rand(10, 20) + (rand(0, 9) / 10), // Note entre 10.0 et 20.0
                    'commentaire' => ['Excellent travail', 'Bon travail', 'Peut mieux faire', 'Très bien'][rand(0, 3)],
                ]);
            }
        }
    }
}
