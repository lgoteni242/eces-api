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
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $employes = Groupe10Employe::with(['user', 'service'])
            ->get();

        return response()->json($employes);
    }

    public function show($id, Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        $employe = Groupe10Employe::with(['user', 'service'])
            ->findOrFail($id);

        // Un employé peut voir son propre profil
        if ($groupe10User->role !== 'admin' && $groupe10User->id !== $employe->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        return response()->json($employe);
    }

    public function monProfil(Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        $employe = Groupe10Employe::with(['user', 'service'])
            ->findOrFail($groupe10User->id);

        return response()->json($employe);
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
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $employe = Groupe10Employe::findOrFail($id);

        $request->validate([
            'role' => 'sometimes|in:admin,employe',
            'service_id' => 'nullable|exists:groupe10_services,id',
        ]);

        $employe->update($request->all());

        return response()->json($employe->load(['user', 'service']));
    }

    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $employe = Groupe10Employe::findOrFail($id);
        $employe->delete();

        return response()->json(['message' => 'Employé supprimé'], 200);
    }
}

