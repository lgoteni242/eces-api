<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un admin
        $adminUser = User::create([
            'name' => 'Admin RH',
            'email' => 'admin@rh.com',
            'password' => Hash::make('password123'),
        ]);

        \App\Models\Groupe10User::create([
            'user_id' => $adminUser->id,
        ]);

        // Créer des services
        $services = [
            ['nom' => 'Ressources Humaines', 'description' => 'Gestion du personnel et recrutement'],
            ['nom' => 'Informatique', 'description' => 'Support technique et développement'],
            ['nom' => 'Marketing', 'description' => 'Communication et stratégie marketing'],
            ['nom' => 'Finance', 'description' => 'Gestion financière et comptabilité'],
            ['nom' => 'Commercial', 'description' => 'Vente et relation client'],
        ];

        $serviceIds = [];
        foreach ($services as $service) {
            $s = \App\Models\Groupe10Service::create($service);
            $serviceIds[] = $s->id;
        }

        // Créer des employés
        $employes = [];
        for ($i = 1; $i <= 8; $i++) {
            $user = User::create([
                'name' => "Employé {$i}",
                'email' => "employe{$i}@rh.com",
                'password' => Hash::make('password123'),
            ]);

            $groupeUser = \App\Models\Groupe10User::create([
                'user_id' => $user->id,
            ]);

            $employe = \App\Models\Groupe10Employe::create([
                'user_id' => $groupeUser->id,
                'role' => 'employe',
                'service_id' => $serviceIds[array_rand($serviceIds)],
            ]);

            $employes[] = $employe;
        }

        // Créer des congés
        $conges = [
            [
                'employe_id' => $employes[0]->id,
                'date_debut' => now()->addDays(5),
                'date_fin' => now()->addDays(10),
                'raison' => 'Vacances',
                'status' => 'pending',
            ],
            [
                'employe_id' => $employes[1]->id,
                'date_debut' => now()->addDays(15),
                'date_fin' => now()->addDays(20),
                'raison' => 'Vacances familiales',
                'status' => 'approved',
            ],
            [
                'employe_id' => $employes[2]->id,
                'date_debut' => now()->addDays(8),
                'date_fin' => now()->addDays(12),
                'raison' => 'Rendez-vous médicaux',
                'status' => 'pending',
            ],
        ];

        foreach ($conges as $conge) {
            \App\Models\Groupe10Conge::create($conge);
        }
    }
}
