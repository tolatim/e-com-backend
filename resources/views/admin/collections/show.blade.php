@extends('layouts.layout')

@section('title', $collection->name)

@section('content')
<div class="w-full">

    {{-- Breadcrumb / back --}}
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.collections.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Collections
        </a>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.collections.edit', $collection->id) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h2m-7 1.5L15.5 4 20 8.5 9.5 19H5v-4.5L15.5 4z" />
                </svg>
                Edit collection
            </a>
            <form action="{{ route('admin.collections.destroy', $collection->id) }}" method="POST"
                  onsubmit="return confirm('Delete this collection? This cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-red-200 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0l-1 13a1 1 0 01-1 1H8a1 1 0 01-1-1L6 7h12z" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7 7a1 1 0 01-1.4 0l-3-3a1 1 0 111.4-1.4l2.3 2.29 6.3-6.29a1 1 0 011.4 0z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="grid sm:grid-cols-[220px,1fr]">

            {{-- Image --}}
            <div class="bg-slate-50 border-b sm:border-b-0 sm:border-r border-slate-100 flex items-center justify-center p-6">
                @if ($collection->image)
                    <img src="{{ asset($collection->image) }}" alt="{{ $collection->name }}"
                         class="w-full max-w-[160px] aspect-square rounded-lg object-cover border border-slate-200">
                @else
                    <div class="w-full max-w-[160px] aspect-square rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5M16 6l-4-4-4 4M12 2v14" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900">{{ $collection->name }}</h1>
                        <p class="mt-1 text-sm text-slate-400 font-mono">{{ $collection->slug }}</p>
                    </div>

                    @if ($collection->is_active)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600 whitespace-nowrap">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500 whitespace-nowrap">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            Inactive
                        </span>
                    @endif
                </div>

                <div class="mt-6">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1.5">Description</p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $collection->description ?: 'No description provided.' }}
                    </p>
                </div>

                <div class="mt-6 rounded-lg border border-slate-200 px-4 py-3 inline-block">
                    <p class="text-xs text-slate-400">Products</p>
                    <p class="mt-1 text-lg font-semibold text-slate-800">{{ $collection->products->count() }}</p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex gap-4 text-xs text-slate-400">
                    <span>Created {{ $collection->created_at->format('M j, Y') }}</span>
                    <span>Updated {{ $collection->updated_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Products table --}}
    <div class="mt-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">Products in this collection</h2>
        </div>

        @if ($collection->products->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-700">No products yet</p>
                <p class="text-sm text-slate-400 mt-1">Edit this collection to add products to it.</p>
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left font-medium text-slate-500 px-6 py-3 w-20">Image</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Name</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Price</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($collection->products as $product)
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
                            <td class="px-6 py-3 text-slate-600">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $product->stock ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection