<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe8Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des établissements
        $etablissements = [
            [
                'nom' => 'Le Bon Restaurant',
                'type' => 'restaurant',
                'adresse' => '123 Rue de la Gastronomie, 75001 Paris',
                'telephone' => '01 23 45 67 89',
                'description' => 'Restaurant français traditionnel avec spécialités régionales',
            ],
            [
                'nom' => 'Hôtel Plaza',
                'type' => 'hotel',
                'adresse' => '456 Avenue du Luxe, 75008 Paris',
                'telephone' => '01 98 76 54 32',
                'description' => 'Hôtel 5 étoiles en centre-ville avec spa et restaurant gastronomique',
            ],
            [
                'nom' => 'La Brasserie Moderne',
                'type' => 'restaurant',
                'adresse' => '789 Boulevard des Chefs, 75006 Paris',
                'telephone' => '01 55 44 33 22',
                'description' => 'Brasserie moderne avec cuisine fusion',
            ],
            [
                'nom' => 'Hôtel Central',
                'type' => 'hotel',
                'adresse' => '321 Rue Centrale, 75004 Paris',
                'telephone' => '01 11 22 33 44',
                'description' => 'Hôtel 4 étoiles au cœur de Paris',
            ],
        ];

        $etablissementIds = [];
        foreach ($etablissements as $etablissement) {
            $e = \App\Models\Groupe8Etablissement::create($etablissement);
            $etablissementIds[] = $e->id;
        }

        // Créer des utilisateurs pour les avis
        $users = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Avis User {$i}",
                'email' => "avis{$i}@example.com",
                'password' => Hash::make('password123'),
            ]);
            $users[] = $user;
        }

        // Créer des avis pour chaque établissement
        $commentaires = [
            'Excellent établissement, je recommande !',
            'Très bon service et qualité au rendez-vous',
            'Expérience agréable, à refaire',
            'Parfait pour un dîner en amoureux',
            'Service impeccable, personnel très professionnel',
            'Cuisine délicieuse, prix raisonnables',
        ];

        foreach ($etablissementIds as $etablissementId) {
            // Créer 3-5 avis par établissement avec des utilisateurs différents
            $shuffledUsers = $users;
            shuffle($shuffledUsers);
            $avisCount = min(rand(3, 5), count($shuffledUsers));

            for ($i = 0; $i < $avisCount; $i++) {
                \App\Models\Groupe8Avis::create([
                    'user_id' => $shuffledUsers[$i]->id,
                    'etablissement_id' => $etablissementId,
                    'note' => rand(3, 5), // Note entre 3 et 5
                    'commentaire' => $commentaires[array_rand($commentaires)],
                ]);
            }
        }
    }
}
