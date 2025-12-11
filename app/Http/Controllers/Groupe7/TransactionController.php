<?php

namespace App\Http\Controllers\Groupe7;

use App\Http\Controllers\Controller;
use App\Models\Groupe7Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Groupe7Transaction::where('user_id', $request->user()->id)
            ->with('categorie')
            ->orderBy('date', 'desc')
            ->paginate(15);

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:depense,revenu',
            'montant' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:groupe7_categories,id',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $transaction = Groupe7Transaction::create([
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'montant' => $request->montant,
            'categorie_id' => $request->categorie_id,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return response()->json($transaction->load('categorie'), 201);
    }

    public function show($id, Request $request)
    {
        $transaction = Groupe7Transaction::where('user_id', $request->user()->id)
            ->with('categorie')
            ->findOrFail($id);

        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Groupe7Transaction::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $request->validate([
            'type' => 'sometimes|in:depense,revenu',
            'montant' => 'sometimes|numeric|min:0',
            'categorie_id' => 'sometimes|exists:groupe7_categories,id',
            'date' => 'sometimes|date',
            'description' => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return response()->json($transaction->load('categorie'));
    }

    public function destroy($id, Request $request)
    {
        $transaction = Groupe7Transaction::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $transaction->delete();

        return response()->json(['message' => 'Transaction supprimée'], 200);
    }
}

