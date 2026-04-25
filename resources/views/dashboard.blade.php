@extends('layouts.app')

@section('title', __('ui.dashibodi'))
@section('page-title', __('ui.karibu'))

@section('content')
<div class="py-4 space-y-6">

    <!-- Row 1: Core stats -->
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
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ number_format($faida_mwezi) }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $mauzo_mwezi }} {{ __('ui.mauzo') }}</p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">{{ __('ui.matumizi_mwezi') }}</p>
                <div class="w-9 h-9 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-orange-600">{{ number_format($matumizi_mwezi) }}</p>
            <p class="text-xs {{ $faida_halisi >= 0 ? 'text-green-500' : 'text-red-500' }} mt-1 font-semibold">
                {{ __('ui.faida_halisi') }}: {{ number_format($faida_halisi) }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm text-gray-500">{{ __('ui.madeni_yanayosubiri') }}</p>
                <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <a href="{{ route('madeni.index') }}">
                <p class="text-3xl font-bold text-red-600">{{ number_format($madeni_baki) }}</p>
            </a>
            <p class="text-xs text-gray-400 mt-1">{{ __('ui.jumla_wateja') }}: {{ $jumla_wateja }}</p>
        </div>
    </div>

    <!-- Row 2: Chart + Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <h3 class="font-semibold text-gray-700 mb-4">{{ app()->getLocale() === 'sw' ? 'Mwenendo wa Mauzo na Matumizi (Miezi 6)' : 'Sales vs Expenses Trend (6 Months)' }}</h3>
            <canvas id="mauzoChart" height="100"></canvas>
        </div>

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

    <!-- Row 3: Recent Sales + Debts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

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

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-700">{{ __('ui.madeni_yanayosubiri') }}</h3>
                <a href="{{ route('madeni.index') }}" class="text-indigo-600 text-sm hover:underline">{{ app()->getLocale() === 'sw' ? 'Ona zote' : 'See all' }} →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($madeni_yanayosubiri as $deni)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $deni->mteja->jina ?? '-' }}</p>
                        @if($deni->maelezo)<p class="text-xs text-gray-400 truncate">{{ Str::limit($deni->maelezo, 35) }}</p>@endif
                        @if($deni->tarehe_ya_kulipa)
                        <p class="text-xs text-orange-500">{{ app()->getLocale() === 'sw' ? 'Inaisha' : 'Due' }}: {{ $deni->tarehe_ya_kulipa->format('d M') }}</p>
                        @endif
                    </div>
                    <span class="text-sm font-bold text-red-600 shrink-0 ml-2">{{ number_format($deni->kiasi) }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">{{ app()->getLocale() === 'sw' ? 'Hakuna madeni yanayosubiri' : 'No outstanding debts' }}</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Row 4: Low Stock Alerts + Pending Inquiries -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        @if($bidhaa_stock_ndogo->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-orange-200 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-orange-100 bg-orange-50">
                <h3 class="font-semibold text-orange-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    {{ __('ui.stock_za_chini') }}
                </h3>
                <a href="{{ route('bidhaa.index') }}" class="text-orange-600 text-sm hover:underline">{{ app()->getLocale() === 'sw' ? 'Ona zote' : 'See all' }} →</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($bidhaa_stock_ndogo as $b)
                <div class="flex items-center justify-between px-5 py-3">
                    <div>
                        <a href="{{ route('bidhaa.show', $b) }}" class="text-sm font-medium text-gray-800 hover:text-indigo-700">{{ $b->jina }}</a>
                        <p class="text-xs text-gray-400">{{ $b->kategoria ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold text-orange-600">{{ $b->idadi }} {{ $b->kitengo }}</span>
                        <p class="text-xs text-gray-400">{{ app()->getLocale() === 'sw' ? 'Kiwango' : 'Min' }}: {{ $b->idadi_ya_chini }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

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
                        <p class="text-xs text-gray-400">{{ $swali->bidhaa->jina ?? (app()->getLocale() === 'sw' ? 'Swali la jumla' : 'General inquiry') }}</p>
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
            },
            {
                label: '{{ app()->getLocale() === "sw" ? "Matumizi" : "Expenses" }}',
                data: @json($mauzo_chart->pluck('matumizi')),
                backgroundColor: 'rgba(251, 146, 60, 0.7)',
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: {
                ticks: { callback: val => val.toLocaleString() }
            }
        }
    }
});
</script>
@endpush
