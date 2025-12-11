<?php

namespace App\Http\Controllers\Groupe10;

use App\Http\Controllers\Controller;
use App\Models\Groupe10Conge;
use App\Models\Groupe10User;
use Illuminate\Http\Request;

class CongeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        $query = Groupe10Conge::with(['employe.user']);

        // Si ce n'est pas un admin, ne voir que ses propres congés
        if ($groupe10User->role !== 'admin') {
            $query->where('employe_id', $groupe10User->id);
        }

        $conges = $query->orderBy('created_at', 'desc')->get();

        return response()->json($conges);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        $request->validate([
            'date_debut' => 'required|date|after:today',
            'date_fin' => 'required|date|after:date_debut',
            'raison' => 'nullable|string',
        ]);

        $conge = Groupe10Conge::create([
            'employe_id' => $groupe10User->id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'raison' => $request->raison,
            'status' => 'pending',
        ]);

        return response()->json($conge->load('employe.user'), 201);
    }

    public function show($id, Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        $conge = Groupe10Conge::with('employe.user')->findOrFail($id);

        // Vérifier les permissions
        if ($groupe10User->role !== 'admin' && $conge->employe_id !== $groupe10User->id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        return response()->json($conge);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $conge = Groupe10Conge::findOrFail($id);
        $conge->status = $request->status;
        $conge->save();

        return response()->json($conge->load('employe.user'));
    }
}

