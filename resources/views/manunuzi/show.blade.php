@extends('layouts.app')

@section('title', app()->getLocale() === 'sw' ? 'Maelezo ya Ununuzi' : 'Purchase Details')
@section('page-title', app()->getLocale() === 'sw' ? 'Maelezo ya Ununuzi' : 'Purchase Details')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header bar -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-semibold text-gray-800">
                {{ $manunuzi->bidhaa->jina ?? '-' }}
            </h2>
            <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-semibold">
                {{ $manunuzi->tarehe->format('d M Y') }}
            </span>
        </div>

        <!-- Details grid -->
        <div class="px-6 py-5 space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-400 mb-1">{{ __('ui.idadi_bidhaa') }}</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ $manunuzi->idadi }}
                        <span class="text-sm font-normal text-gray-500">{{ $manunuzi->bidhaa->kitengo ?? '' }}</span>
                    </p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-xs text-gray-400 mb-1">{{ __('ui.bei_ya_kununulia') }}</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($manunuzi->bei_ya_kununulia) }} <span class="text-sm font-normal text-gray-500">TZS</span></p>
                </div>
            </div>

            <div class="bg-indigo-50 rounded-lg p-4 flex items-center justify-between">
                <p class="text-sm text-indigo-700 font-medium">{{ __('ui.jumla') }} ({{ app()->getLocale() === 'sw' ? 'Gharama Yote' : 'Total Cost' }})</p>
                <p class="text-xl font-bold text-indigo-700">{{ number_format($manunuzi->idadi * $manunuzi->bei_ya_kununulia) }} TZS</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-400 mb-1">{{ __('ui.msambazaji') }}</p>
                    @if($manunuzi->msambazaji)
                        <a href="{{ route('wasambazaji.show', $manunuzi->msambazaji) }}" class="text-sm font-medium text-indigo-600 hover:underline">
                            {{ $manunuzi->msambazaji->jina }}
                        </a>
                    @else
                        <p class="text-sm text-gray-500">—</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">{{ __('ui.tarehe') }}</p>
                    <p class="text-sm text-gray-700">{{ $manunuzi->tarehe->format('d M Y') }}</p>
                </div>
            </div>

            @if($manunuzi->maelezo)
            <div>
                <p class="text-xs text-gray-400 mb-1">{{ __('ui.maelezo') }}</p>
                <p class="text-sm text-gray-700">{{ $manunuzi->maelezo }}</p>
            </div>
            @endif

            <!-- Current product stock -->
            @if($manunuzi->bidhaa)
            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400">{{ app()->getLocale() === 'sw' ? 'Stoku ya sasa ya bidhaa' : 'Current product stock' }}</p>
                    <a href="{{ route('bidhaa.show', $manunuzi->bidhaa) }}" class="text-sm font-medium text-indigo-600 hover:underline">
                        {{ $manunuzi->bidhaa->jina }}
                    </a>
                </div>
                <span class="{{ $manunuzi->bidhaa->stock_ndogo ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} text-sm font-bold px-3 py-1 rounded-full">
                    {{ $manunuzi->bidhaa->idadi }} {{ $manunuzi->bidhaa->kitengo ?? '' }}
                </span>
            </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
            <a href="{{ route('manunuzi.index') }}"
               class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-100 py-2 rounded-lg text-sm font-medium transition">
                ← {{ __('ui.rudi') }}
            </a>
            <form action="{{ route('manunuzi.destroy', $manunuzi) }}" method="POST"
                  onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-medium transition border border-red-200">
                    {{ __('ui.futa') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
