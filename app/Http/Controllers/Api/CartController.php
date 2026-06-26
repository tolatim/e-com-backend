<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * GET /api/cart
     * View current user's cart.
     */
    public function index(Request $request)
    {
        $items = Cart::with('product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        $subtotal = $items->sum(function ($item) {
            if (!$item->product) return 0;
            return $item->quantity * $item->product->price;
        });

        return CartResource::collection($items)->additional([
            'meta' => [
                'item_count' => $items->sum('quantity'),
                'subtotal'   => round($subtotal, 2),
            ],
        ]);
    }

    /**
     * POST /api/cart
     * Add a product to the cart. If it's already in the cart, increments quantity instead of duplicating.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $requestedQty = $validated['quantity'] ?? 1;

        $cartItem = Cart::firstOrNew([
            'user_id'    => $request->user()->id,
            'product_id' => $product->id,
        ]);

        $newQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + $requestedQty;

        if ($newQuantity > $product->stock) {
            return response()->json([
                'message' => "Only {$product->stock} unit(s) of \"{$product->name}\" are available.",
            ], 422);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return (new CartResource($cartItem->load('product')))
            ->response()
            ->setStatusCode($cartItem->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * PUT /api/cart/{id}
     * Update quantity for a cart item owned by the current user.
     */
    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== $request->user()->id, 404);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated['quantity'] > $cart->product->stock) {
            return response()->json([
                'message' => "Only {$cart->product->stock} unit(s) of \"{$cart->product->name}\" are available.",
            ], 422);
        }

        $cart->update($validated);

        return new CartResource($cart->load('product'));
    }

    /**
     * DELETE /api/cart/{id}
     * Remove an item from the cart.
     */
    public function destroy(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== $request->user()->id, 404);

        $cart->delete();

        return response()->json(['message' => 'Item removed from cart.']);
    }
}
