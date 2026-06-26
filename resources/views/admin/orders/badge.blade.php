@php
    $styles = [
        'pending'    => ['bg-amber-50', 'text-amber-600', 'bg-amber-500', 'Pending'],
        'processing' => ['bg-blue-50', 'text-blue-600', 'bg-blue-500', 'Paid'],
        'completed'  => ['bg-emerald-50', 'text-emerald-600', 'bg-emerald-500', 'Completed'],
        'cancelled'  => ['bg-red-50', 'text-red-600', 'bg-red-500', 'Cancelled'],
    ];
    [$bg, $text, $dot, $label] = $styles[$status] ?? ['bg-slate-100', 'text-slate-500', 'bg-slate-400', ucfirst($status)];
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full {{ $bg }} px-2.5 py-1 text-xs font-medium {{ $text }} whitespace-nowrap">
    <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
    {{ $label }}
</span>