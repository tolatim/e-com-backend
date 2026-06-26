@extends('layouts.layout')

@section('title', $product->name)

@section('content')
<div class="w-full">

    {{-- Breadcrumb / back --}}
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Products
        </a>

        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h2m-7 1.5L15.5 4 20 8.5 9.5 19H5v-4.5L15.5 4z" />
            </svg>
            Edit product
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="grid sm:grid-cols-[220px,1fr]">

            {{-- Image --}}
            <div class="bg-slate-50 border-b sm:border-b-0 sm:border-r border-slate-100 flex items-center justify-center p-6">
                @if ($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
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
                        <h1 class="text-xl font-semibold text-slate-900">{{ $product->name }}</h1>
                        <p class="mt-1 text-sm text-slate-400 font-mono">{{ $product->slug }}</p>
                    </div>

                    @if ($product->is_active)
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

                <div class="mt-6 grid sm:grid-cols-3 gap-4">
                    <div class="rounded-lg border border-slate-200 px-4 py-3">
                        <p class="text-xs text-slate-400">Price</p>
                        <p class="mt-1 text-lg font-semibold text-slate-800">${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 px-4 py-3">
                        <p class="text-xs text-slate-400">Stock</p>
                        <p class="mt-1 text-lg font-semibold {{ $product->stock == 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-amber-600' : 'text-slate-800') }}">
                            {{ $product->stock }}
                        </p>
                    </div>
                    <div class="rounded-lg border border-slate-200 px-4 py-3">
                        <p class="text-xs text-slate-400">Category</p>
                        <p class="mt-1 text-sm font-medium text-slate-700">
                            {{ $product->category->name ?? '— None —' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1.5">Description</p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $product->description ?: 'No description provided.' }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex gap-4 text-xs text-slate-400">
                    <span>Created {{ $product->created_at->format('M j, Y') }}</span>
                    <span>Updated {{ $product->updated_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection