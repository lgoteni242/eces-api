<?php

namespace App\Http\Controllers\Groupe9;

use App\Http\Controllers\Controller;
use App\Models\Groupe9Evenement;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    public function index(Request $request)
    {
        $query = Groupe9Evenement::withCount('inscriptions');

        // Filtrage par catégorie
        if ($request->has('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        // Tri par date
        $query->orderBy('date', 'asc');

        $evenements = $query->paginate(15);

        return response()->json($evenements);
    }

    public function show($id)
    {
        $evenement = Groupe9Evenement::with(['inscriptions.user'])
            ->withCount('inscriptions')
            ->findOrFail($id);

        return response()->json($evenement);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:now',
            'lieu' => 'required|string',
            'categorie' => 'nullable|string',
            'capacite_max' => 'nullable|integer|min:1',
        ]);

        $evenement = Groupe9Evenement::create($request->all());

        return response()->json($evenement, 201);
    }

    public function update(Request $request, $id)
    {
        $evenement = Groupe9Evenement::findOrFail($id);

        $request->validate([
            'titre' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'lieu' => 'sometimes|string',
            'categorie' => 'nullable|string',
            'capacite_max' => 'nullable|integer|min:1',
        ]);

        $evenement->update($request->all());

        return response()->json($evenement);
    }

    public function destroy($id)
    {
        $evenement = Groupe9Evenement::findOrFail($id);
        $evenement->delete();

        return response()->json(['message' => 'Événement supprimé'], 200);
    }
}

