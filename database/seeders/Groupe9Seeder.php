<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe9Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des événements
        $evenements = [
            [
                'titre' => 'Concert Jazz en Plein Air',
                'description' => 'Concert de jazz avec plusieurs groupes locaux dans le parc central',
                'date' => now()->addDays(15)->setTime(20, 0),
                'lieu' => 'Parc Central, 75001 Paris',
                'categorie' => 'concert',
                'capacite_max' => 200,
            ],
            [
                'titre' => 'Conférence Tech 2025',
                'description' => 'Conférence sur les dernières tendances technologiques',
                'date' => now()->addDays(20)->setTime(9, 0),
                'lieu' => 'Centre de Congrès, 75008 Paris',
                'categorie' => 'conference',
                'capacite_max' => 500,
            ],
            [
                'titre' => 'Festival de Cuisine',
                'description' => 'Découvrez les spécialités culinaires de différentes régions',
                'date' => now()->addDays(25)->setTime(12, 0),
                'lieu' => 'Place de la République, 75003 Paris',
                'categorie' => 'festival',
                'capacite_max' => 1000,
            ],
            [
                'titre' => 'Atelier Photographie',
                'description' => 'Apprenez les bases de la photographie avec un professionnel',
                'date' => now()->addDays(10)->setTime(14, 0),
                'lieu' => 'Studio Photo, 75011 Paris',
                'categorie' => 'atelier',
                'capacite_max' => 20,
            ],
        ];

        $evenementIds = [];
        foreach ($evenements as $evenement) {
            $e = \App\Models\Groupe9Evenement::create($evenement);
            $evenementIds[] = $e->id;
        }

        // Créer des utilisateurs
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Participant {$i}",
                'email' => "participant{$i}@example.com",
                'password' => Hash::make('password123'),
            ]);
            $users[] = $user;
        }

        // Créer des inscriptions
        foreach ($evenementIds as $evenementId) {
            // Inscrire 2-4 utilisateurs par événement
            $inscrits = array_rand($users, rand(2, min(4, count($users))));
            if (!is_array($inscrits)) {
                $inscrits = [$inscrits];
            }
            foreach ($inscrits as $inscritIndex) {
                \App\Models\Groupe9Inscription::create([
                    'user_id' => $users[$inscritIndex]->id,
                    'evenement_id' => $evenementId,
                ]);
            }
        }
    }
}
