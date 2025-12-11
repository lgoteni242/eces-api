<?php

namespace App\Http\Controllers\Groupe10;

use App\Http\Controllers\Controller;
use App\Models\Groupe10Service;
use App\Models\Groupe10User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Groupe10Service::withCount('employes')->get();
        return response()->json($services);
    }

    public function show($id)
    {
        $service = Groupe10Service::with('employes.user')->findOrFail($id);
        return response()->json($service);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service = Groupe10Service::create($request->all());

        return response()->json($service, 201);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $service = Groupe10Service::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $service->update($request->all());

        return response()->json($service);
    }

    public function destroy($id, Request $request)
    {
        $user = $request->user();
        $groupe10User = Groupe10User::where('user_id', $user->id)->first();

        if ($groupe10User->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $service = Groupe10Service::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service supprimé'], 200);
    }
}

