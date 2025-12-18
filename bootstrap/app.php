<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handler pour les erreurs de validation
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // Handler pour les erreurs d'authentification
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Non authentifié',
                    'errors' => [],
                ], 401);
            }
        });

        // Handler pour les erreurs d'autorisation
        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé',
                    'errors' => [],
                ], 403);
            }
        });

        // Handler pour les modèles non trouvés
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ressource non trouvée',
                    'errors' => [],
                ], 404);
            }
        });

        // Handler pour les erreurs de base de données
        $exceptions->render(function (\Illuminate\Database\QueryException $e, $request) {
            if ($request->is('api/*')) {
                \Illuminate\Support\Facades\Log::error('QueryException: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Une erreur est survenue lors de l\'opération',
                    'errors' => [],
                ], 500);
            }
        });

        // Handler pour toutes les autres exceptions
        $exceptions->render(function (\Exception $e, $request) {
            if ($request->is('api/*')) {
                \Illuminate\Support\Facades\Log::error('Exception: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => config('app.debug') ? $e->getMessage() : 'Une erreur est survenue',
                    'errors' => [],
                ], 500);
            }
        });
    })->create();
