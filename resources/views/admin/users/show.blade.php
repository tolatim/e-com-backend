@extends('layouts.layout')

@section('title', $user->name)

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}"
           class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">User Details</h1>
            <p class="text-sm text-slate-500 mt-0.5">Viewing profile and order history</p>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: User Profile Card --}}
        <div class="space-y-4">

            {{-- Profile --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center text-2xl font-bold text-slate-600 mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>

                    <div class="flex gap-2 mt-3">
                        {{-- Role badge --}}
                        @if ($user->role === 'admin')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-violet-100 text-violet-700">Admin</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Customer</span>
                        @endif

                        {{-- Status badge --}}
                        @if ($user->blocked_at)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Blocked
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Meta info --}}
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Member since</dt>
                        <dd class="font-medium text-slate-700">{{ $user->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Last updated</dt>
                        <dd class="font-medium text-slate-700">{{ $user->updated_at->format('M d, Y') }}</dd>
                    </div>
                    @if ($user->blocked_at)
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Blocked on</dt>
                            <dd class="font-medium text-red-600">{{ \Carbon\Carbon::parse($user->blocked_at)->format('M d, Y') }}</dd>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Email verified</dt>
                        <dd class="font-medium {{ $user->email_verified_at ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $user->email_verified_at ? 'Yes' : 'No' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Total orders</dt>
                        <dd class="font-bold text-slate-800">{{ $orders->total() }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Actions --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 space-y-2">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Actions</h3>

                <a href="{{ route('admin.users.edit', $user) }}"
                   class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit information
                </a>

                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.toggle-block', $user) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="flex items-center gap-3 w-full px-3 py-2.5 text-sm rounded-lg transition-colors
                                    {{ $user->blocked_at ? 'text-emerald-700 hover:bg-emerald-50' : 'text-amber-700 hover:bg-amber-50' }}">
                            @if ($user->blocked_at)
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                </svg>
                                Unblock user
                            @else
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zM10 11V7a2 2 0 114 0v4"/>
                                </svg>
                                Block user
                            @endif
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                          onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-3 w-full px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete account
                        </button>
                    </form>
                @endif
            </div>

        </div>

        {{-- Right: Order History --}}
        <div class="lg:col-span-2">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">Order History</h3>
                    <span class="text-sm text-slate-500">{{ $orders->total() }} {{ Str::plural('order', $orders->total()) }}</span>
                </div>

                @if ($orders->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                        <svg class="w-10 h-10 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="font-medium text-slate-500">No orders yet</p>
                        <p class="text-sm mt-1">This user hasn't placed any orders</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($orders as $order)
                            <div class="px-5 py-4">
                                {{-- Order header --}}
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-3">
                                        <span class="font-semibold text-slate-800 text-sm">#{{ $order->id }}</span>
                                        {{-- Status badge - adjust values to match your status enum --}}
                                        @php
                                            $statusColors = [
                                                'pending'   => 'bg-amber-100 text-amber-700',
                                                'confirmed' => 'bg-blue-100 text-blue-700',
                                                'shipped'   => 'bg-violet-100 text-violet-700',
                                                'delivered' => 'bg-emerald-100 text-emerald-700',
                                                'cancelled' => 'bg-red-100 text-red-600',
                                            ];
                                            $statusColor = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600';
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-slate-800">${{ number_format($order->total_amount, 2) }}</p>
                                        <p class="text-xs text-slate-400">{{ $order->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                {{-- Order items --}}
                                @if ($order->items->isNotEmpty())
                                    <div class="space-y-1.5">
                                        @foreach ($order->items->take(3) as $item)
                                            <div class="flex items-center justify-between text-xs text-slate-500">
                                                <span class="flex items-center gap-1.5">
                                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                    {{ $item->product->name ?? 'Product deleted' }}
                                                    <span class="text-slate-400">× {{ $item->quantity }}</span>
                                                </span>
                                                <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                                            </div>
                                        @endforeach
                                        @if ($order->items->count() > 3)
                                            <p class="text-xs text-slate-400 pl-3">
                                                + {{ $order->items->count() - 3 }} more {{ Str::plural('item', $order->items->count() - 3) }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($orders->hasPages())
                        <div class="px-5 py-4 border-t border-slate-100">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>
@endsection