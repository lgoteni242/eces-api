<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Groupe1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Dell XPS 15',
                'description' => 'Ordinateur portable haut de gamme avec écran 15 pouces, processeur Intel i7, 16GB RAM, SSD 512GB',
                'price' => 1299.99,
                'stock' => 10,
            ],
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Smartphone Apple dernière génération avec écran Super Retina XDR, 256GB de stockage',
                'price' => 999.99,
                'stock' => 25,
            ],
            [
                'name' => 'Samsung Galaxy Watch 6',
                'description' => 'Montre connectée Samsung avec suivi santé avancé, GPS intégré',
                'price' => 299.99,
                'stock' => 15,
            ],
            [
                'name' => 'MacBook Pro 14"',
                'description' => 'Ordinateur portable Apple avec puce M3 Pro, 18GB RAM, SSD 1TB',
                'price' => 2199.99,
                'stock' => 8,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Casque audio sans fil avec réduction de bruit active',
                'price' => 399.99,
                'stock' => 20,
            ],
            [
                'name' => 'iPad Air',
                'description' => 'Tablette Apple 10.9 pouces avec puce M1, 256GB',
                'price' => 749.99,
                'stock' => 12,
            ],
            [
                'name' => 'Nintendo Switch OLED',
                'description' => 'Console de jeu portable avec écran OLED 7 pouces',
                'price' => 349.99,
                'stock' => 18,
            ],
            [
                'name' => 'Logitech MX Master 3S',
                'description' => 'Souris sans fil ergonomique pour professionnels',
                'price' => 99.99,
                'stock' => 30,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Groupe1Product::create([
                ...$product,
                'image' => ImageHelper::product(),
            ]);
        }
    }
}
