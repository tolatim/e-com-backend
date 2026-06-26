@extends('layouts.layout')

@section('title', $category->name)

@section('content')
<div class="w-full">

    {{-- Breadcrumb / back --}}
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.categories.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Categories
        </a>

        <a href="{{ route('admin.categories.edit', $category->id) }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h2m-7 1.5L15.5 4 20 8.5 9.5 19H5v-4.5L15.5 4z" />
            </svg>
            Edit category
        </a>
    </div>

    {{-- Details card --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="grid sm:grid-cols-[220px,1fr]">

            {{-- Image --}}
            <div class="bg-slate-50 border-b sm:border-b-0 sm:border-r border-slate-100 flex items-center justify-center p-6">
                @if ($category->image)
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
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
                        <h1 class="text-xl font-semibold text-slate-900">{{ $category->name }}</h1>
                        <p class="mt-1 text-sm text-slate-400 font-mono">{{ $category->slug }}</p>
                    </div>

                    @if ($category->is_active)
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
                        {{ $category->description ?: 'No description provided.' }}
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex gap-4 text-xs text-slate-400">
                    <span>Created {{ $category->created_at->format('M j, Y') }}</span>
                    <span>Updated {{ $category->updated_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Products in this category --}}
    <div class="mt-6 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-700">Products in this category</h2>
            <span class="text-xs font-medium text-slate-400">{{ $category->products->count() }} total</span>
        </div>

        @if ($category->products->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 px-6 text-center">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-sm text-slate-400">No products in this category yet.</p>
            </div>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach ($category->products as $product)
                    <li>
                        <a href="{{ route('admin.products.show', $product->id) }}"
                           class="flex items-center gap-4 px-6 py-3 hover:bg-slate-50/60 transition-colors">

                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                     class="w-10 h-10 rounded-md object-cover border border-slate-200">
                            @else
                                <div class="w-10 h-10 rounded-md bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-300 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5M16 6l-4-4-4 4M12 2v14" />
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 truncate">{{ $product->name }}</p>
                            </div>

                            <span class="text-sm font-medium text-slate-600 whitespace-nowrap">${{ number_format($product->price, 2) }}</span>

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

                            <svg class="w-4 h-4 text-slate-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection