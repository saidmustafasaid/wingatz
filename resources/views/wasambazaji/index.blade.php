@extends('layouts.app')

@section('title', __('ui.wasambazaji'))
@section('page-title', __('ui.wasambazaji'))

@section('content')
<div class="py-4 space-y-4">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <form method="GET" class="flex gap-2 flex-1 max-w-md">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-semibold">{{ __('ui.tafuta') }}</button>
        </form>
        <a href="{{ route('wasambazaji.create') }}" class="btn-primary text-white px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_msambazaji') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.jina') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.simu') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.bidhaa_wanazouza') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.jumla_manunuzi') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.hatua') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($wasambazaji as $s)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <a href="{{ route('wasambazaji.show', $s) }}" class="font-semibold text-indigo-700 hover:underline">{{ $s->jina }}</a>
                        @if($s->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $s->whatsapp) }}" target="_blank"
                           class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">WhatsApp</a>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-500 hidden md:table-cell">{{ $s->simu ?? '-' }}</td>
                    <td class="px-5 py-3 text-gray-500 hidden md:table-cell">{{ $s->bidhaa_wanazouza ?? '-' }}</td>
                    <td class="px-5 py-3 text-right font-semibold text-gray-700">
                        {{ number_format($s->manunuzi_sum_jumla ?? 0) }} TZS
                        <span class="text-xs text-gray-400 block">{{ $s->manunuzi_count ?? 0 }} {{ app()->getLocale() === 'sw' ? 'manunuzi' : 'orders' }}</span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('wasambazaji.edit', $s) }}" class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg hover:bg-indigo-200 transition">{{ __('ui.hariri') }}</a>
                            <form method="POST" action="{{ route('wasambazaji.destroy', $s) }}" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
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

    <div>{{ $wasambazaji->withQueryString()->links() }}</div>
</div>
@endsection
