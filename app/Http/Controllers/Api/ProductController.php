<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * List products. Supports ?search=, ?category_id=, ?page=.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->query('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->query('category_id'));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return ProductResource::collection($products);
    }

    /**
     * GET /api/products/{id}
     * Single product with its category relation.
     */
    public function show(Product $product)
    {
        abort_if(! $product->is_active, 404);

        $product->load('category');

        return new ProductResource($product);
    }

    /**
     * GET /api/products/{id}/reviews
     * All reviews for a product.
     */
    public function reviews(Product $product)
    {
        abort_if(! $product->is_active, 404);

        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(15);

        return ReviewResource::collection($reviews);
    }
}