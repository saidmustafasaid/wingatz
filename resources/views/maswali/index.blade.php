@extends('layouts.app')

@section('title', __('ui.maswali'))
@section('page-title', __('ui.maswali'))

@section('content')
<div class="py-4 space-y-4">
    <div class="flex flex-wrap items-center gap-3 justify-between">
        <form method="GET" class="flex gap-2">
            <select name="hali" class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">{{ __('ui.hali') }}: {{ __('ui.zote') }}</option>
                <option value="inasubiri" {{ request('hali') === 'inasubiri' ? 'selected' : '' }}>{{ __('ui.inasubiri') }}</option>
                <option value="imenunuliwa" {{ request('hali') === 'imenunuliwa' ? 'selected' : '' }}>{{ __('ui.imenunuliwa') }}</option>
                <option value="imekimbia" {{ request('hali') === 'imekimbia' ? 'selected' : '' }}>{{ __('ui.imekimbia') }}</option>
            </select>
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition">{{ __('ui.chuja') }}</button>
        </form>
        <a href="{{ route('maswali.create') }}"
           class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_swali') }}
        </a>
    </div>

    <div class="space-y-3">
        @forelse($maswali as $swali)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-start justify-between gap-4">
            <div class="flex items-start gap-3 min-w-0">
                <div class="w-9 h-9 bg-purple-100 rounded-full flex items-center justify-center text-purple-700 font-bold text-sm shrink-0">
                    {{ strtoupper(substr($swali->mteja->jina ?? '?', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="font-medium text-gray-800">{{ $swali->mteja->jina ?? '-' }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $swali->bidhaa->jina ?? (app()->getLocale() === 'sw' ? 'Swali la jumla' : 'General inquiry') }}
                    </p>
                    @if($swali->ujumbe)
                    <p class="text-xs text-gray-400 mt-1 truncate">{{ $swali->ujumbe }}</p>
                    @endif
                    <p class="text-xs text-gray-300 mt-1">{{ $swali->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <!-- Status badge + change -->
                <form action="{{ route('maswali.update', $swali) }}" method="POST" class="flex gap-1">
                    @csrf @method('PUT')
                    <select name="hali" onchange="this.form.submit()"
                            class="text-xs border rounded px-1.5 py-1 bg-white focus:outline-none
                            {{ $swali->hali === 'inasubiri' ? 'border-yellow-200 text-yellow-700' : ($swali->hali === 'imenunuliwa' ? 'border-green-200 text-green-700' : 'border-gray-200 text-gray-500') }}">
                        <option value="inasubiri" {{ $swali->hali === 'inasubiri' ? 'selected' : '' }}>{{ __('ui.inasubiri') }}</option>
                        <option value="imenunuliwa" {{ $swali->hali === 'imenunuliwa' ? 'selected' : '' }}>{{ __('ui.imenunuliwa') }}</option>
                        <option value="imekimbia" {{ $swali->hali === 'imekimbia' ? 'selected' : '' }}>{{ __('ui.imekimbia') }}</option>
                    </select>
                </form>

                <form action="{{ route('maswali.destroy', $swali) }}" method="POST" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-gray-300 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-16 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <p>{{ __('ui.hakuna_rekodi') }}</p>
        </div>
        @endforelse
    </div>

    <div>{{ $maswali->withQueryString()->links() }}</div>
</div>
@endsection
