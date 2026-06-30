<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Product;

class CollectionController extends Controller
{
    // GET /collections
    public function index()
    {
        $collections = Collection::with('products')
            ->latest()
            ->paginate(10);

        return view('admin.collections.index', compact('collections'));
    }

    // GET /collections/create
    // GET /collections/create
    public function create(Request $request)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->paginate(20);

        return view('admin.collections.create', compact('products'));
    }
    // POST /collections
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:collections',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/collections'), $filename);
            $imagePath = 'uploads/collections/' . $filename;
        }

        $collection = Collection::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ]);

        // attach products
        if ($request->filled('products')) {
            $collection->products()->attach($request->products);
        }

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection created successfully!');
    }

    // GET /collections/{collection}
    public function show(Collection $collection)
    {
        $collection->load('products');

        return view('admin.collections.show', compact('collection'));
    }

    // GET /collections/{collection}/edit

    public function edit(Request $request, Collection $collection)
    {
        $query = Product::query();

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $products = $query->paginate(20);

        $collection->load('products');

        return view('admin.collections.edit', compact('collection', 'products'));
    }
    // PUT/PATCH /collections/{collection}
    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:collections,slug,' . $collection->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $collection->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/collections'), $filename);
            $imagePath = 'uploads/collections/' . $filename;
        }

        $collection->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->is_active ?? $collection->is_active,
        ]);
        $collection->products()->sync($request->products ?? []);
        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection updated successfully!');
    }

    // DELETE /collections/{collection}
    public function destroy(Collection $collection)
    {
        $collection->delete();

        return redirect()
            ->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully!');
    }
}
