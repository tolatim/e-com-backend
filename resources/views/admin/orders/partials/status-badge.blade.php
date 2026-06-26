@php
    $styles = [
        'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
        'paid'      => 'bg-blue-50 text-blue-700 border-blue-200',
        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200',
    ];

    $style = $styles[$status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $style }}">
    {{ ucfirst($status) }}
</span>