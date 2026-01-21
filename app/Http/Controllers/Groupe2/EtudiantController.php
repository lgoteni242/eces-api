<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Groupe2User::where('role', 'etudiant')
            ->with('user')
            ->get();
        
        return response()->json($etudiants);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $groupe2User = Groupe2User::create([
                'user_id' => $user->id,
                'role' => 'etudiant',
            ]);

            DB::commit();

            return response()->json($groupe2User->load('user'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de l\'étudiant: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de l\'étudiant',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id)
    {
        $etudiant = Groupe2User::where('id', $id)
            ->where('role', 'etudiant')
            ->with(['user', 'classes', 'notes.matiere', 'presences'])
            ->firstOrFail();
        
        return response()->json($etudiant);
    }

    public function update(Request $request, $id)
    {
        try {
            $etudiant = Groupe2User::where('id', $id)
                ->where('role', 'etudiant')
                ->with('user')
                ->firstOrFail();

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $etudiant->user_id,
                'password' => 'sometimes|string|min:8',
            ]);

            DB::beginTransaction();

            if ($request->has('name') || $request->has('email') || $request->has('password')) {
                $userData = [];
                if ($request->has('name')) $userData['name'] = $request->name;
                if ($request->has('email')) $userData['email'] = $request->email;
                if ($request->has('password')) $userData['password'] = Hash::make($request->password);
                
                $etudiant->user->update($userData);
            }

            DB::commit();

            return response()->json($etudiant->fresh('user'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de l\'étudiant: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour de l\'étudiant',
                'errors' => [],
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $etudiant = Groupe2User::where('id', $id)
                ->where('role', 'etudiant')
                ->with('user')
                ->firstOrFail();

            DB::beginTransaction();

            $userId = $etudiant->user_id;
            $etudiant->delete();
            User::find($userId)->delete();

            DB::commit();

            return response()->json(['message' => 'Étudiant supprimé avec succès'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression de l\'étudiant: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de l\'étudiant',
                'errors' => [],
            ], 500);
        }
    }
}
