@extends('layouts.layout')

@section('title', 'New Product')

@section('content')
<div class="w-full">

    {{-- Breadcrumb / back --}}
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Products
        </a>
    </div>

    {{-- Card --}}
    <div class="w-full bg-white border border-slate-200 rounded-xl shadow-sm">

        {{-- Header --}}
        <div class="px-6 sm:px-8 py-6 border-b border-slate-100">
            <h1 class="text-xl font-semibold text-slate-900">New product</h1>
            <p class="mt-1 text-sm text-slate-500">Add a new product to your catalog.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="px-6 sm:px-8 py-6 space-y-6">
            @csrf

            {{-- Name + Category --}}
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Wireless Mouse"
                        class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-shadow
                        {{ $errors->has('name') ? 'border-red-300 focus:border-red-400' : 'border-slate-300 focus:border-indigo-500' }}"
                    >
                    @error('name')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Category
                    </label>
                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-shadow bg-white"
                    >
                        <option value="">— No category —</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Price + Stock --}}
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">$</span>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            step="0.01"
                            min="0"
                            value="{{ old('price') }}"
                            placeholder="0.00"
                            class="w-full rounded-lg border pl-7 pr-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-shadow
                            {{ $errors->has('price') ? 'border-red-300 focus:border-red-400' : 'border-slate-300 focus:border-indigo-500' }}"
                        >
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-slate-700 mb-1.5">
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        min="0"
                        value="{{ old('stock', 0) }}"
                        placeholder="0"
                        class="w-full rounded-lg border px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-shadow
                        {{ $errors->has('stock') ? 'border-red-300 focus:border-red-400' : 'border-slate-300 focus:border-indigo-500' }}"
                    >
                    @error('stock')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Description
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Short description shown on the product page (optional)"
                    class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-shadow resize-none"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Image
                </label>

                <label for="image"
                       id="dropzone"
                       class="group flex items-center gap-4 rounded-lg border-2 border-dashed border-slate-300 hover:border-indigo-400 bg-slate-50/50 hover:bg-indigo-50/30 px-4 py-4 cursor-pointer transition-colors">

                    <div id="previewWrap" class="hidden flex-shrink-0">
                        <img id="previewImg" src="" alt="" class="w-14 h-14 rounded-md object-cover border border-slate-200">
                    </div>

                    <div id="placeholderIcon" class="flex-shrink-0 w-14 h-14 rounded-md bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V18a2 2 0 002 2h14a2 2 0 002-2v-1.5M16 6l-4-4-4 4M12 2v14" />
                        </svg>
                    </div>

                    <div class="text-sm">
                        <span class="font-medium text-indigo-600 group-hover:text-indigo-700">Click to upload</span>
                        <span class="text-slate-500"> or drag and drop</span>
                        <p id="fileName" class="text-xs text-slate-400 mt-0.5">PNG, JPG or WEBP, up to 2MB</p>
                    </div>
                </label>

                <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/webp" class="sr-only">

                @error('image')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active toggle --}}
            <div class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3.5">
                <div>
                    <p class="text-sm font-medium text-slate-700">Active</p>
                    <p class="text-xs text-slate-400 mt-0.5">Visible to customers when enabled</p>
                </div>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                    <div class="w-10 h-6 bg-slate-200 rounded-full peer-checked:bg-indigo-600 transition-colors"></div>
                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full shadow-sm transition-transform peer-checked:translate-x-4"></div>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                <a href="{{ route('admin.products.index') }}"
                   class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 active:bg-indigo-800 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Save product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const previewWrap = document.getElementById('previewWrap');
    const previewImg = document.getElementById('previewImg');
    const placeholderIcon = document.getElementById('placeholderIcon');
    const fileName = document.getElementById('fileName');
    const dropzone = document.getElementById('dropzone');

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];
        if (!file) return;

        fileName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            previewWrap.classList.remove('hidden');
            placeholderIcon.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    ['dragenter', 'dragover'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => {
            e.preventDefault();
            dropzone.classList.add('border-indigo-400', 'bg-indigo-50/30');
        });
    });

    ['dragleave', 'drop'].forEach(evt => {
        dropzone.addEventListener(evt, (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-indigo-400', 'bg-indigo-50/30');
        });
    });

    dropzone.addEventListener('drop', (e) => {
        const file = e.dataTransfer.files[0];
        if (file) {
            imageInput.files = e.dataTransfer.files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection