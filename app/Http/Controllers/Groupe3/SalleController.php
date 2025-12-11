<?php

namespace App\Http\Controllers\Groupe3;

use App\Http\Controllers\Controller;
use App\Models\Groupe3Salle;
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
        $salle = Groupe3Salle::with('reservations')->findOrFail($id);
        return response()->json($salle);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'required|integer|min:1',
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
            'equipements' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $salle->update($request->all());

        return response()->json($salle);
    }

    public function destroy($id)
    {
        $salle = Groupe3Salle::findOrFail($id);
        $salle->delete();

        return response()->json(['message' => 'Salle supprimée'], 200);
    }
}

