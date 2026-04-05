@extends('layouts.app')

@section('title', __('ui.mauzo'))
@section('page-title', __('ui.mauzo'))

@section('content')
<div class="py-4 space-y-4">
    <div class="flex flex-wrap items-center gap-3 justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white"/>
            <input type="date" name="tarehe_kuanzia" value="{{ request('tarehe_kuanzia') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
            <input type="date" name="tarehe_hadi" value="{{ request('tarehe_hadi') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition">{{ __('ui.chuja') }}</button>
        </form>
        <a href="{{ route('mauzo.create') }}"
           class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.rekodi_uuzaji') }}
        </a>
    </div>

    <!-- Summary bar -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-green-50 border border-green-100 rounded-xl px-5 py-3 flex items-center justify-between">
            <span class="text-sm text-green-700">{{ __('ui.faida') }}</span>
            <span class="font-bold text-green-700 text-lg">{{ number_format($jumla_faida) }} TZS</span>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-3 flex items-center justify-between">
            <span class="text-sm text-blue-700">{{ __('ui.mapato') }}</span>
            <span class="font-bold text-blue-700 text-lg">{{ number_format($jumla_mapato) }} TZS</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.bidhaa') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden sm:table-cell">{{ __('ui.wateja') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.bei_iliyouzwa') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.faida') }}</th>
                    <th class="text-center px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.tarehe') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.hatua') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($mauzo as $uuzaji)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-700">{{ $uuzaji->bidhaa->jina ?? '-' }}</p>
                    </td>
                    <td class="px-5 py-3 text-gray-500 hidden sm:table-cell">{{ $uuzaji->mteja->jina ?? '-' }}</td>
                    <td class="px-5 py-3 text-right font-medium text-gray-800">{{ number_format($uuzaji->bei_iliyouzwa) }}</td>
                    <td class="px-5 py-3 text-right font-bold text-green-600">+{{ number_format($uuzaji->faida) }}</td>
                    <td class="px-5 py-3 text-center text-gray-400 hidden md:table-cell">{{ $uuzaji->tarehe_ya_uuzaji->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('mauzo.edit', $uuzaji) }}" class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-2.5 py-1 rounded text-xs transition">{{ __('ui.hariri') }}</a>
                            <form action="{{ route('mauzo.destroy', $uuzaji) }}" method="POST" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-2.5 py-1 rounded text-xs transition">{{ __('ui.futa') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400">{{ __('ui.hakuna_rekodi') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $mauzo->withQueryString()->links() }}</div>
</div>
@endsection
