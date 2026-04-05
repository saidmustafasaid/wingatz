@extends('layouts.app')

@section('title', __('ui.dashibodi'))
@section('page-title', __('ui.karibu'))

@section('content')
<div class="py-4 space-y-6">

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">{{ __('ui.jumla_bidhaa') }}</p>
                <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $jumla_bidhaa }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $bidhaa_zinapatikana }} {{ __('ui.zinapatikana') }} · {{ $bidhaa_zimeuzwa }} {{ __('ui.zimeuzwa') }}</p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">{{ __('ui.faida_mwezi') }}</p>
                <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ number_format($faida_mwezi) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $mauzo_mwezi }} {{ __('ui.mauzo') }}</p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">{{ __('ui.faida_jumla') }}</p>
                <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-yellow-600">{{ number_format($faida_jumla) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ __('ui.mapato_jumla') }}: {{ number_format($mapato_jumla) }}</p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">{{ __('ui.jumla_wateja') }}</p>
                <div class="w-9 h-9 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $jumla_wateja }}</p>
            @if($wastani_siku)
            <p class="text-xs text-gray-400 mt-1">{{ __('ui.wastani_siku') }}: {{ round($wastani_siku) }} {{ app()->getLocale() === 'sw' ? 'siku' : 'days' }}</p>
            @endif
        </div>
    </div>

    <!-- Chart + Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue chart -->
        <div class="lg:col-span-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-700 mb-4">{{ app()->getLocale() === 'sw' ? 'Mwenendo wa Mauzo (Miezi 6)' : 'Sales Trend (6 Months)' }}</h3>
            <canvas id="mauzoChart" height="100"></canvas>
        </div>

        <!-- Top products -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-700 mb-4">{{ __('ui.bidhaa_bora') }}</h3>
            @forelse($bidhaa_bora as $b)
            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-6 h-6 bg-indigo-100 text-indigo-700 rounded text-xs flex items-center justify-center font-bold shrink-0">{{ $loop->iteration }}</span>
                    <span class="text-sm text-gray-700 truncate">{{ $b->jina }}</span>
                </div>
                <span class="text-sm font-semibold text-green-600 shrink-0 ml-2">{{ number_format($b->mauzo_sum_faida ?? 0) }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">{{ __('ui.hakuna_rekodi') }}</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Sales + Pending Inquiries -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Recent sales -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-700">{{ __('ui.hivi_karibuni') }}</h3>
                <a href="{{ route('mauzo.index') }}" class="text-indigo-600 text-sm hover:underline">{{ app()->getLocale() === 'sw' ? 'Ona zote' : 'See all' }} →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($mauzo_hivi_karibuni as $uuzaji)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $uuzaji->bidhaa->jina ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $uuzaji->mteja->jina ?? '-' }} · {{ $uuzaji->tarehe_ya_uuzaji->format('d M Y') }}</p>
                    </div>
                    <div class="text-right shrink-0 ml-3">
                        <p class="text-sm font-bold text-green-600">+{{ number_format($uuzaji->faida) }}</p>
                        <p class="text-xs text-gray-400">{{ number_format($uuzaji->bei_iliyouzwa) }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">{{ __('ui.hakuna_rekodi') }}</p>
                @endforelse
            </div>
        </div>

        <!-- Pending inquiries -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-700">{{ __('ui.maswali_yanayosubiri') }}</h3>
                <a href="{{ route('maswali.index') }}" class="text-indigo-600 text-sm hover:underline">{{ app()->getLocale() === 'sw' ? 'Ona zote' : 'See all' }} →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($maswali_yanayosubiri as $swali)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $swali->mteja->jina ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $swali->bidhaa->jina ?? (app()->getLocale() === 'sw' ? 'Bidhaa si maalum' : 'General inquiry') }}</p>
                        @if($swali->ujumbe)
                        <p class="text-xs text-gray-500 truncate">{{ Str::limit($swali->ujumbe, 40) }}</p>
                        @endif
                    </div>
                    <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full shrink-0 ml-2">{{ __('ui.inasubiri') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">{{ __('ui.hakuna_rekodi') }}</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('mauzoChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($mauzo_chart->pluck('mwezi')),
        datasets: [
            {
                label: '{{ app()->getLocale() === "sw" ? "Faida" : "Profit" }}',
                data: @json($mauzo_chart->pluck('faida')),
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderRadius: 6,
            },
            {
                label: '{{ app()->getLocale() === "sw" ? "Mapato" : "Revenue" }}',
                data: @json($mauzo_chart->pluck('mauzo')),
                backgroundColor: 'rgba(167, 243, 208, 0.8)',
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: {
                ticks: {
                    callback: val => val.toLocaleString()
                }
            }
        }
    }
});
</script>
@endpush
