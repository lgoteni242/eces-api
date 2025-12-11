<?php

use Illuminate\Support\Facades\Route;

// Fonction pour récupérer les données des projets
function getProjectsData()
{
    return [
        1 => [
            'id' => 1,
            'name' => 'E-commerce',
            'fullName' => 'Plateforme E-commerce Complète',
            'description' => 'Une plateforme de commerce électronique complète permettant la gestion de produits, paniers d\'achat, commandes et paiements. Les utilisateurs peuvent parcourir un catalogue de produits, ajouter des articles à leur panier, passer des commandes et suivre leur historique d\'achats.',
            'features' => [
                'Gestion complète du catalogue produits',
                'Système de panier d\'achat persistant',
                'Passage de commandes avec validation',
                'Historique des commandes utilisateur',
                'Gestion des catégories et sous-catégories',
                'Recherche et filtrage avancés',
                'Gestion des stocks en temps réel',
                'Système de notation et avis produits'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-1/products', 'desc' => 'Liste tous les produits'],
                ['method' => 'GET', 'path' => '/api/groupe-1/products/{id}', 'desc' => 'Détails d\'un produit'],
                ['method' => 'POST', 'path' => '/api/groupe-1/cart/add', 'desc' => 'Ajouter au panier'],
                ['method' => 'GET', 'path' => '/api/groupe-1/cart', 'desc' => 'Récupérer le panier'],
                ['method' => 'POST', 'path' => '/api/groupe-1/orders', 'desc' => 'Créer une commande'],
                ['method' => 'GET', 'path' => '/api/groupe-1/orders', 'desc' => 'Historique des commandes'],
            ],
            'tech' => ['REST API', 'JWT Auth', 'File Upload', 'Pagination']
        ],
        2 => [
            'id' => 2,
            'name' => 'Gestion Scolaire',
            'fullName' => 'Système de Gestion Scolaire',
            'description' => 'Application complète de gestion académique permettant l\'administration des étudiants, matières, notes et évaluations. Les enseignants peuvent gérer leurs cours, saisir les notes, tandis que les étudiants peuvent consulter leurs résultats et leur progression.',
            'features' => [
                'Gestion des étudiants et enseignants',
                'Création et gestion des matières',
                'Saisie et consultation des notes',
                'Calcul automatique des moyennes',
                'Génération de bulletins de notes',
                'Planning des cours et emploi du temps',
                'Système de présence/absence',
                'Statistiques et rapports académiques'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-2/students', 'desc' => 'Liste des étudiants'],
                ['method' => 'GET', 'path' => '/api/groupe-2/subjects', 'desc' => 'Liste des matières'],
                ['method' => 'POST', 'path' => '/api/groupe-2/grades', 'desc' => 'Enregistrer une note'],
                ['method' => 'GET', 'path' => '/api/groupe-2/grades/student/{id}', 'desc' => 'Notes d\'un étudiant'],
                ['method' => 'GET', 'path' => '/api/groupe-2/reports/{studentId}', 'desc' => 'Bulletin de notes'],
            ],
            'tech' => ['REST API', 'JWT Auth', 'PDF Generation', 'Data Aggregation']
        ],
        3 => [
            'id' => 3,
            'name' => 'Réservation',
            'fullName' => 'Système de Réservation de Salles',
            'description' => 'Plateforme de réservation de salles et ressources permettant aux utilisateurs de réserver des espaces pour des événements, réunions ou activités. Le système inclut un calendrier interactif, gestion des conflits et notifications automatiques.',
            'features' => [
                'Calendrier interactif de réservations',
                'Gestion multi-salles et ressources',
                'Détection automatique des conflits',
                'Notifications par email',
                'Historique des réservations',
                'Statistiques d\'utilisation',
                'Gestion des récurrences',
                'Export calendrier (iCal)'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-3/rooms', 'desc' => 'Liste des salles'],
                ['method' => 'POST', 'path' => '/api/groupe-3/bookings', 'desc' => 'Créer une réservation'],
                ['method' => 'GET', 'path' => '/api/groupe-3/bookings', 'desc' => 'Liste des réservations'],
                ['method' => 'GET', 'path' => '/api/groupe-3/calendar', 'desc' => 'Vue calendrier'],
                ['method' => 'DELETE', 'path' => '/api/groupe-3/bookings/{id}', 'desc' => 'Annuler une réservation'],
            ],
            'tech' => ['REST API', 'Calendar Integration', 'Conflict Detection', 'Email Notifications']
        ],
        4 => [
            'id' => 4,
            'name' => 'Réseau Social',
            'fullName' => 'Plateforme Réseau Social',
            'description' => 'Réseau social complet avec système de publications, interactions sociales (likes, commentaires, partages), gestion de profils utilisateurs, système de followers/following, et feed d\'actualités personnalisé.',
            'features' => [
                'Création et gestion de posts',
                'Système de likes et réactions',
                'Commentaires et réponses',
                'Partage de publications',
                'Système de followers/following',
                'Feed d\'actualités personnalisé',
                'Gestion de profils utilisateurs',
                'Upload de photos et médias'
            ],
            'endpoints' => [
                ['method' => 'POST', 'path' => '/api/groupe-4/posts', 'desc' => 'Créer un post'],
                ['method' => 'GET', 'path' => '/api/groupe-4/posts', 'desc' => 'Feed des posts'],
                ['method' => 'POST', 'path' => '/api/groupe-4/posts/{id}/like', 'desc' => 'Liker un post'],
                ['method' => 'POST', 'path' => '/api/groupe-4/posts/{id}/comments', 'desc' => 'Commenter'],
                ['method' => 'POST', 'path' => '/api/groupe-4/users/{id}/follow', 'desc' => 'Suivre un utilisateur'],
            ],
            'tech' => ['REST API', 'Real-time Updates', 'Media Upload', 'Feed Algorithm']
        ],
        5 => [
            'id' => 5,
            'name' => 'Gestion Tâches',
            'fullName' => 'Gestionnaire de Projets et Tâches',
            'description' => 'Application de gestion de projets style Kanban avec création de tâches, assignation aux membres d\'équipe, suivi de progression, deadlines, et collaboration en temps réel. Parfait pour la gestion agile de projets.',
            'features' => [
                'Tableau Kanban interactif',
                'Création et assignation de tâches',
                'Système de priorités et labels',
                'Suivi de progression',
                'Gestion des deadlines',
                'Commentaires et pièces jointes',
                'Historique des activités',
                'Rapports de productivité'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-5/projects', 'desc' => 'Liste des projets'],
                ['method' => 'POST', 'path' => '/api/groupe-5/tasks', 'desc' => 'Créer une tâche'],
                ['method' => 'PUT', 'path' => '/api/groupe-5/tasks/{id}', 'desc' => 'Mettre à jour une tâche'],
                ['method' => 'GET', 'path' => '/api/groupe-5/board/{projectId}', 'desc' => 'Vue Kanban'],
            ],
            'tech' => ['REST API', 'Kanban Board', 'Task Management', 'Team Collaboration']
        ],
        6 => [
            'id' => 6,
            'name' => 'Apprentissage',
            'fullName' => 'Plateforme E-Learning',
            'description' => 'Système d\'apprentissage en ligne complet avec catalogue de cours, leçons vidéo, quiz interactifs, suivi de progression, certificats et système de notation. Les étudiants peuvent suivre leur progression et obtenir des certifications.',
            'features' => [
                'Catalogue de cours structuré',
                'Leçons vidéo et documents',
                'Quiz et évaluations',
                'Suivi de progression',
                'Système de certificats',
                'Notes et commentaires',
                'Forum de discussion',
                'Statistiques d\'apprentissage'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-6/courses', 'desc' => 'Liste des cours'],
                ['method' => 'GET', 'path' => '/api/groupe-6/courses/{id}/lessons', 'desc' => 'Leçons d\'un cours'],
                ['method' => 'POST', 'path' => '/api/groupe-6/enrollments', 'desc' => 'S\'inscrire à un cours'],
                ['method' => 'GET', 'path' => '/api/groupe-6/progress', 'desc' => 'Progression de l\'étudiant'],
            ],
            'tech' => ['REST API', 'Video Streaming', 'Progress Tracking', 'Certificates']
        ],
        7 => [
            'id' => 7,
            'name' => 'Budget',
            'fullName' => 'Application de Gestion Budgétaire',
            'description' => 'Application personnelle de gestion financière permettant de suivre les revenus, dépenses, créer des budgets, visualiser les tendances avec des graphiques, et recevoir des alertes de dépassement budgétaire.',
            'features' => [
                'Suivi des revenus et dépenses',
                'Création de budgets par catégorie',
                'Graphiques et visualisations',
                'Alertes de dépassement',
                'Historique des transactions',
                'Export de rapports',
                'Catégorisation automatique',
                'Objectifs d\'épargne'
            ],
            'endpoints' => [
                ['method' => 'POST', 'path' => '/api/groupe-7/transactions', 'desc' => 'Enregistrer une transaction'],
                ['method' => 'GET', 'path' => '/api/groupe-7/transactions', 'desc' => 'Historique des transactions'],
                ['method' => 'POST', 'path' => '/api/groupe-7/budgets', 'desc' => 'Créer un budget'],
                ['method' => 'GET', 'path' => '/api/groupe-7/analytics', 'desc' => 'Statistiques et graphiques'],
            ],
            'tech' => ['REST API', 'Data Visualization', 'Budget Analytics', 'Export Reports']
        ],
        8 => [
            'id' => 8,
            'name' => 'Avis Restaurants',
            'fullName' => 'Plateforme d\'Avis Restaurants et Hôtels',
            'description' => 'Plateforme communautaire de notation et d\'avis pour restaurants, hôtels et établissements. Les utilisateurs peuvent noter, commenter, ajouter des photos, et découvrir de nouveaux endroits basés sur les recommandations.',
            'features' => [
                'Base de données d\'établissements',
                'Système de notation (1-5 étoiles)',
                'Commentaires et avis détaillés',
                'Upload de photos',
                'Recherche et filtres',
                'Recommandations personnalisées',
                'Gestion de favoris',
                'Statistiques d\'établissements'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-8/establishments', 'desc' => 'Liste des établissements'],
                ['method' => 'POST', 'path' => '/api/groupe-8/reviews', 'desc' => 'Créer un avis'],
                ['method' => 'GET', 'path' => '/api/groupe-8/reviews/{establishmentId}', 'desc' => 'Avis d\'un établissement'],
                ['method' => 'POST', 'path' => '/api/groupe-8/favorites', 'desc' => 'Ajouter aux favoris'],
            ],
            'tech' => ['REST API', 'Rating System', 'Image Upload', 'Recommendation Engine']
        ],
        9 => [
            'id' => 9,
            'name' => 'Événements',
            'fullName' => 'Gestionnaire d\'Événements et Billetterie',
            'description' => 'Système complet de gestion d\'événements permettant la création d\'événements, gestion des inscriptions, billetterie en ligne, check-in, et statistiques de participation. Idéal pour conférences, concerts, et événements communautaires.',
            'features' => [
                'Création et gestion d\'événements',
                'Système de billetterie',
                'Inscription en ligne',
                'Check-in QR code',
                'Gestion des capacités',
                'Statistiques de participation',
                'Notifications automatiques',
                'Export de listes'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-9/events', 'desc' => 'Liste des événements'],
                ['method' => 'POST', 'path' => '/api/groupe-9/events', 'desc' => 'Créer un événement'],
                ['method' => 'POST', 'path' => '/api/groupe-9/registrations', 'desc' => 'S\'inscrire à un événement'],
                ['method' => 'GET', 'path' => '/api/groupe-9/tickets/{userId}', 'desc' => 'Billets d\'un utilisateur'],
            ],
            'tech' => ['REST API', 'QR Code Generation', 'Ticket Management', 'Event Analytics']
        ],
        10 => [
            'id' => 10,
            'name' => 'Plateforme RH',
            'fullName' => 'Système de Gestion des Ressources Humaines',
            'description' => 'Portail RH complet pour la gestion des employés, congés, absences, évaluations de performance, formations, et annuaire d\'entreprise. Les employés peuvent consulter leurs informations, demander des congés, et accéder à leur historique.',
            'features' => [
                'Annuaire des employés',
                'Gestion des congés et absences',
                'Demandes de congés en ligne',
                'Suivi des présences',
                'Évaluations de performance',
                'Gestion des formations',
                'Historique professionnel',
                'Statistiques RH'
            ],
            'endpoints' => [
                ['method' => 'GET', 'path' => '/api/groupe-10/employees', 'desc' => 'Liste des employés'],
                ['method' => 'POST', 'path' => '/api/groupe-10/leave-requests', 'desc' => 'Demander un congé'],
                ['method' => 'GET', 'path' => '/api/groupe-10/attendance', 'desc' => 'Pointage et présences'],
                ['method' => 'GET', 'path' => '/api/groupe-10/profile', 'desc' => 'Profil employé'],
            ],
            'tech' => ['REST API', 'HR Management', 'Leave Management', 'Employee Portal']
        ],
    ];
}

Route::get('/', function () {
    $projects = getProjectsData();
    return view('welcome', ['projects' => $projects]);
});

// Routes pour les projets individuels
Route::get('/projet/{id}', function ($id) {
    $id = (int) $id;
    $projects = getProjectsData();

    if (!isset($projects[$id])) {
        abort(404);
    }

    return view('projet', ['project' => $projects[$id]]);
})->where('id', '[1-9]|10');
