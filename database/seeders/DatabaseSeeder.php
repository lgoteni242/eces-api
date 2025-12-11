<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            Groupe1Seeder::class,
            Groupe2Seeder::class,
            Groupe3Seeder::class,
            Groupe4Seeder::class,
            Groupe5Seeder::class,
            Groupe6Seeder::class,
            Groupe7Seeder::class,
            Groupe8Seeder::class,
            Groupe9Seeder::class,
            Groupe10Seeder::class,
        ]);
    }
}
