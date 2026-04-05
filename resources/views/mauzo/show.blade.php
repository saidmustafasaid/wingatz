@extends('layouts.app')

@section('title', __('ui.mauzo'))
@section('page-title', __('ui.mauzo'))

@section('content')
<div class="py-4 max-w-lg">
    <a href="{{ route('mauzo.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← {{ __('ui.rudi') }}</a>

    <div class="mt-4 bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.bidhaa') }}</span>
            <span class="font-medium text-gray-800">{{ $mauzo->bidhaa->jina ?? '-' }}</span>
        </div>
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.wateja') }}</span>
            <span class="font-medium text-gray-800">{{ $mauzo->mteja->jina ?? '-' }}</span>
        </div>
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.bei_halisi') }}</span>
            <span class="font-medium text-gray-800">{{ number_format($mauzo->bei_halisi) }} TZS</span>
        </div>
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.bei_iliyouzwa') }}</span>
            <span class="font-bold text-blue-700">{{ number_format($mauzo->bei_iliyouzwa) }} TZS</span>
        </div>
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.faida') }}</span>
            <span class="font-bold text-green-600">+{{ number_format($mauzo->faida) }} TZS</span>
        </div>
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.tarehe') }}</span>
            <span class="font-medium text-gray-800">{{ $mauzo->tarehe_ya_uuzaji->format('d M Y') }}</span>
        </div>
        @if($mauzo->siku_za_kuuza !== null)
        <div class="flex justify-between text-sm border-b pb-3">
            <span class="text-gray-500">{{ __('ui.siku_za_kuuza') }}</span>
            <span class="font-medium text-gray-800">{{ $mauzo->siku_za_kuuza }} {{ app()->getLocale() === 'sw' ? 'siku' : 'days' }}</span>
        </div>
        @endif
        @if($mauzo->maelezo)
        <div class="text-sm">
            <p class="text-gray-500 mb-1">{{ __('ui.maelezo') }}</p>
            <p class="text-gray-700">{{ $mauzo->maelezo }}</p>
        </div>
        @endif

        <div class="flex gap-2 pt-2">
            <a href="{{ route('mauzo.edit', $mauzo) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg text-sm transition">{{ __('ui.hariri') }}</a>
            <form action="{{ route('mauzo.destroy', $mauzo) }}" method="POST" class="flex-1" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-lg text-sm transition">{{ __('ui.futa') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
