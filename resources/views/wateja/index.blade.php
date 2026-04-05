@extends('layouts.app')

@section('title', __('ui.wateja'))
@section('page-title', __('ui.wateja'))

@section('content')
<div class="py-4 space-y-4">
    <div class="flex flex-wrap items-center gap-3 justify-between">
        <form method="GET" class="flex gap-2">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white"/>
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition">{{ __('ui.tafuta') }}</button>
        </form>
        <a href="{{ route('wateja.create') }}"
           class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_mteja') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.jina') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden sm:table-cell">{{ __('ui.simu') }}</th>
                    <th class="text-center px-5 py-3 font-semibold text-gray-600">{{ __('ui.manunuzi_jumla') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.matumizi_jumla') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.hatua') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($wateja as $mteja)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0">
                                {{ strtoupper(substr($mteja->jina, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-700">{{ $mteja->jina }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-500 hidden sm:table-cell">{{ $mteja->simu ?? $mteja->whatsapp ?? '-' }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-0.5 rounded-full font-medium">{{ $mteja->mauzo_count }}</span>
                    </td>
                    <td class="px-5 py-3 text-right text-gray-700 font-medium hidden md:table-cell">{{ number_format($mteja->mauzo_sum_bei_iliyouzwa ?? 0) }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('wateja.show', $mteja) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-2.5 py-1 rounded text-xs transition">{{ __('ui.tazama') }}</a>
                            <a href="{{ route('wateja.edit', $mteja) }}" class="bg-gray-50 hover:bg-gray-100 text-gray-700 px-2.5 py-1 rounded text-xs transition">{{ __('ui.hariri') }}</a>
                            <form action="{{ route('wateja.destroy', $mteja) }}" method="POST" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-2.5 py-1 rounded text-xs transition">{{ __('ui.futa') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-400">{{ __('ui.hakuna_rekodi') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $wateja->withQueryString()->links() }}</div>
</div>
@endsection
