<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe5Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur
        $user = User::create([
            'name' => 'Gestionnaire Projets',
            'email' => 'projets@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Créer des projets
        $projets = [
            [
                'nom' => 'Site Web E-commerce',
                'description' => 'Développement d\'un site e-commerce complet avec panier et paiement',
            ],
            [
                'nom' => 'Application Mobile',
                'description' => 'Application mobile iOS et Android pour gestion de tâches',
            ],
            [
                'nom' => 'API REST',
                'description' => 'Développement d\'une API REST pour système de gestion',
            ],
        ];

        $projetIds = [];
        foreach ($projets as $projet) {
            $p = \App\Models\Groupe5Projet::create([
                'user_id' => $user->id,
                ...$projet,
            ]);
            $projetIds[] = $p->id;
        }

        // Créer des tâches pour chaque projet
        $tachesParProjet = [
            [
                ['titre' => 'Design de l\'interface', 'description' => 'Créer les maquettes UI/UX', 'priorite' => 'high', 'status' => 'todo'],
                ['titre' => 'Développement frontend', 'description' => 'Implémenter les composants React', 'priorite' => 'high', 'status' => 'doing'],
                ['titre' => 'Intégration API', 'description' => 'Connecter le frontend à l\'API', 'priorite' => 'medium', 'status' => 'todo'],
                ['titre' => 'Tests unitaires', 'description' => 'Écrire les tests pour les composants', 'priorite' => 'medium', 'status' => 'todo'],
            ],
            [
                ['titre' => 'Architecture de l\'app', 'description' => 'Définir l\'architecture mobile', 'priorite' => 'high', 'status' => 'done'],
                ['titre' => 'Développement iOS', 'description' => 'Coder l\'application iOS en Swift', 'priorite' => 'high', 'status' => 'doing'],
                ['titre' => 'Développement Android', 'description' => 'Coder l\'application Android en Kotlin', 'priorite' => 'high', 'status' => 'todo'],
                ['titre' => 'Tests sur appareils', 'description' => 'Tester sur différents appareils', 'priorite' => 'low', 'status' => 'todo'],
            ],
            [
                ['titre' => 'Design de l\'API', 'description' => 'Créer la documentation OpenAPI', 'priorite' => 'high', 'status' => 'done'],
                ['titre' => 'Implémentation endpoints', 'description' => 'Développer tous les endpoints', 'priorite' => 'high', 'status' => 'doing'],
                ['titre' => 'Authentification', 'description' => 'Implémenter JWT auth', 'priorite' => 'high', 'status' => 'done'],
                ['titre' => 'Tests API', 'description' => 'Tests d\'intégration et unitaires', 'priorite' => 'medium', 'status' => 'todo'],
            ],
        ];

        foreach ($projetIds as $index => $projetId) {
            foreach ($tachesParProjet[$index] as $tache) {
                \App\Models\Groupe5Tache::create([
                    'projet_id' => $projetId,
                    'user_id' => $user->id,
                    ...$tache,
                ]);
            }
        }
    }
}
