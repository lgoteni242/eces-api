<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe7Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur
        $user = User::create([
            'name' => 'Gestionnaire Budget',
            'email' => 'budget@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Créer des catégories
        $categories = [
            ['nom' => 'Alimentation', 'type' => 'depense', 'couleur' => '#FF5733'],
            ['nom' => 'Transport', 'type' => 'depense', 'couleur' => '#33C3F0'],
            ['nom' => 'Loisirs', 'type' => 'depense', 'couleur' => '#9B59B6'],
            ['nom' => 'Santé', 'type' => 'depense', 'couleur' => '#E74C3C'],
            ['nom' => 'Logement', 'type' => 'depense', 'couleur' => '#F39C12'],
            ['nom' => 'Salaire', 'type' => 'revenu', 'couleur' => '#27AE60'],
            ['nom' => 'Freelance', 'type' => 'revenu', 'couleur' => '#16A085'],
            ['nom' => 'Investissements', 'type' => 'revenu', 'couleur' => '#3498DB'],
        ];

        $categorieIds = [];
        foreach ($categories as $categorie) {
            $c = \App\Models\Groupe7Categorie::create($categorie);
            $categorieIds[] = $c->id;
        }

        // Séparer les catégories par type
        $depenseIds = array_filter($categorieIds, function ($id) use ($categories, $categorieIds) {
            $index = array_search($id, $categorieIds);
            return $categories[$index]['type'] === 'depense';
        });
        $revenuIds = array_filter($categorieIds, function ($id) use ($categories, $categorieIds) {
            $index = array_search($id, $categorieIds);
            return $categories[$index]['type'] === 'revenu';
        });

        // Créer des transactions (dépenses)
        $depenses = [
            ['montant' => 45.50, 'description' => 'Courses supermarché', 'date' => now()->subDays(2)],
            ['montant' => 12.00, 'description' => 'Transport en commun', 'date' => now()->subDays(1)],
            ['montant' => 25.00, 'description' => 'Restaurant', 'date' => now()->subDays(3)],
            ['montant' => 80.00, 'description' => 'Pharmacie', 'date' => now()->subDays(5)],
            ['montant' => 15.50, 'description' => 'Cinéma', 'date' => now()->subDays(4)],
        ];

        foreach ($depenses as $depense) {
            \App\Models\Groupe7Transaction::create([
                'user_id' => $user->id,
                'type' => 'depense',
                'montant' => $depense['montant'],
                'categorie_id' => $depenseIds[array_rand($depenseIds)],
                'date' => $depense['date'],
                'description' => $depense['description'],
            ]);
        }

        // Créer des transactions (revenus)
        $revenus = [
            ['montant' => 2500.00, 'description' => 'Salaire mensuel', 'date' => now()->subDays(10)],
            ['montant' => 500.00, 'description' => 'Projet freelance', 'date' => now()->subDays(7)],
            ['montant' => 150.00, 'description' => 'Vente en ligne', 'date' => now()->subDays(3)],
        ];

        foreach ($revenus as $revenu) {
            \App\Models\Groupe7Transaction::create([
                'user_id' => $user->id,
                'type' => 'revenu',
                'montant' => $revenu['montant'],
                'categorie_id' => $revenuIds[array_rand($revenuIds)],
                'date' => $revenu['date'],
                'description' => $revenu['description'],
            ]);
        }
    }
}
