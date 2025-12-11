<?php

namespace App\Http\Controllers\Groupe6;

use App\Http\Controllers\Controller;
use App\Models\Groupe6Progression;
use App\Models\Groupe6User;
use Illuminate\Http\Request;

class ProgressionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if (!$groupe6User || $groupe6User->role !== 'etudiant') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $progressions = Groupe6Progression::where('etudiant_id', $groupe6User->id)
            ->with('lecon.cours')
            ->get();

        return response()->json($progressions);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe6User = Groupe6User::where('user_id', $user->id)->first();

        if (!$groupe6User || $groupe6User->role !== 'etudiant') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'lecon_id' => 'required|exists:groupe6_lecons,id',
            'termine' => 'required|boolean',
        ]);

        $progression = Groupe6Progression::updateOrCreate(
            [
                'etudiant_id' => $groupe6User->id,
                'lecon_id' => $request->lecon_id,
            ],
            [
                'termine' => $request->termine,
            ]
        );

        return response()->json($progression->load('lecon.cours'), 201);
    }
}

