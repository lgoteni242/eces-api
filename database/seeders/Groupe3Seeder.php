<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des salles
        $salles = [
            [
                'nom' => 'Salle de réunion A',
                'capacite' => 20,
                'equipements' => 'Projecteur, Tableau blanc, Wi-Fi',
                'description' => 'Salle de réunion principale au 1er étage',
            ],
            [
                'nom' => 'Salle de conférence B',
                'capacite' => 50,
                'equipements' => 'Projecteur, Micro, Tableau interactif, Système audio',
                'description' => 'Grande salle de conférence au rez-de-chaussée',
            ],
            [
                'nom' => 'Salle de formation C',
                'capacite' => 30,
                'equipements' => 'Projecteur, Tableau blanc, 30 postes informatiques',
                'description' => 'Salle dédiée à la formation avec équipements informatiques',
            ],
            [
                'nom' => 'Salle créative D',
                'capacite' => 15,
                'equipements' => 'Tableau blanc, Wi-Fi, Espace collaboratif',
                'description' => 'Petite salle pour brainstorming et réunions créatives',
            ],
        ];

        $salleIds = [];
        foreach ($salles as $salle) {
            $s = \App\Models\Groupe3Salle::create($salle);
            $salleIds[] = $s->id;
        }

        // Créer des utilisateurs
        $user = User::create([
            'name' => 'Utilisateur Réservation',
            'email' => 'reservation@example.com',
            'password' => Hash::make('password123'),
        ]);

        \App\Models\Groupe3User::create([
            'user_id' => $user->id,
            'role' => 'user',
        ]);

        // Créer quelques réservations
        $dates = [
            now()->addDays(1)->setTime(9, 0),
            now()->addDays(2)->setTime(14, 0),
            now()->addDays(3)->setTime(10, 0),
        ];

        foreach ($dates as $date) {
            \App\Models\Groupe3Reservation::create([
                'user_id' => $user->id,
                'salle_id' => $salleIds[array_rand($salleIds)],
                'date_debut' => $date,
                'date_fin' => $date->copy()->addHours(2),
                'raison' => ['Réunion équipe', 'Formation', 'Présentation client', 'Brainstorming'][rand(0, 3)],
                'status' => 'confirmed',
            ]);
        }
    }
}
