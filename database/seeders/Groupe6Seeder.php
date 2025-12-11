<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe6Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un formateur
        $formateurUser = User::create([
            'name' => 'Formateur Expert',
            'email' => 'formateur@example.com',
            'password' => Hash::make('password123'),
        ]);

        $formateur = \App\Models\Groupe6User::create([
            'user_id' => $formateurUser->id,
            'role' => 'formateur',
        ]);

        // Créer des cours
        $cours = [
            [
                'titre' => 'Développement Web avec React',
                'description' => 'Apprenez React de A à Z : hooks, state management, routing',
            ],
            [
                'titre' => 'Laravel Backend',
                'description' => 'Maîtrisez Laravel : routes, controllers, migrations, Eloquent',
            ],
            [
                'titre' => 'JavaScript Avancé',
                'description' => 'ES6+, async/await, promises, design patterns',
            ],
        ];

        $coursIds = [];
        foreach ($cours as $cour) {
            $c = \App\Models\Groupe6Cours::create([
                'formateur_id' => $formateur->id,
                'titre' => $cour['titre'],
                'description' => $cour['description'],
                'image' => ImageHelper::course(),
            ]);
            $coursIds[] = $c->id;
        }

        // Créer des leçons pour chaque cours
        $leconsParCours = [
            [
                ['titre' => 'Introduction à React', 'contenu' => 'Découvrez React et son écosystème', 'video_url' => 'https://youtube.com/watch?v=demo1', 'ordre' => 1],
                ['titre' => 'Composants et Props', 'contenu' => 'Créer et utiliser des composants', 'video_url' => 'https://youtube.com/watch?v=demo2', 'ordre' => 2],
                ['titre' => 'State et Hooks', 'contenu' => 'Gérer l\'état avec useState et useEffect', 'video_url' => 'https://youtube.com/watch?v=demo3', 'ordre' => 3],
            ],
            [
                ['titre' => 'Installation Laravel', 'contenu' => 'Installer et configurer Laravel', 'video_url' => 'https://youtube.com/watch?v=demo4', 'ordre' => 1],
                ['titre' => 'Routes et Controllers', 'contenu' => 'Créer des routes et controllers', 'video_url' => 'https://youtube.com/watch?v=demo5', 'ordre' => 2],
                ['titre' => 'Migrations et Modèles', 'contenu' => 'Gérer la base de données avec Eloquent', 'video_url' => 'https://youtube.com/watch?v=demo6', 'ordre' => 3],
            ],
            [
                ['titre' => 'ES6+ Features', 'contenu' => 'Arrow functions, destructuring, spread', 'video_url' => 'https://youtube.com/watch?v=demo7', 'ordre' => 1],
                ['titre' => 'Promises et Async/Await', 'contenu' => 'Gérer l\'asynchrone en JavaScript', 'video_url' => 'https://youtube.com/watch?v=demo8', 'ordre' => 2],
                ['titre' => 'Design Patterns', 'contenu' => 'Patterns courants en JavaScript', 'video_url' => 'https://youtube.com/watch?v=demo9', 'ordre' => 3],
            ],
        ];

        foreach ($coursIds as $index => $coursId) {
            foreach ($leconsParCours[$index] as $lecon) {
                \App\Models\Groupe6Lecon::create([
                    'cours_id' => $coursId,
                    ...$lecon,
                ]);
            }
        }

        // Créer un étudiant
        $etudiantUser = User::create([
            'name' => 'Étudiant Apprenant',
            'email' => 'etudiant@example.com',
            'password' => Hash::make('password123'),
        ]);

        \App\Models\Groupe6User::create([
            'user_id' => $etudiantUser->id,
            'role' => 'etudiant',
        ]);
    }
}
