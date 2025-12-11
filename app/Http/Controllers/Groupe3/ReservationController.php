<?php

namespace App\Http\Controllers\Groupe3;

use App\Http\Controllers\Controller;
use App\Models\Groupe3Reservation;
use App\Models\Groupe3Salle;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Groupe3Reservation::where('user_id', $request->user()->id)
            ->with('salle')
            ->orderBy('date_debut', 'desc')
            ->get();

        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'salle_id' => 'required|exists:groupe3_salles,id',
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',
            'raison' => 'nullable|string',
        ]);

        // Vérifier les conflits
        $conflict = Groupe3Reservation::where('salle_id', $request->salle_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                      ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('date_debut', '<=', $request->date_debut)
                            ->where('date_fin', '>=', $request->date_fin);
                      });
            })
            ->exists();

        if ($conflict) {
            return response()->json(['message' => 'Créneau déjà réservé'], 409);
        }

        $reservation = Groupe3Reservation::create([
            'user_id' => $request->user()->id,
            'salle_id' => $request->salle_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'raison' => $request->raison,
            'status' => 'confirmed',
        ]);

        return response()->json($reservation->load('salle'), 201);
    }

    public function calendrier(Request $request)
    {
        $salleId = $request->get('salle_id');

        $query = Groupe3Reservation::with(['salle', 'user']);

        if ($salleId) {
            $query->where('salle_id', $salleId);
        }

        $reservations = $query->get();

        return response()->json($reservations);
    }

    public function cancel($id, Request $request)
    {
        $reservation = Groupe3Reservation::where('user_id', $request->user()->id)
            ->findOrFail($id);

        if ($reservation->date_debut < now()) {
            return response()->json(['message' => 'Impossible d\'annuler une réservation passée'], 400);
        }

        $reservation->delete();

        return response()->json(['message' => 'Réservation annulée'], 200);
    }
}

