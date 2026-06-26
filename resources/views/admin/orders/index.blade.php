@extends('layouts.layout')

@section('title', 'Orders')

@section('content')
<div class="w-full">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-slate-900">Orders</h1>
        <p class="mt-1 text-sm text-slate-500">View and manage customer orders.</p>
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

    {{-- Status tabs --}}
    @php
        $tabs = [
            'all'       => 'All orders',
            'pending'   => 'Pending',
            'paid'      => 'Paid',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    @endphp

    <div class="flex items-center gap-1 mb-6 border-b border-slate-200 overflow-x-auto">
        @foreach ($tabs as $key => $label)
            <a href="{{ route('admin.orders.index', $key === 'all' ? [] : ['status' => $key]) }}"
               class="px-4 py-2.5 text-sm font-medium whitespace-nowrap border-b-2 transition-colors
               {{ $status === $key ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                {{ $label }}
                <span class="ml-1.5 text-xs {{ $status === $key ? 'text-indigo-400' : 'text-slate-400' }}">
                    {{ $counts[$key] }}
                </span>
            </a>
        @endforeach
    </div>

    {{-- Table card --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

        @if ($orders->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 2L3 7v13a1 1 0 001 1h16a1 1 0 001-1V7l-6-5M9 2h6M9 2v5h6V2M3 7h18" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-slate-700">No orders found</p>
                <p class="text-sm text-slate-400 mt-1">There are no orders in this category yet.</p>
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Order</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Customer</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Total</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Payment</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Status</th>
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Date</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-3 font-medium text-slate-800">#{{ $order->id }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-3 text-right font-medium text-slate-700">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-3 text-slate-500 uppercase text-xs">{{ $order->payment_method }}</td>
                            <td class="px-6 py-3">
                                @include('admin.orders.partials.status-badge', ['status' => $order->status])
                            </td>
                            <td class="px-6 py-3 text-slate-500">{{ $order->created_at->format('M j, Y') }}</td>
                            <td class="px-6 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-700 font-medium">
                                    View
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    @if ($orders->hasPages())
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection