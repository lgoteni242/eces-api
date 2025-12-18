<?php

namespace App\Http\Controllers\Groupe1;

use App\Http\Controllers\Controller;
use App\Models\Groupe1Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cartItems = Groupe1Cart::where('user_id', $request->user()->id)
                ->with('product')
                ->get();

            // Filtrer les items avec des produits supprimés
            $validItems = $cartItems->filter(function ($item) {
                return $item->product !== null;
            });

            // Supprimer les items orphelins
            $orphanedItems = $cartItems->filter(function ($item) {
                return $item->product === null;
            });

            foreach ($orphanedItems as $item) {
                $item->delete();
            }

            $total = $validItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'items' => $validItems->values(),
                    'total' => $total,
                ],
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération du panier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération du panier',
                'errors' => [],
            ], 500);
        }
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:groupe1_products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Vérifier que le produit existe et a du stock
            $product = \App\Models\Groupe1Product::findOrFail($request->product_id);

            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuffisant',
                    'errors' => [
                        'quantity' => ['Le stock disponible est de ' . $product->stock . ' unité(s).'],
                    ],
                ], 400);
            }

            $cartItem = Groupe1Cart::where('user_id', $request->user()->id)
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->quantity + $request->quantity;
                if ($newQuantity > $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Stock insuffisant',
                        'errors' => [
                            'quantity' => ['Le stock disponible est de ' . $product->stock . ' unité(s).'],
                        ],
                    ], 400);
                }
                $cartItem->quantity = $newQuantity;
                $cartItem->save();
            } else {
                $cartItem = Groupe1Cart::create([
                    'user_id' => $request->user()->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Article ajouté au panier',
                'data' => $cartItem->load('product'),
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de l\'ajout au panier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout au panier',
                'errors' => [],
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);

            $cartItem = Groupe1Cart::where('user_id', $request->user()->id)
                ->with('product')
                ->findOrFail($id);

            if (!$cartItem->product) {
                $cartItem->delete();
                return response()->json([
                    'success' => false,
                    'message' => 'Le produit n\'existe plus',
                    'errors' => [],
                ], 404);
            }

            if ($request->quantity > $cartItem->product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuffisant',
                    'errors' => [
                        'quantity' => ['Le stock disponible est de ' . $cartItem->product->stock . ' unité(s).'],
                    ],
                ], 400);
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Panier mis à jour',
                'data' => $cartItem->load('product'),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la mise à jour du panier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la mise à jour du panier',
                'errors' => [],
            ], 500);
        }
    }

    public function remove($id, Request $request)
    {
        try {
            $cartItem = Groupe1Cart::where('user_id', $request->user()->id)
                ->findOrFail($id);

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Article supprimé du panier',
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la suppression du panier: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression',
                'errors' => [],
            ], 500);
        }
    }
}
