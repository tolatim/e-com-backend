@extends('layouts.layout')

@section('title', 'Edit ' . $user->name)

@section('content')
<div class="space-y-6 max-w-2xl">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.show', $user) }}"
           class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit User</h1>
            <p class="text-sm text-slate-500 mt-0.5">Update information for <span class="font-medium text-slate-700">{{ $user->name }}</span></p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm">

        {{-- User context strip --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 bg-slate-50 rounded-t-xl">
            <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-medium text-slate-700">{{ $user->name }}</p>
                <p class="text-xs text-slate-400">ID #{{ $user->id }} · Member since {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Full name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full px-3.5 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 transition-colors
                           {{ $errors->has('name')
                               ? 'border-red-300 focus:ring-red-200 bg-red-50'
                               : 'border-slate-200 focus:ring-slate-300 bg-white' }}"
                       placeholder="Full name">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Email address <span class="text-red-500">*</span>
                </label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full px-3.5 py-2.5 text-sm border rounded-lg focus:outline-none focus:ring-2 transition-colors
                           {{ $errors->has('email')
                               ? 'border-red-300 focus:ring-red-200 bg-red-50'
                               : 'border-slate-200 focus:ring-slate-300 bg-white' }}"
                       placeholder="email@example.com">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Role <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-3">
                    {{-- Customer option --}}
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="role" value="customer"
                               class="peer sr-only"
                               {{ old('role', $user->role) === 'customer' ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-4 transition-all
                                    peer-checked:border-slate-800 peer-checked:bg-slate-50
                                    border-slate-200 hover:border-slate-300">
                            <div class="flex items-center gap-3 mb-1.5">
                                <div class="w-8 h-8 rounded-full bg-slate-100 peer-checked:bg-slate-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-700 text-sm">Customer</span>
                            </div>
                            <p class="text-xs text-slate-400">Can browse and place orders</p>
                        </div>
                    </label>

                    {{-- Admin option --}}
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="role" value="admin"
                               class="peer sr-only"
                               {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                        <div class="border-2 rounded-xl p-4 transition-all
                                    peer-checked:border-violet-600 peer-checked:bg-violet-50
                                    border-slate-200 hover:border-slate-300">
                            <div class="flex items-center gap-3 mb-1.5">
                                <div class="w-8 h-8 rounded-full bg-violet-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-700 text-sm">Admin</span>
                            </div>
                            <p class="text-xs text-slate-400">Full access to admin panel</p>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Note about password --}}
            <div class="flex items-start gap-2.5 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p class="text-xs text-blue-600">Password changes are not available here. Users can reset their own password through the forgot password flow.</p>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <a href="{{ route('admin.users.show', $user) }}"
                   class="px-4 py-2.5 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-sm font-semibold bg-slate-800 text-white rounded-lg hover:bg-slate-700 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save changes
                </button>
            </div>
        </form>
    </div>

</div>
@endsection