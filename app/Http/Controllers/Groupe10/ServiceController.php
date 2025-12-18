<?php

namespace App\Http\Controllers\Groupe10;

use App\Http\Controllers\Controller;
use App\Models\Groupe10Service;
use App\Models\Groupe10Employe;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Groupe10Service::withCount('employes')->get();
            return response()->json([
                'success' => true,
                'data' => $services,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération des services: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des services',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $service = Groupe10Service::with('employes.user')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $service,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération du service: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération du service',
                'errors' => [],
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = $request->user();
            $employe = $user->groupe10Employe;

            if (!$employe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil employé non trouvé. Veuillez vous réinscrire via /api/groupe-10/auth/register',
                    'errors' => [],
                ], 404);
            }

            if ($employe->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès réservé aux administrateurs.',
                    'errors' => [],
                ], 403);
            }

            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $service = Groupe10Service::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Service créé avec succès',
                'data' => $service,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la création du service: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du service',
                'errors' => [],
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $request->user();
            $employe = $user->groupe10Employe;

            if (!$employe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil employé non trouvé. Veuillez vous réinscrire via /api/groupe-10/auth/register',
                    'errors' => [],
                ], 404);
            }

            if ($employe->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès réservé aux administrateurs.',
                    'errors' => [],
                ], 403);
            }

            $service = Groupe10Service::findOrFail($id);

            $request->validate([
                'nom' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
            ]);

            $service->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Service mis à jour avec succès',
                'data' => $service,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la mise à jour du service: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du service',
                'errors' => [],
            ], 500);
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $user = $request->user();
            $employe = $user->groupe10Employe;

            if (!$employe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil employé non trouvé. Veuillez vous réinscrire via /api/groupe-10/auth/register',
                    'errors' => [],
                ], 404);
            }

            if ($employe->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès réservé aux administrateurs.',
                    'errors' => [],
                ], 403);
            }

            $service = Groupe10Service::findOrFail($id);
            $service->delete();

            return response()->json([
                'success' => true,
                'message' => 'Service supprimé avec succès',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Service non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la suppression du service: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression du service',
                'errors' => [],
            ], 500);
        }
    }
}
