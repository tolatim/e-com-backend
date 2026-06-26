@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')

{{-- ── Page header ──────────────────────────────────────────── --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-sm text-slate-500 mt-0.5">{{ now()->format('l, F j, Y') }}</p>
    </div>

    {{-- Quick Actions --}}
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            New category
        </a>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg hover:bg-slate-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New product
        </a>
    </div>
</div>

{{-- ── KPI grid ──────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Total Revenue --}}
    <div class="lg:col-span-2 bg-slate-800 text-white rounded-xl p-5 flex flex-col justify-between min-h-28 shadow-sm">
        <div class="flex items-center justify-between">
            <span class="text-sm font-medium text-slate-300">Total revenue</span>
            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div>
            <p class="text-3xl font-bold tracking-tight">${{ number_format($stats['total_revenue'], 2) }}</p>
            <p class="text-xs text-slate-400 mt-1">From {{ number_format($stats['completed_orders']) }} completed orders</p>
        </div>
    </div>

    {{-- Total Orders --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Orders</span>
            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_orders']) }}</p>
        <p class="text-xs text-slate-500 mt-1">
            <span class="text-amber-600 font-medium">{{ $stats['pending_orders'] }} pending</span>
        </p>
    </div>

    {{-- Total Users --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Users</span>
            <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_users']) }}</p>
        <p class="text-xs text-slate-500 mt-1">
            <span class="text-emerald-600 font-medium">+{{ $stats['new_users_today'] }} today</span>
            · +{{ $stats['new_users_week'] }} this week
        </p>
    </div>

    {{-- Products --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Products</span>
            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_products']) }}</p>
        <p class="text-xs text-slate-500 mt-1">
            {{ $stats['active_products'] }} active
            @if ($stats['out_of_stock'] > 0)
                · <span class="text-red-500 font-medium">{{ $stats['out_of_stock'] }} out of stock</span>
            @endif
        </p>
    </div>

    {{-- Categories --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Categories</span>
            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['total_categories']) }}</p>
        <p class="text-xs text-slate-500 mt-1">Product categories</p>
    </div>

    {{-- Completed Orders --}}
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Completed</span>
            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['completed_orders']) }}</p>
        @php $completionRate = $stats['total_orders'] > 0 ? round(($stats['completed_orders'] / $stats['total_orders']) * 100) : 0; @endphp
        <p class="text-xs text-slate-500 mt-1">{{ $completionRate }}% completion rate</p>
    </div>

</div>

{{-- ── Alerts ────────────────────────────────────────────────── --}}
@if ($lowStockProducts->isNotEmpty() || $stalePendingOrders->isNotEmpty() || $recentCancellations > 0 || $stats['out_of_stock'] > 0)
<div class="mb-6 space-y-3">

    {{-- Out of stock banner --}}
    @if ($stats['out_of_stock'] > 0)
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p class="text-sm text-red-700">
            <span class="font-semibold">{{ $stats['out_of_stock'] }} {{ Str::plural('product', $stats['out_of_stock']) }}</span>
            out of stock.
            <a href="{{ route('admin.products.index', ['stock' => 'out']) }}" class="underline hover:no-underline ml-1">View products →</a>
        </p>
    </div>
    @endif

    {{-- Low stock warning --}}
    @if ($lowStockProducts->isNotEmpty())
    <div class="bg-white border border-amber-200 rounded-xl overflow-hidden shadow-sm">
        <div class="flex items-center gap-2 px-4 py-3 bg-amber-50 border-b border-amber-100">
            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <p class="text-sm font-semibold text-amber-800">Low stock — action needed</p>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach ($lowStockProducts as $product)
            <div class="flex items-center justify-between px-4 py-2.5">
                <span class="text-sm text-slate-700">{{ $product->name }}</span>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                    {{ $product->stock <= 2 ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700' }}">
                    {{ $product->stock }} left
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Stale pending orders --}}
    @if ($stalePendingOrders->isNotEmpty())
    <div class="bg-white border border-orange-200 rounded-xl overflow-hidden shadow-sm">
        <div class="flex items-center gap-2 px-4 py-3 bg-orange-50 border-b border-orange-100">
            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-semibold text-orange-800">Pending orders older than 48 hours</p>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach ($stalePendingOrders as $order)
            <div class="flex items-center justify-between px-4 py-2.5">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-slate-700">#{{ $order->id }}</span>
                    <span class="text-sm text-slate-500">{{ $order->user->name ?? 'Deleted user' }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</span>
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-medium text-orange-600 hover:underline">Review →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Recent cancellations --}}
    @if ($recentCancellations > 0)
    <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">
        <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-sm text-slate-600">
            <span class="font-semibold text-slate-800">{{ $recentCancellations }}</span>
            {{ Str::plural('order', $recentCancellations) }} cancelled in the last 7 days.
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="underline hover:no-underline ml-1">View →</a>
        </p>
    </div>
    @endif

</div>
@endif

{{-- ── Orders by status + Analytics chart ──────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Order status breakdown --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">Orders by status</h2>
        @php
            $total = array_sum($ordersByStatus);
            $statusConfig = [
                'pending'   => ['label' => 'Pending',   'color' => 'bg-amber-400'],
                'paid'      => ['label' => 'Paid',      'color' => 'bg-blue-400'],
                'shipped'   => ['label' => 'Shipped',   'color' => 'bg-violet-400'],
                'completed' => ['label' => 'Completed', 'color' => 'bg-emerald-400'],
                'cancelled' => ['label' => 'Cancelled', 'color' => 'bg-red-400'],
            ];
        @endphp

        {{-- Stacked bar --}}
        @if ($total > 0)
        <div class="flex h-2 rounded-full overflow-hidden mb-5 gap-0.5">
            @foreach ($statusConfig as $key => $cfg)
                @php $pct = $total > 0 ? ($ordersByStatus[$key] / $total) * 100 : 0; @endphp
                @if ($pct > 0)
                    <div class="{{ $cfg['color'] }} rounded-full" style="width: {{ $pct }}%"></div>
                @endif
            @endforeach
        </div>
        @endif

        <div class="space-y-3">
            @foreach ($statusConfig as $key => $cfg)
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $cfg['color'] }}"></span>
                    <span class="text-sm text-slate-600">{{ $cfg['label'] }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-slate-800">{{ number_format($ordersByStatus[$key]) }}</span>
                    @if ($total > 0)
                        <span class="text-xs text-slate-400 w-8 text-right">{{ round(($ordersByStatus[$key] / $total) * 100) }}%</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-slate-400">Total orders</span>
            <span class="text-sm font-bold text-slate-800">{{ number_format($total) }}</span>
        </div>
    </div>

    {{-- Revenue chart (last 30 days) --}}
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-slate-700">Revenue & orders — last 30 days</h2>
            <div class="flex items-center gap-3 text-xs text-slate-400">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-0.5 bg-slate-700 rounded inline-block"></span>Revenue</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-0.5 bg-blue-400 rounded inline-block"></span>Orders</span>
            </div>
        </div>
        <canvas id="revenueChart" height="120"></canvas>
    </div>

</div>

{{-- ── Recent activity ─────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Latest orders --}}
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">Latest orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium text-slate-400 hover:text-slate-700 transition-colors">View all →</a>
        </div>
        @if ($latestOrders->isEmpty())
            <div class="flex items-center justify-center py-12 text-slate-400 text-sm">No orders yet</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-2.5 text-left">Order</th>
                        <th class="px-5 py-2.5 text-left">Customer</th>
                        <th class="px-5 py-2.5 text-left">Status</th>
                        <th class="px-5 py-2.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($latestOrders as $order)
                    @php
                        $badge = [
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'paid'      => 'bg-blue-100 text-blue-700',
                            'shipped'   => 'bg-violet-100 text-violet-700',
                            'completed' => 'bg-emerald-100 text-emerald-700',
                            'cancelled' => 'bg-red-100 text-red-600',
                        ][$order->status] ?? 'bg-slate-100 text-slate-600';
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-slate-800 hover:text-slate-600">#{{ $order->id }}</a>
                            <p class="text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $order->user->name ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-right font-semibold text-slate-800">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Latest users --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">New users</h2>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-slate-400 hover:text-slate-700 transition-colors">View all →</a>
        </div>
        @if ($latestUsers->isEmpty())
            <div class="flex items-center justify-center py-12 text-slate-400 text-sm">No users yet</div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach ($latestUsers as $user)
                <div class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600 flex-shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $user->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $user->email }}</p>
                    </div>
                    <span class="text-xs text-slate-400 flex-shrink-0">{{ $user->created_at->diffForHumans(null, true) }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- ── User growth + Latest products ──────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- User growth chart --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
        <h2 class="text-sm font-semibold text-slate-700 mb-4">User signups — last 30 days</h2>
        <canvas id="usersChart" height="160"></canvas>
    </div>

    {{-- Latest products --}}
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">Recently added products</h2>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-medium text-slate-400 hover:text-slate-700 transition-colors">View all →</a>
        </div>
        @if ($latestProducts->isEmpty())
            <div class="flex items-center justify-center py-12 text-slate-400 text-sm">No products yet</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-2.5 text-left">Product</th>
                        <th class="px-5 py-2.5 text-left">Category</th>
                        <th class="px-5 py-2.5 text-right">Price</th>
                        <th class="px-5 py-2.5 text-right">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($latestProducts as $product)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-slate-800 hover:text-slate-600">
                                {{ Str::limit($product->name, 36) }}
                            </a>
                            <p class="text-xs text-slate-400">{{ $product->created_at->diffForHumans() }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-xs">
                                {{ $product->category->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right font-medium text-slate-700">${{ number_format($product->price, 2) }}</td>
                        <td class="px-5 py-3 text-right">
                            @if ($product->stock === 0)
                                <span class="text-xs font-semibold text-red-500">Out</span>
                            @elseif ($product->stock <= 5)
                                <span class="text-xs font-semibold text-amber-600">{{ $product->stock }}</span>
                            @else
                                <span class="text-xs text-slate-600">{{ $product->stock }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>

{{-- ── Charts (Chart.js via CDN) ────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labels  = @json($chartLabels);
    const revenue = @json($chartRevenue);
    const orders  = @json($chartOrders);
    const users   = @json($chartUsers);

    const gridColor  = 'rgba(148,163,184,0.15)';
    const tickColor  = '#94a3b8';
    const fontFamily = "'Inter', 'system-ui', sans-serif";

    // ── Revenue + Orders chart ──────────────────────────────────
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            data: {
                labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Revenue ($)',
                        data: revenue,
                        borderColor: '#1e293b',
                        backgroundColor: 'rgba(30,41,59,0.06)',
                        borderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'yRevenue',
                    },
                    {
                        type: 'bar',
                        label: 'Orders',
                        data: orders,
                        backgroundColor: 'rgba(96,165,250,0.35)',
                        borderColor: 'rgba(96,165,250,0.7)',
                        borderWidth: 1,
                        borderRadius: 3,
                        yAxisID: 'yOrders',
                    },
                ],
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f1f5f9',
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => ctx.datasetIndex === 0
                                ? ` $${Number(ctx.raw).toLocaleString()}`
                                : ` ${ctx.raw} orders`,
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { color: gridColor },
                        ticks: { color: tickColor, font: { family: fontFamily, size: 10 }, maxTicksLimit: 8 },
                    },
                    yRevenue: {
                        position: 'left',
                        grid: { color: gridColor },
                        ticks: {
                            color: tickColor,
                            font: { family: fontFamily, size: 10 },
                            callback: v => '$' + Number(v).toLocaleString(),
                        },
                    },
                    yOrders: {
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        ticks: { color: tickColor, font: { family: fontFamily, size: 10 }, precision: 0 },
                    },
                },
            },
        });
    }

    // ── User signups chart ──────────────────────────────────────
    const usersCtx = document.getElementById('usersChart');
    if (usersCtx) {
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'New users',
                    data: users,
                    backgroundColor: 'rgba(139,92,246,0.3)',
                    borderColor: 'rgba(139,92,246,0.8)',
                    borderWidth: 1,
                    borderRadius: 3,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#f1f5f9',
                        padding: 10,
                        cornerRadius: 8,
                    },
                },
                scales: {
                    x: {
                        grid: { color: gridColor },
                        ticks: { color: tickColor, font: { family: fontFamily, size: 10 }, maxTicksLimit: 6 },
                    },
                    y: {
                        grid: { color: gridColor },
                        ticks: { color: tickColor, font: { family: fontFamily, size: 10 }, precision: 0 },
                    },
                },
            },
        });
    }
})();
</script>

@endsection