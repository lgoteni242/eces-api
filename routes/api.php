<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route de base pour tester l'authentification
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes pour la gestion des fichiers/images
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload/image', [App\Http\Controllers\FileController::class, 'uploadImage']);
    Route::post('/upload/file', [App\Http\Controllers\FileController::class, 'uploadFile']);
    Route::delete('/upload/file', [App\Http\Controllers\FileController::class, 'deleteFile']);
});

// ============================================
// GROUPE 1 : E-COMMERCE (mini-Amazon)
// ============================================
Route::prefix('groupe-1')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe1\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe1\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe1\AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Public routes
    Route::get('/products', [App\Http\Controllers\Groupe1\ProductController::class, 'index']);
    Route::get('/products/{id}', [App\Http\Controllers\Groupe1\ProductController::class, 'show']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Cart
        Route::get('/cart', [App\Http\Controllers\Groupe1\CartController::class, 'index']);
        Route::post('/cart', [App\Http\Controllers\Groupe1\CartController::class, 'add']);
        Route::put('/cart/{id}', [App\Http\Controllers\Groupe1\CartController::class, 'update']);
        Route::delete('/cart/{id}', [App\Http\Controllers\Groupe1\CartController::class, 'remove']);

        // Orders
        Route::get('/orders', [App\Http\Controllers\Groupe1\OrderController::class, 'index']);
        Route::post('/orders', [App\Http\Controllers\Groupe1\OrderController::class, 'store']);
        Route::get('/orders/{id}', [App\Http\Controllers\Groupe1\OrderController::class, 'show']);

        // Admin routes
        Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
            Route::apiResource('products', App\Http\Controllers\Groupe1\ProductController::class)->except(['index', 'show']);
        });
    });
});

// ============================================
// GROUPE 2 : GESTION SCOLAIRE (mini-ERP)
// ============================================
Route::prefix('groupe-2')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe2\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe2\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe2\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Matières
        Route::apiResource('matieres', App\Http\Controllers\Groupe2\MatiereController::class);

        // Notes
        Route::get('/notes', [App\Http\Controllers\Groupe2\NoteController::class, 'index']);
        Route::post('/notes', [App\Http\Controllers\Groupe2\NoteController::class, 'store']);
        Route::get('/notes/{id}', [App\Http\Controllers\Groupe2\NoteController::class, 'show']);
        Route::put('/notes/{id}', [App\Http\Controllers\Groupe2\NoteController::class, 'update']);

        // Étudiants
        Route::apiResource('etudiants', App\Http\Controllers\Groupe2\EtudiantController::class);

        // Enseignants
        Route::apiResource('enseignants', App\Http\Controllers\Groupe2\EnseignantController::class);

        // Classes
        Route::apiResource('classes', App\Http\Controllers\Groupe2\ClasseController::class);

        // Bulletins
        Route::get('/bulletins/{etudiantId}', [App\Http\Controllers\Groupe2\BulletinController::class, 'show']);

        // Emplois du temps
        Route::get('/emplois-du-temps', [App\Http\Controllers\Groupe2\EmploiDuTempsController::class, 'index']);
        Route::post('/emplois-du-temps', [App\Http\Controllers\Groupe2\EmploiDuTempsController::class, 'store']);
        Route::get('/emplois-du-temps/{classeId}', [App\Http\Controllers\Groupe2\EmploiDuTempsController::class, 'show']);
        Route::put('/emplois-du-temps/{id}', [App\Http\Controllers\Groupe2\EmploiDuTempsController::class, 'update']);
        Route::delete('/emplois-du-temps/{id}', [App\Http\Controllers\Groupe2\EmploiDuTempsController::class, 'destroy']);

        // Présences
        Route::post('/presences', [App\Http\Controllers\Groupe2\PresenceController::class, 'store']);
        Route::get('/presences/{etudiantId}', [App\Http\Controllers\Groupe2\PresenceController::class, 'getPresences']);
        Route::get('/absences/{etudiantId}', [App\Http\Controllers\Groupe2\PresenceController::class, 'getAbsences']);

        // Dashboard Admin
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', [App\Http\Controllers\Groupe2\DashboardController::class, 'index']);
            Route::apiResource('matieres', App\Http\Controllers\Groupe2\MatiereController::class);
        });
    });
});

// ============================================
// GROUPE 3 : RÉSERVATION (salles/matériels)
// ============================================
Route::prefix('groupe-3')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe3\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe3\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe3\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Salles (public view)
        Route::get('/salles', [App\Http\Controllers\Groupe3\SalleController::class, 'index']);
        Route::get('/salles/{id}', [App\Http\Controllers\Groupe3\SalleController::class, 'show']);

        // Images des salles
        Route::get('/salles/{id}/images', [App\Http\Controllers\Groupe3\ImageController::class, 'getSalleImages']);

        // Réservations
        Route::get('/reservations', [App\Http\Controllers\Groupe3\ReservationController::class, 'index']);
        Route::post('/reservations', [App\Http\Controllers\Groupe3\ReservationController::class, 'store']);
        Route::delete('/reservations/{id}', [App\Http\Controllers\Groupe3\ReservationController::class, 'cancel']);
        Route::get('/reservations/calendrier', [App\Http\Controllers\Groupe3\ReservationController::class, 'calendrier']);

        // Admin routes
        Route::prefix('admin')->group(function () {
            Route::apiResource('salles', App\Http\Controllers\Groupe3\SalleController::class);
            Route::post('/salles/{id}/images', [App\Http\Controllers\Groupe3\ImageController::class, 'uploadSalleImage']);
            Route::delete('/images/{id}', [App\Http\Controllers\Groupe3\ImageController::class, 'deleteImage']);
            Route::delete('/reservations/{id}', [App\Http\Controllers\Groupe3\ReservationController::class, 'destroy']);
        });
    });
});

// ============================================
// GROUPE 4 : RÉSEAU SOCIAL ÉTUDIANT
// ============================================
Route::prefix('groupe-4')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe4\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe4\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe4\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Posts
        Route::get('/posts', [App\Http\Controllers\Groupe4\PostController::class, 'index']);
        Route::post('/posts', [App\Http\Controllers\Groupe4\PostController::class, 'store']);
        Route::get('/posts/{id}', [App\Http\Controllers\Groupe4\PostController::class, 'show']);
        Route::put('/posts/{id}', [App\Http\Controllers\Groupe4\PostController::class, 'update']);
        Route::delete('/posts/{id}', [App\Http\Controllers\Groupe4\PostController::class, 'destroy']);

        // Likes
        Route::post('/posts/{id}/like', [App\Http\Controllers\Groupe4\PostController::class, 'like']);
        Route::delete('/posts/{id}/like', [App\Http\Controllers\Groupe4\PostController::class, 'unlike']);

        // Comments
        Route::post('/posts/{id}/comments', [App\Http\Controllers\Groupe4\CommentController::class, 'store']);
        Route::get('/posts/{id}/comments', [App\Http\Controllers\Groupe4\CommentController::class, 'index']);
        Route::delete('/comments/{id}', [App\Http\Controllers\Groupe4\CommentController::class, 'destroy']);

        // Profil
        Route::get('/profil', [App\Http\Controllers\Groupe4\ProfilController::class, 'show']);
        Route::put('/profil', [App\Http\Controllers\Groupe4\ProfilController::class, 'update']);

        // Feed
        Route::get('/feed', [App\Http\Controllers\Groupe4\PostController::class, 'feed']);

        // Chat
        Route::post('/chat/send', [App\Http\Controllers\Groupe4\ChatController::class, 'sendMessage']);
        Route::get('/chat/conversations', [App\Http\Controllers\Groupe4\ChatController::class, 'getConversations']);
        Route::get('/chat/messages/{userId}', [App\Http\Controllers\Groupe4\ChatController::class, 'getMessages']);
        Route::post('/chat/messages/{userId}/read', [App\Http\Controllers\Groupe4\ChatController::class, 'markAsRead']);
        Route::get('/chat/unread-count', [App\Http\Controllers\Groupe4\ChatController::class, 'getUnreadCount']);
        Route::delete('/chat/messages/{messageId}', [App\Http\Controllers\Groupe4\ChatController::class, 'deleteMessage']);
    });
});

// ============================================
// GROUPE 5 : GESTION DE TÂCHES (mini-Trello)
// ============================================
Route::prefix('groupe-5')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe5\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe5\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe5\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Projets
        Route::apiResource('projets', App\Http\Controllers\Groupe5\ProjetController::class);

        // Tâches
        Route::get('/projets/{projetId}/taches', [App\Http\Controllers\Groupe5\TacheController::class, 'index']);
        Route::post('/projets/{projetId}/taches', [App\Http\Controllers\Groupe5\TacheController::class, 'store']);
        Route::put('/taches/{id}', [App\Http\Controllers\Groupe5\TacheController::class, 'update']);
        Route::put('/taches/{id}/status', [App\Http\Controllers\Groupe5\TacheController::class, 'updateStatus']);
        Route::delete('/taches/{id}', [App\Http\Controllers\Groupe5\TacheController::class, 'destroy']);

        // Attribution membres
        Route::post('/taches/{id}/assign', [App\Http\Controllers\Groupe5\TacheController::class, 'assign']);
    });
});

// ============================================
// GROUPE 6 : PLATEFORME D'APPRENTISSAGE (mini-Udemy)
// ============================================
Route::prefix('groupe-6')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe6\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe6\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe6\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Cours (public)
        Route::get('/cours', [App\Http\Controllers\Groupe6\CoursController::class, 'index']);
        Route::get('/cours/{id}', [App\Http\Controllers\Groupe6\CoursController::class, 'show']);

        // Formateur routes
        Route::prefix('formateur')->group(function () {
            Route::apiResource('cours', App\Http\Controllers\Groupe6\CoursController::class);
            Route::apiResource('cours.lecons', App\Http\Controllers\Groupe6\LeconController::class);
            Route::apiResource('cours.quiz', App\Http\Controllers\Groupe6\QuizController::class);
        });

        // Étudiant routes
        Route::prefix('etudiant')->group(function () {
            Route::get('/cours/{id}/lecons', [App\Http\Controllers\Groupe6\LeconController::class, 'index']);
            Route::get('/cours/{coursId}/lecons/{id}', [App\Http\Controllers\Groupe6\LeconController::class, 'show']);
            Route::post('/progression', [App\Http\Controllers\Groupe6\ProgressionController::class, 'store']);
            Route::get('/progression', [App\Http\Controllers\Groupe6\ProgressionController::class, 'index']);
        });
    });
});

// ============================================
// GROUPE 7 : GESTION DE BUDGET
// ============================================
Route::prefix('groupe-7')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe7\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe7\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe7\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Transactions
        Route::apiResource('transactions', App\Http\Controllers\Groupe7\TransactionController::class);

        // Catégories
        Route::apiResource('categories', App\Http\Controllers\Groupe7\CategorieController::class);

        // Statistiques
        Route::get('/statistiques', [App\Http\Controllers\Groupe7\StatistiqueController::class, 'index']);
        Route::get('/statistiques/by-categorie', [App\Http\Controllers\Groupe7\StatistiqueController::class, 'byCategorie']);
    });
});

// ============================================
// GROUPE 8 : AVIS RESTAURANTS/HÔTELS
// ============================================
Route::prefix('groupe-8')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe8\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe8\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe8\AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Public routes
    Route::get('/etablissements', [App\Http\Controllers\Groupe8\EtablissementController::class, 'index']);
    Route::get('/etablissements/{id}', [App\Http\Controllers\Groupe8\EtablissementController::class, 'show']);
    Route::get('/etablissements/{id}/avis', [App\Http\Controllers\Groupe8\AvisController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function () {
        // Avis
        Route::post('/etablissements/{id}/avis', [App\Http\Controllers\Groupe8\AvisController::class, 'store']);
        Route::put('/avis/{id}', [App\Http\Controllers\Groupe8\AvisController::class, 'update']);
        Route::delete('/avis/{id}', [App\Http\Controllers\Groupe8\AvisController::class, 'destroy']);

        // Images
        Route::post('/etablissements/{id}/images', [App\Http\Controllers\Groupe8\ImageController::class, 'uploadEtablissementImage']);
        Route::get('/etablissements/{id}/images', [App\Http\Controllers\Groupe8\ImageController::class, 'getEtablissementImages']);
        Route::post('/avis/{id}/images', [App\Http\Controllers\Groupe8\ImageController::class, 'uploadAvisImage']);
        Route::get('/avis/{id}/images', [App\Http\Controllers\Groupe8\ImageController::class, 'getAvisImages']);
        Route::delete('/images/{id}', [App\Http\Controllers\Groupe8\ImageController::class, 'deleteImage']);

        // Admin routes (protégées par middleware IsAdmin)
        Route::prefix('admin')->middleware('is.admin')->group(function () {
            // Créer un administrateur
            Route::post('/create-admin', [App\Http\Controllers\Groupe8\AuthController::class, 'createAdmin']);
            // Gestion des établissements
            Route::apiResource('etablissements', App\Http\Controllers\Groupe8\EtablissementController::class);
            Route::delete('/avis/{id}', [App\Http\Controllers\Groupe8\AvisController::class, 'destroy']);
        });
    });
});

// ============================================
// GROUPE 9 : GESTION D'ÉVÉNEMENTS
// ============================================
Route::prefix('groupe-9')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe9\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe9\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe9\AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Public routes
    Route::get('/evenements', [App\Http\Controllers\Groupe9\EvenementController::class, 'index']);
    Route::get('/evenements/{id}', [App\Http\Controllers\Groupe9\EvenementController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        // Inscriptions
        Route::post('/evenements/{id}/inscription', [App\Http\Controllers\Groupe9\InscriptionController::class, 'store']);
        Route::delete('/evenements/{id}/inscription', [App\Http\Controllers\Groupe9\InscriptionController::class, 'destroy']);
        Route::get('/mes-inscriptions', [App\Http\Controllers\Groupe9\InscriptionController::class, 'index']);

        // Admin routes
        Route::prefix('admin')->group(function () {
            Route::apiResource('evenements', App\Http\Controllers\Groupe9\EvenementController::class);
        });
    });
});

// ============================================
// GROUPE 10 : PLATEFORME RH
// ============================================
Route::prefix('groupe-10')->group(function () {
    // Auth routes
    Route::post('/auth/register', [App\Http\Controllers\Groupe10\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Groupe10\AuthController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\Groupe10\AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        // Employés (consultation)
        Route::get('/employes', [App\Http\Controllers\Groupe10\EmployeController::class, 'index']);
        Route::get('/employes/{id}', [App\Http\Controllers\Groupe10\EmployeController::class, 'show']);
        Route::get('/mon-profil', [App\Http\Controllers\Groupe10\EmployeController::class, 'monProfil']);

        // Services
        Route::get('/services', [App\Http\Controllers\Groupe10\ServiceController::class, 'index']);
        Route::get('/services/{id}', [App\Http\Controllers\Groupe10\ServiceController::class, 'show']);

        // Congés
        Route::get('/conges', [App\Http\Controllers\Groupe10\CongeController::class, 'index']);
        Route::post('/conges', [App\Http\Controllers\Groupe10\CongeController::class, 'store']);
        Route::get('/conges/{id}', [App\Http\Controllers\Groupe10\CongeController::class, 'show']);

        // Admin routes
        Route::prefix('admin')->group(function () {
            Route::apiResource('employes', App\Http\Controllers\Groupe10\EmployeController::class);
            Route::apiResource('services', App\Http\Controllers\Groupe10\ServiceController::class);
            Route::put('/conges/{id}/status', [App\Http\Controllers\Groupe10\CongeController::class, 'updateStatus']);
        });
    });
});
