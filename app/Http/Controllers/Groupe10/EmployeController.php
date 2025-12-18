<?php

namespace App\Http\Controllers\Groupe10;

use App\Http\Controllers\Controller;
use App\Models\Groupe10Employe;
use App\Models\Groupe10User;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function index(Request $request)
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

            $employes = Groupe10Employe::with(['user', 'service'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $employes,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération des employés: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des employés',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $user = $request->user();
            $currentEmploye = $user->groupe10Employe;

            if (!$currentEmploye) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil employé non trouvé. Veuillez vous réinscrire via /api/groupe-10/auth/register',
                    'errors' => [],
                ], 404);
            }

            $employe = Groupe10Employe::with(['user', 'service'])
                ->findOrFail($id);

            // Un employé peut voir son propre profil
            if ($currentEmploye->role !== 'admin' && $currentEmploye->id !== $employe->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé',
                    'errors' => [],
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $employe,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employé non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération de l\'employé: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération de l\'employé',
                'errors' => [],
            ], 500);
        }
    }

    public function monProfil(Request $request)
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

            // Charger les relations
            $employe->load(['user', 'service']);

            return response()->json([
                'success' => true,
                'data' => $employe,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération du profil: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération du profil',
                'errors' => [],
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,employe',
            'service_id' => 'nullable|exists:groupe10_services,id',
        ]);

        $employe = Groupe10Employe::create([
            'user_id' => $request->user_id,
            'role' => $request->role,
            'service_id' => $request->service_id,
        ]);

        return response()->json($employe->load(['user', 'service']), 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $request->user();
            $currentEmploye = $user->groupe10Employe;

            if (!$currentEmploye) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil employé non trouvé. Veuillez vous réinscrire via /api/groupe-10/auth/register',
                    'errors' => [],
                ], 404);
            }

            if ($currentEmploye->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès réservé aux administrateurs.',
                    'errors' => [],
                ], 403);
            }

            $employe = Groupe10Employe::findOrFail($id);

            $request->validate([
                'role' => 'sometimes|in:admin,employe',
                'service_id' => 'nullable|exists:groupe10_services,id',
            ]);

            $employe->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Employé mis à jour avec succès',
                'data' => $employe->load(['user', 'service']),
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
                'message' => 'Employé non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la mise à jour de l\'employé: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour de l\'employé',
                'errors' => [],
            ], 500);
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $user = $request->user();
            $currentEmploye = $user->groupe10Employe;

            if (!$currentEmploye) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil employé non trouvé. Veuillez vous réinscrire via /api/groupe-10/auth/register',
                    'errors' => [],
                ], 404);
            }

            if ($currentEmploye->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé. Accès réservé aux administrateurs.',
                    'errors' => [],
                ], 403);
            }

            $employe = Groupe10Employe::findOrFail($id);
            $employe->delete();

            return response()->json([
                'success' => true,
                'message' => 'Employé supprimé avec succès',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Employé non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la suppression de l\'employé: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de l\'employé',
                'errors' => [],
            ], 500);
        }
    }
}
