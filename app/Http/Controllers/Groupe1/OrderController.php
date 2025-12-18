<?php

namespace App\Http\Controllers\Groupe1;

use App\Http\Controllers\Controller;
use App\Models\Groupe1Order;
use App\Models\Groupe1OrderItem;
use App\Models\Groupe1Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $orders = Groupe1Order::where('user_id', $request->user()->id)
                ->with('items.product')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => $orders,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération des commandes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération des commandes',
                'errors' => [],
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $cartItems = Groupe1Cart::where('user_id', $request->user()->id)
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le panier est vide',
                    'errors' => [],
                ], 400);
            }

            // Filtrer les items avec des produits valides et vérifier le stock
            $validItems = [];
            $errors = [];

            foreach ($cartItems as $cartItem) {
                if (!$cartItem->product) {
                    $errors[] = 'Le produit ID ' . $cartItem->product_id . ' n\'existe plus';
                    $cartItem->delete();
                    continue;
                }

                if ($cartItem->quantity > $cartItem->product->stock) {
                    $errors[] = 'Stock insuffisant pour le produit: ' . $cartItem->product->name;
                    continue;
                }

                $validItems[] = $cartItem;
            }

            if (!empty($errors)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Certains articles ne peuvent pas être commandés',
                    'errors' => $errors,
                ], 400);
            }

            if (empty($validItems)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun article valide dans le panier',
                    'errors' => [],
                ], 400);
            }

            $total = collect($validItems)->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $order = Groupe1Order::create([
                'user_id' => $request->user()->id,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($validItems as $cartItem) {
                Groupe1OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                // Réduire le stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Vider le panier
            Groupe1Cart::where('user_id', $request->user()->id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Commande créée avec succès',
                'data' => $order->load('items.product'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Erreur lors de la création de la commande: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création de la commande',
                'errors' => [],
            ], 500);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $order = Groupe1Order::where('user_id', $request->user()->id)
                ->with('items.product')
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $order,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Commande non trouvée',
                'errors' => [],
            ], 404);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur lors de la récupération de la commande: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la récupération de la commande',
                'errors' => [],
            ], 500);
        }
    }
}
