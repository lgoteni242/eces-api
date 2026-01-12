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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-1/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-1/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-1/auth/logout', 'desc' => 'Se déconnecter'],
                // Products (Public)
                ['method' => 'GET', 'path' => '/api/groupe-1/products', 'desc' => 'Liste tous les produits'],
                ['method' => 'GET', 'path' => '/api/groupe-1/products/{id}', 'desc' => 'Détails d\'un produit'],
                // Cart (Protected)
                ['method' => 'GET', 'path' => '/api/groupe-1/cart', 'desc' => 'Récupérer le panier'],
                ['method' => 'POST', 'path' => '/api/groupe-1/cart', 'desc' => 'Ajouter au panier'],
                ['method' => 'PUT', 'path' => '/api/groupe-1/cart/{id}', 'desc' => 'Modifier quantité panier'],
                ['method' => 'DELETE', 'path' => '/api/groupe-1/cart/{id}', 'desc' => 'Retirer du panier'],
                // Orders (Protected)
                ['method' => 'GET', 'path' => '/api/groupe-1/orders', 'desc' => 'Historique des commandes'],
                ['method' => 'POST', 'path' => '/api/groupe-1/orders', 'desc' => 'Créer une commande'],
                ['method' => 'GET', 'path' => '/api/groupe-1/orders/{id}', 'desc' => 'Détails d\'une commande'],
                // Admin
                ['method' => 'POST', 'path' => '/api/groupe-1/admin/products', 'desc' => 'Créer un produit (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-1/admin/products/{id}', 'desc' => 'Modifier un produit (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-1/admin/products/{id}', 'desc' => 'Supprimer un produit (Admin)'],
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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-2/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-2/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-2/auth/logout', 'desc' => 'Se déconnecter'],
                // Matières
                ['method' => 'GET', 'path' => '/api/groupe-2/matieres', 'desc' => 'Liste des matières'],
                ['method' => 'POST', 'path' => '/api/groupe-2/matieres', 'desc' => 'Créer une matière'],
                ['method' => 'GET', 'path' => '/api/groupe-2/matieres/{id}', 'desc' => 'Détails d\'une matière'],
                ['method' => 'PUT', 'path' => '/api/groupe-2/matieres/{id}', 'desc' => 'Modifier une matière'],
                ['method' => 'DELETE', 'path' => '/api/groupe-2/matieres/{id}', 'desc' => 'Supprimer une matière'],
                // Notes
                ['method' => 'GET', 'path' => '/api/groupe-2/notes', 'desc' => 'Liste des notes'],
                ['method' => 'POST', 'path' => '/api/groupe-2/notes', 'desc' => 'Enregistrer une note'],
                ['method' => 'GET', 'path' => '/api/groupe-2/notes/{id}', 'desc' => 'Détails d\'une note'],
                ['method' => 'PUT', 'path' => '/api/groupe-2/notes/{id}', 'desc' => 'Modifier une note'],
                // Admin
                ['method' => 'GET', 'path' => '/api/groupe-2/admin/dashboard', 'desc' => 'Tableau de bord admin'],
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
                'Gestion des prix par salle',
                'Upload et affichage d\'images des salles',
                'Historique des réservations',
                'Gestion admin complète (CRUD salles)',
                'Suppression admin des réservations'
            ],
            'endpoints' => [
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-3/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-3/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-3/auth/logout', 'desc' => 'Se déconnecter'],
                // Salles (Public)
                ['method' => 'GET', 'path' => '/api/groupe-3/salles', 'desc' => 'Liste des salles'],
                ['method' => 'GET', 'path' => '/api/groupe-3/salles/{id}', 'desc' => 'Détails d\'une salle'],
                ['method' => 'GET', 'path' => '/api/groupe-3/salles/{id}/images', 'desc' => 'Images d\'une salle'],
                // Réservations (Protected)
                ['method' => 'GET', 'path' => '/api/groupe-3/reservations', 'desc' => 'Mes réservations'],
                ['method' => 'POST', 'path' => '/api/groupe-3/reservations', 'desc' => 'Créer une réservation'],
                ['method' => 'DELETE', 'path' => '/api/groupe-3/reservations/{id}', 'desc' => 'Annuler ma réservation'],
                ['method' => 'GET', 'path' => '/api/groupe-3/reservations/calendrier', 'desc' => 'Vue calendrier'],
                // Admin
                ['method' => 'POST', 'path' => '/api/groupe-3/admin/salles', 'desc' => 'Créer une salle (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-3/admin/salles/{id}', 'desc' => 'Modifier une salle (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-3/admin/salles/{id}', 'desc' => 'Supprimer une salle (Admin)'],
                ['method' => 'POST', 'path' => '/api/groupe-3/admin/salles/{id}/images', 'desc' => 'Upload image salle (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-3/admin/images/{id}', 'desc' => 'Supprimer image (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-3/admin/reservations/{id}', 'desc' => 'Supprimer réservation (Admin)'],
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
                'Système de chat en temps réel',
                'Conversations et messages privés',
                'Feed d\'actualités personnalisé',
                'Gestion de profils utilisateurs',
                'Upload de photos et médias',
                'Compteur de messages non lus'
            ],
            'endpoints' => [
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-4/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-4/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-4/auth/logout', 'desc' => 'Se déconnecter'],
                // Posts
                ['method' => 'GET', 'path' => '/api/groupe-4/posts', 'desc' => 'Feed des posts'],
                ['method' => 'POST', 'path' => '/api/groupe-4/posts', 'desc' => 'Créer un post'],
                ['method' => 'GET', 'path' => '/api/groupe-4/posts/{id}', 'desc' => 'Détails d\'un post'],
                ['method' => 'PUT', 'path' => '/api/groupe-4/posts/{id}', 'desc' => 'Modifier un post'],
                ['method' => 'DELETE', 'path' => '/api/groupe-4/posts/{id}', 'desc' => 'Supprimer un post'],
                ['method' => 'GET', 'path' => '/api/groupe-4/feed', 'desc' => 'Feed personnalisé'],
                // Likes
                ['method' => 'POST', 'path' => '/api/groupe-4/posts/{id}/like', 'desc' => 'Liker un post'],
                ['method' => 'DELETE', 'path' => '/api/groupe-4/posts/{id}/like', 'desc' => 'Retirer le like'],
                // Comments
                ['method' => 'GET', 'path' => '/api/groupe-4/posts/{id}/comments', 'desc' => 'Commentaires d\'un post'],
                ['method' => 'POST', 'path' => '/api/groupe-4/posts/{id}/comments', 'desc' => 'Commenter un post'],
                ['method' => 'DELETE', 'path' => '/api/groupe-4/comments/{id}', 'desc' => 'Supprimer un commentaire'],
                // Profil
                ['method' => 'GET', 'path' => '/api/groupe-4/profil', 'desc' => 'Mon profil'],
                ['method' => 'PUT', 'path' => '/api/groupe-4/profil', 'desc' => 'Modifier mon profil'],
                // Chat
                ['method' => 'POST', 'path' => '/api/groupe-4/chat/send', 'desc' => 'Envoyer un message'],
                ['method' => 'GET', 'path' => '/api/groupe-4/chat/conversations', 'desc' => 'Liste des conversations'],
                ['method' => 'GET', 'path' => '/api/groupe-4/chat/messages/{userId}', 'desc' => 'Messages avec un utilisateur'],
                ['method' => 'POST', 'path' => '/api/groupe-4/chat/messages/{userId}/read', 'desc' => 'Marquer comme lus'],
                ['method' => 'GET', 'path' => '/api/groupe-4/chat/unread-count', 'desc' => 'Nombre de messages non lus'],
                ['method' => 'DELETE', 'path' => '/api/groupe-4/chat/messages/{messageId}', 'desc' => 'Supprimer un message'],
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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-5/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-5/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-5/auth/logout', 'desc' => 'Se déconnecter'],
                // Projets
                ['method' => 'GET', 'path' => '/api/groupe-5/projets', 'desc' => 'Liste des projets'],
                ['method' => 'POST', 'path' => '/api/groupe-5/projets', 'desc' => 'Créer un projet'],
                ['method' => 'GET', 'path' => '/api/groupe-5/projets/{id}', 'desc' => 'Détails d\'un projet'],
                ['method' => 'PUT', 'path' => '/api/groupe-5/projets/{id}', 'desc' => 'Modifier un projet'],
                ['method' => 'DELETE', 'path' => '/api/groupe-5/projets/{id}', 'desc' => 'Supprimer un projet'],
                // Tâches
                ['method' => 'GET', 'path' => '/api/groupe-5/projets/{projetId}/taches', 'desc' => 'Tâches d\'un projet'],
                ['method' => 'POST', 'path' => '/api/groupe-5/projets/{projetId}/taches', 'desc' => 'Créer une tâche'],
                ['method' => 'PUT', 'path' => '/api/groupe-5/taches/{id}', 'desc' => 'Modifier une tâche'],
                ['method' => 'PUT', 'path' => '/api/groupe-5/taches/{id}/status', 'desc' => 'Changer le statut'],
                ['method' => 'DELETE', 'path' => '/api/groupe-5/taches/{id}', 'desc' => 'Supprimer une tâche'],
                ['method' => 'POST', 'path' => '/api/groupe-5/taches/{id}/assign', 'desc' => 'Assigner une tâche'],
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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-6/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-6/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-6/auth/logout', 'desc' => 'Se déconnecter'],
                // Cours (Public)
                ['method' => 'GET', 'path' => '/api/groupe-6/cours', 'desc' => 'Liste des cours'],
                ['method' => 'GET', 'path' => '/api/groupe-6/cours/{id}', 'desc' => 'Détails d\'un cours'],
                // Formateur
                ['method' => 'POST', 'path' => '/api/groupe-6/formateur/cours', 'desc' => 'Créer un cours'],
                ['method' => 'PUT', 'path' => '/api/groupe-6/formateur/cours/{id}', 'desc' => 'Modifier un cours'],
                ['method' => 'DELETE', 'path' => '/api/groupe-6/formateur/cours/{id}', 'desc' => 'Supprimer un cours'],
                ['method' => 'GET', 'path' => '/api/groupe-6/formateur/cours/{coursId}/lecons', 'desc' => 'Leçons d\'un cours'],
                ['method' => 'POST', 'path' => '/api/groupe-6/formateur/cours/{coursId}/lecons', 'desc' => 'Créer une leçon'],
                ['method' => 'PUT', 'path' => '/api/groupe-6/formateur/cours/{coursId}/lecons/{id}', 'desc' => 'Modifier une leçon'],
                ['method' => 'DELETE', 'path' => '/api/groupe-6/formateur/cours/{coursId}/lecons/{id}', 'desc' => 'Supprimer une leçon'],
                // Étudiant
                ['method' => 'GET', 'path' => '/api/groupe-6/etudiant/cours/{id}/lecons', 'desc' => 'Leçons d\'un cours'],
                ['method' => 'GET', 'path' => '/api/groupe-6/etudiant/cours/{coursId}/lecons/{id}', 'desc' => 'Détails d\'une leçon'],
                ['method' => 'POST', 'path' => '/api/groupe-6/etudiant/progression', 'desc' => 'Enregistrer progression'],
                ['method' => 'GET', 'path' => '/api/groupe-6/etudiant/progression', 'desc' => 'Ma progression'],
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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-7/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-7/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-7/auth/logout', 'desc' => 'Se déconnecter'],
                // Transactions
                ['method' => 'GET', 'path' => '/api/groupe-7/transactions', 'desc' => 'Liste des transactions'],
                ['method' => 'POST', 'path' => '/api/groupe-7/transactions', 'desc' => 'Créer une transaction'],
                ['method' => 'GET', 'path' => '/api/groupe-7/transactions/{id}', 'desc' => 'Détails d\'une transaction'],
                ['method' => 'PUT', 'path' => '/api/groupe-7/transactions/{id}', 'desc' => 'Modifier une transaction'],
                ['method' => 'DELETE', 'path' => '/api/groupe-7/transactions/{id}', 'desc' => 'Supprimer une transaction'],
                // Catégories
                ['method' => 'GET', 'path' => '/api/groupe-7/categories', 'desc' => 'Liste des catégories'],
                ['method' => 'POST', 'path' => '/api/groupe-7/categories', 'desc' => 'Créer une catégorie'],
                ['method' => 'GET', 'path' => '/api/groupe-7/categories/{id}', 'desc' => 'Détails d\'une catégorie'],
                ['method' => 'PUT', 'path' => '/api/groupe-7/categories/{id}', 'desc' => 'Modifier une catégorie'],
                ['method' => 'DELETE', 'path' => '/api/groupe-7/categories/{id}', 'desc' => 'Supprimer une catégorie'],
                // Statistiques
                ['method' => 'GET', 'path' => '/api/groupe-7/statistiques', 'desc' => 'Statistiques générales'],
                ['method' => 'GET', 'path' => '/api/groupe-7/statistiques/by-categorie', 'desc' => 'Statistiques par catégorie'],
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
                'Upload d\'images pour établissements et avis',
                'Gestion des rôles (Admin/User)',
                'Système d\'authentification avec rôles',
                'Suppression en cascade (établissements/avis/images)',
                'Gestion admin complète des établissements'
            ],
            'endpoints' => [
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-8/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-8/auth/login', 'desc' => 'Se connecter (retourne role)'],
                ['method' => 'POST', 'path' => '/api/groupe-8/auth/logout', 'desc' => 'Se déconnecter'],
                // Établissements (Public)
                ['method' => 'GET', 'path' => '/api/groupe-8/etablissements', 'desc' => 'Liste des établissements'],
                ['method' => 'GET', 'path' => '/api/groupe-8/etablissements/{id}', 'desc' => 'Détails d\'un établissement'],
                ['method' => 'GET', 'path' => '/api/groupe-8/etablissements/{id}/avis', 'desc' => 'Avis d\'un établissement'],
                // Avis (Protected)
                ['method' => 'POST', 'path' => '/api/groupe-8/etablissements/{id}/avis', 'desc' => 'Créer un avis'],
                ['method' => 'PUT', 'path' => '/api/groupe-8/avis/{id}', 'desc' => 'Modifier mon avis'],
                ['method' => 'DELETE', 'path' => '/api/groupe-8/avis/{id}', 'desc' => 'Supprimer mon avis'],
                // Images
                ['method' => 'POST', 'path' => '/api/groupe-8/etablissements/{id}/images', 'desc' => 'Upload image établissement'],
                ['method' => 'GET', 'path' => '/api/groupe-8/etablissements/{id}/images', 'desc' => 'Images d\'un établissement'],
                ['method' => 'POST', 'path' => '/api/groupe-8/avis/{id}/images', 'desc' => 'Upload image avis'],
                ['method' => 'GET', 'path' => '/api/groupe-8/avis/{id}/images', 'desc' => 'Images d\'un avis'],
                ['method' => 'DELETE', 'path' => '/api/groupe-8/images/{id}', 'desc' => 'Supprimer une image'],
                // Admin
                ['method' => 'POST', 'path' => '/api/groupe-8/admin/etablissements', 'desc' => 'Créer établissement (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-8/admin/etablissements/{id}', 'desc' => 'Modifier établissement (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-8/admin/etablissements/{id}', 'desc' => 'Supprimer établissement (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-8/admin/avis/{id}', 'desc' => 'Supprimer avis (Admin)'],
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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-9/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-9/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-9/auth/logout', 'desc' => 'Se déconnecter'],
                // Événements (Public)
                ['method' => 'GET', 'path' => '/api/groupe-9/evenements', 'desc' => 'Liste des événements'],
                ['method' => 'GET', 'path' => '/api/groupe-9/evenements/{id}', 'desc' => 'Détails d\'un événement'],
                // Inscriptions (Protected)
                ['method' => 'POST', 'path' => '/api/groupe-9/evenements/{id}/inscription', 'desc' => 'S\'inscrire à un événement'],
                ['method' => 'DELETE', 'path' => '/api/groupe-9/evenements/{id}/inscription', 'desc' => 'Annuler inscription'],
                ['method' => 'GET', 'path' => '/api/groupe-9/mes-inscriptions', 'desc' => 'Mes inscriptions'],
                // Admin
                ['method' => 'POST', 'path' => '/api/groupe-9/admin/evenements', 'desc' => 'Créer événement (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-9/admin/evenements/{id}', 'desc' => 'Modifier événement (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-9/admin/evenements/{id}', 'desc' => 'Supprimer événement (Admin)'],
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
                // Auth
                ['method' => 'POST', 'path' => '/api/groupe-10/auth/register', 'desc' => 'Créer un compte'],
                ['method' => 'POST', 'path' => '/api/groupe-10/auth/login', 'desc' => 'Se connecter'],
                ['method' => 'POST', 'path' => '/api/groupe-10/auth/logout', 'desc' => 'Se déconnecter'],
                // Employés (Protected)
                ['method' => 'GET', 'path' => '/api/groupe-10/employes', 'desc' => 'Liste des employés'],
                ['method' => 'GET', 'path' => '/api/groupe-10/employes/{id}', 'desc' => 'Détails d\'un employé'],
                ['method' => 'GET', 'path' => '/api/groupe-10/mon-profil', 'desc' => 'Mon profil employé'],
                // Services
                ['method' => 'GET', 'path' => '/api/groupe-10/services', 'desc' => 'Liste des services'],
                ['method' => 'GET', 'path' => '/api/groupe-10/services/{id}', 'desc' => 'Détails d\'un service'],
                // Congés
                ['method' => 'GET', 'path' => '/api/groupe-10/conges', 'desc' => 'Liste des congés'],
                ['method' => 'POST', 'path' => '/api/groupe-10/conges', 'desc' => 'Demander un congé'],
                ['method' => 'GET', 'path' => '/api/groupe-10/conges/{id}', 'desc' => 'Détails d\'un congé'],
                // Admin
                ['method' => 'POST', 'path' => '/api/groupe-10/admin/employes', 'desc' => 'Créer employé (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-10/admin/employes/{id}', 'desc' => 'Modifier employé (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-10/admin/employes/{id}', 'desc' => 'Supprimer employé (Admin)'],
                ['method' => 'POST', 'path' => '/api/groupe-10/admin/services', 'desc' => 'Créer service (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-10/admin/services/{id}', 'desc' => 'Modifier service (Admin)'],
                ['method' => 'DELETE', 'path' => '/api/groupe-10/admin/services/{id}', 'desc' => 'Supprimer service (Admin)'],
                ['method' => 'PUT', 'path' => '/api/groupe-10/admin/conges/{id}/status', 'desc' => 'Approuver/Refuser congé (Admin)'],
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
