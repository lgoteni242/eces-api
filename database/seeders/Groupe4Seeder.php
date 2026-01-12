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

        // Créer des messages de chat
        $chatMessages = [
            ['message' => 'Salut ! Comment ça va ?', 'is_read' => true],
            ['message' => 'Ça va bien, merci ! Et toi ?', 'is_read' => true],
            ['message' => 'Super ! On se voit demain ?', 'is_read' => false],
            ['message' => 'Bonjour, tu as vu mon dernier post ?', 'is_read' => false],
            ['message' => 'Oui, très intéressant ! 👍', 'is_read' => true],
            ['message' => 'Merci ! Ça me fait plaisir', 'is_read' => false],
            ['message' => 'Hey, tu veux qu\'on travaille ensemble sur le projet ?', 'is_read' => false],
            ['message' => 'Bien sûr ! On se retrouve à la bibliothèque ?', 'is_read' => false],
            ['message' => 'Parfait, à 14h ?', 'is_read' => false],
            ['message' => 'D\'accord, à tout à l\'heure !', 'is_read' => false],
        ];

        // Créer des conversations entre différents utilisateurs
        for ($i = 0; $i < count($users) - 1; $i++) {
            $sender = $users[$i];
            $receiver = $users[$i + 1];
            
            // Créer 2-3 messages par conversation
            $numMessages = rand(2, 3);
            for ($j = 0; $j < $numMessages; $j++) {
                $messageData = $chatMessages[array_rand($chatMessages)];
                \App\Models\Groupe4Message::create([
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'message' => $messageData['message'],
                    'is_read' => $messageData['is_read'],
                    'read_at' => $messageData['is_read'] ? now()->subHours(rand(1, 24)) : null,
                    'created_at' => now()->subHours(rand(1, 48)),
                ]);
            }
        }

        // Créer quelques messages supplémentaires entre utilisateurs aléatoires
        for ($i = 0; $i < 5; $i++) {
            $randomUsers = array_rand($users, 2);
            if ($randomUsers[0] != $randomUsers[1]) {
                $messageData = $chatMessages[array_rand($chatMessages)];
                \App\Models\Groupe4Message::create([
                    'sender_id' => $users[$randomUsers[0]]->id,
                    'receiver_id' => $users[$randomUsers[1]]->id,
                    'message' => $messageData['message'],
                    'is_read' => $messageData['is_read'],
                    'read_at' => $messageData['is_read'] ? now()->subHours(rand(1, 24)) : null,
                    'created_at' => now()->subHours(rand(1, 48)),
                ]);
            }
        }
    }
}
