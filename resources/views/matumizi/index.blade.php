@extends('layouts.app')

@section('title', __('ui.matumizi'))
@section('page-title', __('ui.matumizi'))

@section('content')
<div class="py-4 space-y-4">

    <!-- Summary cards -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">{{ app()->getLocale() === 'sw' ? 'Matumizi ya Mwezi' : 'This Month Expenses' }}</p>
            <p class="text-2xl font-bold text-orange-600 mt-1">{{ number_format($jumla_mwezi) }} TZS</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">{{ app()->getLocale() === 'sw' ? 'Matumizi Yote' : 'All Time Expenses' }}</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($jumla_yote) }} TZS</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <form method="GET" class="flex gap-2 flex-1 flex-wrap">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}"
                   class="flex-1 min-w-36 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <select name="kategoria" class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                <option value="">{{ __('ui.zote') }}</option>
                @foreach($kategoria_list as $k)
                <option value="{{ $k }}" {{ request('kategoria') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <input type="month" name="mwezi" value="{{ request('mwezi') }}"
                   class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-semibold">{{ __('ui.chuja') }}</button>
        </form>
        <a href="{{ route('matumizi.create') }}" class="btn-primary text-white px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_matumizi') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.kichwa') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.kategoria') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.kiasi') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.tarehe') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.hatua') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($matumizi as $m)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <p class="font-medium text-gray-800">{{ $m->kichwa }}</p>
                        @if($m->maelezo)<p class="text-xs text-gray-400 truncate max-w-48">{{ $m->maelezo }}</p>@endif
                    </td>
                    <td class="px-5 py-3 hidden md:table-cell">
                        @if($m->kategoria)
                        <span class="bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full">{{ $m->kategoria }}</span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right font-semibold text-red-600">{{ number_format($m->kiasi) }} TZS</td>
                    <td class="px-5 py-3 text-gray-500">{{ $m->tarehe->format('d M Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('matumizi.edit', $m) }}" class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg hover:bg-indigo-200 transition">{{ __('ui.hariri') }}</a>
                            <form method="POST" action="{{ route('matumizi.destroy', $m) }}" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-200 transition">{{ __('ui.futa') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">{{ __('ui.hakuna_rekodi') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $matumizi->withQueryString()->links() }}</div>
</div>
@endsection
