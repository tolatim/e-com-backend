@extends('layouts.layout')

@section('title', 'Products')

@section('content')
<div class="w-full">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Products</h1>
            <p class="mt-1 text-sm text-slate-500">Manage your product catalog, pricing, and stock.</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 active:bg-indigo-800 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            New product
        </a>
    </div>

    {{-- Success banner --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7 7a1 1 0 01-1.4 0l-3-3a1 1 0 111.4-1.4l2.3 2.29 6.3-6.29a1 1 0 011.4 0z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table card --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

        @if ($products->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-700">No products yet</p>
                <p class="text-sm text-slate-400 mt-1">Add your first product to start building your catalog.</p>
                <a href="{{ route('admin.products.create') }}"
                   class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                    + New product
                </a>
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left font-medium text-slate-500 px-6 py-3 w-20">Image</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Name</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Category</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Price</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Stock</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Status</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($products as $product)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-3">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                         class="w-10 h-10 rounded-md object-cover border border-slate-200">
                                @else
                                    <div class="w-10 h-10 rounded-md bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5M16 6l-4-4-4 4M12 2v14" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-3 font-medium text-slate-800">{{ $product->name }}</td>
                            <td class="px-6 py-3 text-slate-500">
                                @if ($product->category)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                        {{ $product->category->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right text-slate-700 font-medium">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-3 text-right">
                                @if ($product->stock == 0)
                                    <span class="text-red-600 font-medium">{{ $product->stock }}</span>
                                @elseif ($product->stock <= 5)
                                    <span class="text-amber-600 font-medium">{{ $product->stock }}</span>
                                @else
                                    <span class="text-slate-700">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @if ($product->is_active)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                       title="View"
                                       class="p-2 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S5.5 5 12 5s9.5 7 9.5 7-3 7-9.5 7-9.5-7-9.5-7z" />
                                            <circle cx="12" cy="12" r="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                       title="Edit"
                                       class="p-2 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h2m-7 1.5L15.5 4 20 8.5 9.5 19H5v-4.5L15.5 4z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this product? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                                class="p-2 rounded-md text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0l-1 13a1 1 0 01-1 1H8a1 1 0 01-1-1L6 7h12z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if ($products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection