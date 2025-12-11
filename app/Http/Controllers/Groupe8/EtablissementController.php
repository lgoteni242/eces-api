<?php

namespace App\Http\Controllers\Groupe8;

use App\Http\Controllers\Controller;
use App\Models\Groupe8Etablissement;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{
    public function index(Request $request)
    {
        $query = Groupe8Etablissement::withCount('avis');

        // Tri par note moyenne
        if ($request->has('sort_by') && $request->sort_by === 'note') {
            $query->withAvg('avis', 'note')
                ->orderBy('avis_avg_note', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $etablissements = $query->paginate(15);

        return response()->json($etablissements);
    }

    public function show($id)
    {
        $etablissement = Groupe8Etablissement::with(['avis.user'])
            ->withAvg('avis', 'note')
            ->findOrFail($id);

        return response()->json($etablissement);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:restaurant,hotel',
            'adresse' => 'required|string',
            'telephone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $etablissement = Groupe8Etablissement::create($request->all());

        return response()->json($etablissement, 201);
    }

    public function update(Request $request, $id)
    {
        $etablissement = Groupe8Etablissement::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:restaurant,hotel',
            'adresse' => 'sometimes|string',
            'telephone' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $etablissement->update($request->all());

        return response()->json($etablissement);
    }

    public function destroy($id)
    {
        $etablissement = Groupe8Etablissement::findOrFail($id);
        $etablissement->delete();

        return response()->json(['message' => 'Établissement supprimé'], 200);
    }
}

