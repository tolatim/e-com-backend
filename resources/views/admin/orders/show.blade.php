@extends('layouts.layout')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="w-full max-w-4xl">

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to orders
            </a>
            <h1 class="text-xl font-semibold text-slate-900">Order #{{ $order->id }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">{{ $order->created_at->format('M j, Y · g:i A') }}</p>
        </div>

        {{-- Status badge --}}
        @include('admin.orders.partials.status-badge', ['status' => $order->status])
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 010 1.4l-7 7a1 1 0 01-1.4 0l-3-3a1 1 0 111.4-1.4l2.3 2.29 6.3-6.29a1 1 0 011.4 0z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Order Items --}}
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-medium text-slate-800">Order Items</h2>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="text-left font-medium text-slate-500 px-6 py-3">Product</th>
                        <th class="text-center font-medium text-slate-500 px-6 py-3">Qty</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Unit Price</th>
                        <th class="text-right font-medium text-slate-500 px-6 py-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-6 py-3 text-slate-800 font-medium">
                                {{ $item->product->name ?? 'Deleted product' }}
                            </td>
                            <td class="px-6 py-3 text-center text-slate-600">{{ $item->quantity }}</td>
                            <td class="px-6 py-3 text-right text-slate-600">${{ number_format($item->price, 2) }}</td>
                            <td class="px-6 py-3 text-right font-medium text-slate-800">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-slate-200 bg-slate-50">
                        <td colspan="3" class="px-6 py-3 text-right font-semibold text-slate-800">Total</td>
                        <td class="px-6 py-3 text-right font-bold text-slate-900">
                            ${{ number_format($order->total_price, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">

            {{-- Customer --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <h2 class="font-medium text-slate-800 mb-3">Customer</h2>
                <p class="text-sm font-medium text-slate-700">{{ $order->user->name ?? 'Guest' }}</p>
                <p class="text-sm text-slate-500">{{ $order->user->email ?? '—' }}</p>
            </div>

            {{-- Payment --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <h2 class="font-medium text-slate-800 mb-3">Payment</h2>
                <p class="text-sm text-slate-600 uppercase tracking-wide">
                    {{ $order->payment_method ?? '—' }}
                </p>
            </div>

            {{-- Update Status --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <h2 class="font-medium text-slate-800 mb-3">Update Status</h2>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status"
                        class="w-full text-sm border border-slate-300 rounded-lg px-3 py-2 mb-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach (['pending', 'processing', 'completed', 'cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium py-2 rounded-lg transition-colors">
                        Save Status
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection