@extends('layouts.app')

@section('title', $bidhaa->jina)
@section('page-title', $bidhaa->jina)

@section('content')
<div class="py-4 space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('bidhaa.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← {{ __('ui.rudi') }}</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main info -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $bidhaa->jina }}</h2>
                        @if($bidhaa->kategoria)
                            <span class="text-sm text-indigo-500">{{ $bidhaa->kategoria }}</span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('bidhaa.edit', $bidhaa) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-sm transition">{{ __('ui.hariri') }}</a>
                        <form action="{{ route('bidhaa.destroy', $bidhaa) }}" method="POST" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-sm transition">{{ __('ui.futa') }}</button>
                        </form>
                    </div>
                </div>

                @if($bidhaa->picha)
                    <img src="{{ Storage::url($bidhaa->picha) }}" class="w-full max-h-64 object-contain rounded-lg bg-gray-50 mb-4 border"/>
                @endif

                @if($bidhaa->maelezo)
                    <p class="text-gray-600 text-sm">{{ $bidhaa->maelezo }}</p>
                @endif
            </div>

            <!-- Mauzo history -->
            @if($bidhaa->mauzo->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">{{ __('ui.mauzo') }} ({{ $bidhaa->mauzo->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($bidhaa->mauzo as $uuzaji)
                    <div class="flex items-center justify-between px-5 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $uuzaji->mteja->jina ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $uuzaji->tarehe_ya_uuzaji->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-green-600">{{ number_format($uuzaji->bei_iliyouzwa) }}</p>
                            <p class="text-xs text-gray-400">{{ app()->getLocale() === 'sw' ? 'Faida' : 'Profit' }}: {{ number_format($uuzaji->faida) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Side stats -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">{{ __('ui.hali') }}</span>
                    <span class="text-sm font-medium px-2 py-0.5 rounded-full
                        {{ $bidhaa->hali === 'inapatikana' ? 'bg-green-100 text-green-700' : ($bidhaa->hali === 'imeuzwa' ? 'bg-gray-100 text-gray-500' : 'bg-red-100 text-red-600') }}">
                        {{ __('ui.' . $bidhaa->hali) }}
                    </span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">{{ __('ui.bei_halisi') }}</span>
                    <span class="text-sm font-semibold text-gray-700">{{ number_format($bidhaa->bei_halisi) }} TZS</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">{{ __('ui.bei_yangu') }}</span>
                    <span class="text-sm font-semibold text-blue-700">{{ number_format($bidhaa->bei_yangu) }} TZS</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">{{ __('ui.faida') }}</span>
                    <span class="text-sm font-bold text-green-600">{{ number_format($bidhaa->faida) }} TZS</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-500">{{ __('ui.faida_asilimia') }}</span>
                    <span class="text-sm font-bold text-green-600">{{ $bidhaa->faida_asilimia }}%</span>
                </div>
            </div>

            @if($bidhaa->hali === 'inapatikana')
            <a href="{{ route('mauzo.create') }}?bidhaa_id={{ $bidhaa->id }}"
               class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-medium transition">
                {{ __('ui.rekodi_uuzaji') }}
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
