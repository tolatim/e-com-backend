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

            // Search
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })

            // Category
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })

            // Sort
            ->when($request->filled('sort'), function ($query) use ($request) {

                switch ($request->sort) {

                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;

                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;

                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;

                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;

                    default:
                        $query->latest();
                        break;
                }
            }, function ($query) {
                $query->latest();
            })

            ->paginate(15)
            ->withQueryString();

        return ProductResource::collection($products);
    }
    /** new arrivals */
    public function newArrivals(Request $request)
    {
        $limit = $request->get('limit', 10);

        $products = Product::latest()
            ->take($limit)
            ->get();
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
