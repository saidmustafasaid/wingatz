@extends('layouts.app')

@section('title', __('ui.bidhaa'))
@section('page-title', __('ui.bidhaa'))

@section('content')
<div class="py-4 space-y-4">

    <!-- Header actions -->
    <div class="flex flex-wrap items-center gap-3 justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}"
                   class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white w-44"/>
            <select name="hali" class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">{{ __('ui.hali') }}: {{ __('ui.zote') }}</option>
                <option value="inapatikana" {{ request('hali') === 'inapatikana' ? 'selected' : '' }}>{{ __('ui.inapatikana') }}</option>
                <option value="imeuzwa" {{ request('hali') === 'imeuzwa' ? 'selected' : '' }}>{{ __('ui.imeuzwa') }}</option>
                <option value="imesimamishwa" {{ request('hali') === 'imesimamishwa' ? 'selected' : '' }}>{{ __('ui.imesimamishwa') }}</option>
            </select>
            @if($kategoria->count())
            <select name="kategoria" class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <option value="">{{ __('ui.kategoria') }}: {{ __('ui.zote') }}</option>
                @foreach($kategoria as $k)
                <option value="{{ $k }}" {{ request('kategoria') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition">{{ __('ui.chuja') }}</button>
        </form>
        <a href="{{ route('bidhaa.create') }}"
           class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_bidhaa') }}
        </a>
    </div>

    <!-- Products grid -->
    @if($bidhaa->isEmpty())
        <div class="text-center py-16 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p>{{ __('ui.hakuna_rekodi') }}</p>
        </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($bidhaa as $b)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
            <!-- Image -->
            <div class="h-40 bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center overflow-hidden">
                @if($b->picha)
                    <img src="{{ Storage::url($b->picha) }}" alt="{{ $b->jina }}" class="w-full h-full object-cover"/>
                @else
                    <svg class="w-16 h-16 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                @endif
            </div>

            <div class="p-4">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="font-semibold text-gray-800 leading-tight">{{ $b->jina }}</h3>
                    <span class="shrink-0 text-xs px-2 py-0.5 rounded-full font-medium
                        {{ $b->hali === 'inapatikana' ? 'bg-green-100 text-green-700' : ($b->hali === 'imeuzwa' ? 'bg-gray-100 text-gray-500' : 'bg-red-100 text-red-600') }}">
                        {{ __('ui.' . $b->hali) }}
                    </span>
                </div>

                @if($b->kategoria)
                    <p class="text-xs text-indigo-500 mb-2">{{ $b->kategoria }}</p>
                @endif

                <div class="grid grid-cols-3 gap-1 text-center text-xs mb-3">
                    <div class="bg-gray-50 rounded p-1.5">
                        <p class="text-gray-400">{{ __('ui.bei_halisi') }}</p>
                        <p class="font-semibold text-gray-700">{{ number_format($b->bei_halisi) }}</p>
                    </div>
                    <div class="bg-blue-50 rounded p-1.5">
                        <p class="text-blue-400">{{ __('ui.bei_yangu') }}</p>
                        <p class="font-semibold text-blue-700">{{ number_format($b->bei_yangu) }}</p>
                    </div>
                    <div class="bg-green-50 rounded p-1.5">
                        <p class="text-green-400">{{ __('ui.faida') }}</p>
                        <p class="font-semibold text-green-700">{{ number_format($b->faida) }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('bidhaa.show', $b) }}" class="flex-1 text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 py-1.5 rounded text-xs font-medium transition">{{ __('ui.tazama') }}</a>
                    <a href="{{ route('bidhaa.edit', $b) }}" class="flex-1 text-center bg-gray-50 hover:bg-gray-100 text-gray-700 py-1.5 rounded text-xs font-medium transition">{{ __('ui.hariri') }}</a>
                    <form action="{{ route('bidhaa.destroy', $b) }}" method="POST" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 py-1.5 px-2 rounded text-xs font-medium transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $bidhaa->withQueryString()->links() }}
    </div>
    @endif

</div>
@endsection
