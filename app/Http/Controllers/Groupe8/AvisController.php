<?php

namespace App\Http\Controllers\Groupe8;

use App\Http\Controllers\Controller;
use App\Models\Groupe8Avis;
use App\Models\Groupe8Etablissement;
use Illuminate\Http\Request;
use App\Models\Groupe8Image;

class AvisController extends Controller
{
    public function index($etablissementId)
    {
        $avis = Groupe8Avis::where('etablissement_id', $etablissementId)
            ->with(['user', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($avis);
    }

    public function store(Request $request, $etablissementId)
    {
        $etablissement = Groupe8Etablissement::findOrFail($etablissementId);

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        // Vérifier si l'utilisateur a déjà laissé un avis
        $existingAvis = Groupe8Avis::where('user_id', $request->user()->id)
            ->where('etablissement_id', $etablissementId)
            ->first();

        if ($existingAvis) {
            return response()->json(['message' => 'Vous avez déjà laissé un avis'], 400);
        }

        $avis = Groupe8Avis::create([
            'user_id' => $request->user()->id,
            'etablissement_id' => $etablissementId,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return response()->json($avis->load('user'), 201);
    }

    public function update(Request $request, $id)
    {
        $avis = Groupe8Avis::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $request->validate([
            'note' => 'sometimes|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $avis->update($request->all());

        return response()->json($avis->load('user'));
    }

    public function destroy($id, Request $request)
    {
        $avis = Groupe8Avis::findOrFail($id);

        // Vérifier les permissions : seul le propriétaire ou un admin peut supprimer
        if ($avis->user_id !== $request->user()->id && $request->user()->groupe8_role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        // Supprimer toutes les images associées
        foreach ($avis->images as $image) {
            // Supprimer le fichier du stockage
            $storagePath = 'public/' . $image->path;
            if (\Illuminate\Support\Facades\Storage::exists($storagePath)) {
                \Illuminate\Support\Facades\Storage::delete($storagePath);
            }
            // Supprimer l'enregistrement
            $image->delete();
        }

        // Supprimer l'avis
        $avis->delete();

        return response()->json(['message' => 'Avis et toutes les images associées supprimés'], 200);
    }
}

