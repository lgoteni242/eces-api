<?php

namespace App\Http\Controllers\Groupe7;

use App\Http\Controllers\Controller;
use App\Models\Groupe7Transaction;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $depenses = Groupe7Transaction::where('user_id', $userId)
            ->where('type', 'depense')
            ->sum('montant');

        $revenus = Groupe7Transaction::where('user_id', $userId)
            ->where('type', 'revenu')
            ->sum('montant');

        $solde = $revenus - $depenses;

        $stats = [
            'total_depenses' => $depenses,
            'total_revenus' => $revenus,
            'solde' => $solde,
            'transactions_mois' => Groupe7Transaction::where('user_id', $userId)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
        ];

        return response()->json($stats);
    }

    public function byCategorie(Request $request)
    {
        $userId = $request->user()->id;

        $stats = Groupe7Transaction::where('user_id', $userId)
            ->selectRaw('categorie_id, type, SUM(montant) as total')
            ->groupBy('categorie_id', 'type')
            ->with('categorie')
            ->get();

        return response()->json($stats);
    }
}

