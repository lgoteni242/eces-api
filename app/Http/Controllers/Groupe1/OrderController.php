<?php

namespace App\Http\Controllers\Groupe1;

use App\Http\Controllers\Controller;
use App\Models\Groupe1Order;
use App\Models\Groupe1OrderItem;
use App\Models\Groupe1Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Groupe1Order::where('user_id', $request->user()->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $cartItems = Groupe1Cart::where('user_id', $request->user()->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Le panier est vide'], 400);
        }

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $order = Groupe1Order::create([
            'user_id' => $request->user()->id,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $cartItem) {
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

        return response()->json($order->load('items.product'), 201);
    }

    public function show($id, Request $request)
    {
        $order = Groupe1Order::where('user_id', $request->user()->id)
            ->with('items.product')
            ->findOrFail($id);

        return response()->json($order);
    }
}

