@extends('layouts.app')

@section('title', __('ui.ripoti'))
@section('page-title', __('ui.ripoti_mauzo'))

@section('content')
<div class="py-4 space-y-6">

    <!-- Year selector -->
    <div class="flex items-center gap-3">
        <form method="GET" class="flex gap-2">
            <select name="mwaka" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                @foreach($miaka as $m)
                <option value="{{ $m }}" {{ $m == $mwaka ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
                @if($miaka->isEmpty())
                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                @endif
            </select>
        </form>
    </div>

    <!-- Year summary -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">{{ app()->getLocale() === 'sw' ? 'Mauzo' : 'Sales' }} {{ $mwaka }}</p>
            <p class="text-2xl font-bold text-gray-800">{{ $idadi_mauzo_mwaka }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">{{ __('ui.mapato') }}</p>
            <p class="text-2xl font-bold text-blue-700">{{ number_format($mapato_jumla_mwaka) }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">{{ app()->getLocale() === 'sw' ? 'Gharama' : 'Cost' }}</p>
            <p class="text-2xl font-bold text-gray-600">{{ number_format($gharama_jumla_mwaka) }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">{{ __('ui.faida') }}</p>
            <p class="text-2xl font-bold text-green-600">{{ number_format($faida_jumla_mwaka) }}</p>
        </div>
    </div>

    <!-- Monthly chart -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-700 mb-4">{{ app()->getLocale() === 'sw' ? 'Mauzo kwa Mwezi' : 'Monthly Sales' }} - {{ $mwaka }}</h3>
        <canvas id="mweziChart" height="80"></canvas>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Top products -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-700">{{ __('ui.bidhaa_bora') }} ({{ app()->getLocale() === 'sw' ? 'kwa faida' : 'by profit' }})</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($bidhaa_bora as $b)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-indigo-100 text-indigo-700 rounded text-xs flex items-center justify-center font-bold">{{ $loop->iteration }}</span>
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $b->jina }}</p>
                            <p class="text-xs text-gray-400">{{ $b->mauzo_count }} {{ app()->getLocale() === 'sw' ? 'mauzo' : 'sales' }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-bold text-green-600">{{ number_format($b->mauzo_sum_faida ?? 0) }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">{{ __('ui.hakuna_rekodi') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Top customers -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-700">{{ app()->getLocale() === 'sw' ? 'Wateja wa Kawaida' : 'Top Customers' }}</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($wateja_bora as $mteja)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center text-purple-700 font-bold text-sm">
                            {{ strtoupper(substr($mteja->jina, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $mteja->jina }}</p>
                            <p class="text-xs text-gray-400">{{ $mteja->mauzo_count }} {{ app()->getLocale() === 'sw' ? 'manunuzi' : 'purchases' }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ number_format($mteja->mauzo_sum_bei_iliyouzwa ?? 0) }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">{{ __('ui.hakuna_rekodi') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Days to sell by category -->
        @if($wastani_siku_kategoria->count())
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-700">{{ app()->getLocale() === 'sw' ? 'Wastani wa Siku za Kuuza kwa Kategoria' : 'Avg. Days to Sell by Category' }}</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($wastani_siku_kategoria as $k)
                <div class="flex items-center justify-between px-5 py-3">
                    <span class="text-sm font-medium text-gray-700">{{ $k->kategoria }}</span>
                    <div class="text-right">
                        <span class="text-sm font-bold text-indigo-700">{{ round($k->wastani_siku) }} {{ app()->getLocale() === 'sw' ? 'siku' : 'days' }}</span>
                        <span class="text-xs text-gray-400 ml-2">({{ $k->idadi }} {{ app()->getLocale() === 'sw' ? 'bidhaa' : 'items' }})</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('mweziChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($mauzo_kwa_mwezi->pluck('mwezi')),
        datasets: [
            {
                label: '{{ app()->getLocale() === "sw" ? "Faida" : "Profit" }}',
                data: @json($mauzo_kwa_mwezi->pluck('faida')),
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderRadius: 5,
            },
            {
                label: '{{ app()->getLocale() === "sw" ? "Mapato" : "Revenue" }}',
                data: @json($mauzo_kwa_mwezi->pluck('mapato')),
                backgroundColor: 'rgba(167, 243, 208, 0.7)',
                borderRadius: 5,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { ticks: { callback: v => v.toLocaleString() } }
        }
    }
});
</script>
@endpush
