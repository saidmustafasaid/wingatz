@extends('layouts.app')

@section('title', $wasambazaji->jina)
@section('page-title', $wasambazaji->jina)

@section('content')
<div class="py-4 space-y-6">

    <div class="flex gap-3">
        <a href="{{ route('wasambazaji.edit', $wasambazaji) }}" class="btn-primary text-white px-5 py-2 rounded-xl text-sm font-semibold">{{ __('ui.hariri') }}</a>
        @if($wasambazaji->whatsapp)
        <a href="https://wa.me/{{ preg_replace('/\D/', '', $wasambazaji->whatsapp) }}" target="_blank"
           class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            WhatsApp
        </a>
        @endif
        <a href="{{ route('wasambazaji.index') }}" class="bg-gray-100 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">{{ __('ui.rudi') }}</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">{{ __('ui.simu') }}</p>
            <p class="font-semibold text-gray-800">{{ $wasambazaji->simu ?? '-' }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">{{ __('ui.bidhaa_wanazouza') }}</p>
            <p class="font-semibold text-gray-800">{{ $wasambazaji->bidhaa_wanazouza ?? '-' }}</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-xs text-gray-500 mb-1">{{ __('ui.jumla_manunuzi') }}</p>
            <p class="font-semibold text-indigo-700 text-lg">{{ number_format($jumla_manunuzi) }} TZS</p>
        </div>
    </div>

    @if($wasambazaji->maelezo)
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-600">{{ $wasambazaji->maelezo }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-700">{{ __('ui.historia_manunuzi') }}</h3>
            <a href="{{ route('manunuzi.create') }}?msambazaji_id={{ $wasambazaji->id }}"
               class="btn-primary text-white text-xs px-3 py-1.5 rounded-lg">+ {{ __('ui.ongeza_ununuzi') }}</a>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.bidhaa') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.idadi') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.bei_ya_kununulia') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.jumla') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.tarehe') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($wasambazaji->manunuzi as $m)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium text-gray-800">{{ $m->bidhaa->jina ?? '-' }}</td>
                    <td class="px-5 py-3 text-right text-gray-600">{{ $m->idadi }}</td>
                    <td class="px-5 py-3 text-right text-gray-600">{{ number_format($m->bei_ya_kununulia) }}</td>
                    <td class="px-5 py-3 text-right font-semibold text-gray-800">{{ number_format($m->idadi * $m->bei_ya_kununulia) }}</td>
                    <td class="px-5 py-3 text-gray-500">{{ $m->tarehe->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-6 text-center text-gray-400">{{ __('ui.hakuna_rekodi') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
