<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * GET /api/wishlist
     * View current user's wishlist.
     */
    public function index(Request $request)
    {
        $items = Wishlist::with('product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return WishlistResource::collection($items);
    }

    /**
     * POST /api/wishlist
     * Add a product to the wishlist. Idempotent — adding the same product twice
     * just returns the existing entry rather than creating a duplicate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $item = Wishlist::firstOrCreate([
            'user_id'    => $request->user()->id,
            'product_id' => $validated['product_id'],
        ]);

        return (new WishlistResource($item->load('product')))
            ->response()
            ->setStatusCode($item->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * DELETE /api/wishlist/{id}
     * Remove an item from the wishlist.
     */
    public function destroy(Request $request, Wishlist $wishlist)
    {
        abort_if($wishlist->user_id !== $request->user()->id, 404);

        $wishlist->delete();

        return response()->json(['message' => 'Removed from wishlist.']);
    }
}