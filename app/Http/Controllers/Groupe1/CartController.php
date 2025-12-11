<?php

namespace App\Http\Controllers\Groupe1;

use App\Http\Controllers\Controller;
use App\Models\Groupe1Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = Groupe1Cart::where('user_id', $request->user()->id)
            ->with('product')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'items' => $cartItems,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:groupe1_products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Groupe1Cart::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = Groupe1Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json($cartItem->load('product'), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Groupe1Cart::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json($cartItem->load('product'));
    }

    public function remove($id, Request $request)
    {
        $cartItem = Groupe1Cart::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $cartItem->delete();

        return response()->json(['message' => 'Article supprimé du panier'], 200);
    }
}

