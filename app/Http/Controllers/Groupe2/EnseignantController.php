<?php

namespace App\Http\Controllers\Groupe2;

use App\Http\Controllers\Controller;
use App\Models\Groupe2User;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Groupe2User::where('role', 'professeur')
            ->with('user')
            ->get();
        
        return response()->json($enseignants);
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
                'role' => 'professeur',
            ]);

            DB::commit();

            return response()->json($groupe2User->load('user'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la création de l\'enseignant: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de l\'enseignant',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id)
    {
        $enseignant = Groupe2User::where('id', $id)
            ->where('role', 'professeur')
            ->with(['user', 'emploisDuTemps.matiere', 'emploisDuTemps.classe'])
            ->firstOrFail();
        
        return response()->json($enseignant);
    }

    public function update(Request $request, $id)
    {
        try {
            $enseignant = Groupe2User::where('id', $id)
                ->where('role', 'professeur')
                ->with('user')
                ->firstOrFail();

            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $enseignant->user_id,
                'password' => 'sometimes|string|min:8',
            ]);

            DB::beginTransaction();

            if ($request->has('name') || $request->has('email') || $request->has('password')) {
                $userData = [];
                if ($request->has('name')) $userData['name'] = $request->name;
                if ($request->has('email')) $userData['email'] = $request->email;
                if ($request->has('password')) $userData['password'] = Hash::make($request->password);
                
                $enseignant->user->update($userData);
            }

            DB::commit();

            return response()->json($enseignant->fresh('user'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la mise à jour de l\'enseignant: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour de l\'enseignant',
                'errors' => [],
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $enseignant = Groupe2User::where('id', $id)
                ->where('role', 'professeur')
                ->with('user')
                ->firstOrFail();

            DB::beginTransaction();

            $userId = $enseignant->user_id;
            $enseignant->delete();
            User::find($userId)->delete();

            DB::commit();

            return response()->json(['message' => 'Enseignant supprimé avec succès'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de la suppression de l\'enseignant: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de l\'enseignant',
                'errors' => [],
            ], 500);
        }
    }
}
