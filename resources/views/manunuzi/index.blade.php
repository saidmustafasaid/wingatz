@extends('layouts.app')

@section('title', __('ui.manunuzi'))
@section('page-title', __('ui.manunuzi'))

@section('content')
<div class="py-4 space-y-4">

    <!-- Summary bar -->
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex flex-wrap gap-6">
        <div>
            <p class="text-xs text-gray-500">{{ app()->getLocale() === 'sw' ? 'Jumla ya Gharama' : 'Total Purchases' }}</p>
            <p class="text-xl font-bold text-red-600">{{ number_format($jumla_gharama) }} TZS</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <form method="GET" class="flex gap-2 flex-1 flex-wrap">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}"
                   class="flex-1 min-w-40 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <input type="date" name="tarehe_from" value="{{ request('tarehe_from') }}"
                   class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <input type="date" name="tarehe_to" value="{{ request('tarehe_to') }}"
                   class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-semibold">{{ __('ui.chuja') }}</button>
        </form>
        <a href="{{ route('manunuzi.create') }}" class="btn-primary text-white px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_ununuzi') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.bidhaa') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.msambazaji') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.idadi') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.bei_ya_kununulia') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.jumla') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.tarehe') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.hatua') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($manunuzi as $m)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3 font-medium text-gray-800">
                        <a href="{{ route('bidhaa.show', $m->bidhaa) }}" class="hover:text-indigo-700">{{ $m->bidhaa->jina ?? '-' }}</a>
                    </td>
                    <td class="px-5 py-3 text-gray-500 hidden md:table-cell">{{ $m->msambazaji->jina ?? '-' }}</td>
                    <td class="px-5 py-3 text-right text-gray-700">{{ $m->idadi }} {{ $m->bidhaa->kitengo ?? '' }}</td>
                    <td class="px-5 py-3 text-right text-gray-700">{{ number_format($m->bei_ya_kununulia) }}</td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">{{ number_format($m->idadi * $m->bei_ya_kununulia) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $m->tarehe->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <form method="POST" action="{{ route('manunuzi.destroy', $m) }}" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                            @csrf @method('DELETE')
                            <button class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-200 transition">{{ __('ui.futa') }}</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">{{ __('ui.hakuna_rekodi') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $manunuzi->withQueryString()->links() }}</div>
</div>
@endsection
