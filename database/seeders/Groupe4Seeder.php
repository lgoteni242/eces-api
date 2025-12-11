<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Groupe4Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des utilisateurs
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "User {$i}",
                'email' => "user{$i}@social.com",
                'password' => Hash::make('password123'),
            ]);

            $users[] = $user;

            // Créer un profil pour chaque utilisateur
            \App\Models\Groupe4Profil::create([
                'user_id' => $user->id,
                'bio' => "Bio de l'utilisateur {$i}",
                'avatar' => ImageHelper::avatar(),
            ]);
        }

        // Créer des posts
        $posts = [
            ['contenu' => 'Super journée aujourd\'hui ! ☀️'],
            ['contenu' => 'Nouveau projet en cours, très excité ! 🚀'],
            ['contenu' => 'Juste fini un excellent livre 📚'],
            ['contenu' => 'Weekend parfait avec des amis 🎉'],
            ['contenu' => 'Nouvelle recette testée, délicieuse ! 🍰'],
            ['contenu' => 'Formation terminée, beaucoup appris 💡'],
            ['contenu' => 'Voyage incroyable, photos à venir 📸'],
            ['contenu' => 'Nouveau défi personnel accepté ! 💪'],
        ];

        $postIds = [];
        foreach ($posts as $index => $post) {
            $p = \App\Models\Groupe4Post::create([
                'user_id' => $users[$index % count($users)]->id,
                'contenu' => $post['contenu'],
                'image' => rand(0, 1) ? ImageHelper::post() : null, // 50% de chance d'avoir une image
            ]);
            $postIds[] = $p->id;
        }

        // Créer des likes
        foreach ($postIds as $postId) {
            $likers = array_rand($users, rand(1, min(3, count($users))));
            if (!is_array($likers)) {
                $likers = [$likers];
            }
            foreach ($likers as $likerIndex) {
                \App\Models\Groupe4Like::create([
                    'user_id' => $users[$likerIndex]->id,
                    'post_id' => $postId,
                ]);
            }
        }

        // Créer des commentaires
        $comments = [
            'Super ! 👍',
            'Très intéressant !',
            'J\'adore ! ❤️',
            'Merci pour le partage',
            'Excellent !',
        ];

        foreach ($postIds as $postId) {
            $commenters = array_rand($users, rand(1, min(2, count($users))));
            if (!is_array($commenters)) {
                $commenters = [$commenters];
            }
            foreach ($commenters as $commenterIndex) {
                \App\Models\Groupe4Comment::create([
                    'user_id' => $users[$commenterIndex]->id,
                    'post_id' => $postId,
                    'contenu' => $comments[array_rand($comments)],
                ]);
            }
        }
    }
}
