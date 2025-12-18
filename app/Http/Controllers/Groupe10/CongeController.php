<?php

namespace App\Http\Controllers\Groupe10;

use App\Http\Controllers\Controller;
use App\Models\Groupe10Conge;
use App\Models\Groupe10Employe;
use Illuminate\Http\Request;

class CongeController extends Controller
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

            $query = Groupe10Conge::with(['employe.user']);

            // Si ce n'est pas un admin, ne voir que ses propres congés
            if ($employe->role !== 'admin') {
                $query->where('employe_id', $employe->id);
            }

            $conges = $query->orderBy('created_at', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $conges,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération des congés: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des congés',
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

            $request->validate([
                'date_debut' => 'required|date|after:today',
                'date_fin' => 'required|date|after:date_debut',
                'raison' => 'nullable|string',
            ]);

            $conge = Groupe10Conge::create([
                'employe_id' => $employe->id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'raison' => $request->raison,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Demande de congé créée avec succès',
                'data' => $conge->load('employe.user'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la création du congé: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du congé',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id, Request $request)
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

            $conge = Groupe10Conge::with('employe.user')->findOrFail($id);

            // Vérifier les permissions
            if ($employe->role !== 'admin' && $conge->employe_id !== $employe->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Non autorisé',
                    'errors' => [],
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => $conge,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Congé non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération du congé: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération du congé',
                'errors' => [],
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
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
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $conge = Groupe10Conge::findOrFail($id);
            $conge->status = $request->status;
            $conge->save();

            return response()->json([
                'success' => true,
                'message' => 'Statut du congé mis à jour avec succès',
                'data' => $conge->load('employe.user'),
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
                'message' => 'Congé non trouvé',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la mise à jour du statut du congé: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du statut',
                'errors' => [],
            ], 500);
        }
    }
}
