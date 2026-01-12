<?php

namespace App\Http\Controllers\Groupe3;

use App\Http\Controllers\Controller;
use App\Models\Groupe3Salle;
use App\Models\Groupe3Image;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function index()
    {
        $salles = Groupe3Salle::all();
        return response()->json($salles);
    }

    public function show($id)
    {
        $salle = Groupe3Salle::with(['reservations', 'images'])->findOrFail($id);
        return response()->json($salle);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
            'prix' => 'nullable|numeric|min:0',
            'equipements' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $salle = Groupe3Salle::create($request->all());

        return response()->json($salle, 201);
    }

    public function update(Request $request, $id)
    {
        $salle = Groupe3Salle::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'capacite' => 'sometimes|integer|min:1',
            'prix' => 'nullable|numeric|min:0',
            'equipements' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $salle->update($request->all());

        return response()->json($salle);
    }

    public function destroy($id)
    {
        $salle = Groupe3Salle::findOrFail($id);

        // Supprimer toutes les images associées
        foreach ($salle->images as $image) {
            // Supprimer le fichier du stockage
            $storagePath = 'public/' . $image->path;
            if (\Illuminate\Support\Facades\Storage::exists($storagePath)) {
                \Illuminate\Support\Facades\Storage::delete($storagePath);
            }
            // Supprimer l'enregistrement
            $image->delete();
        }

        // Supprimer la salle (les réservations seront supprimées en cascade)
        $salle->delete();

        return response()->json(['message' => 'Salle et toutes les données associées supprimées'], 200);
    }
}

