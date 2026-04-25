@extends('layouts.app')

@section('title', __('ui.ongeza_matumizi'))
@section('page-title', __('ui.ongeza_matumizi'))

@section('content')
<div class="py-4 max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('matumizi.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.kichwa') }} *</label>
                <input type="text" name="kichwa" value="{{ old('kichwa') }}"
                       placeholder="{{ app()->getLocale() === 'sw' ? 'mf. Kodi ya duka, Usafiri, Umeme' : 'e.g. Shop rent, Transport, Electricity' }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.kiasi') }} (TZS) *</label>
                    <input type="number" name="kiasi" value="{{ old('kiasi') }}" min="0" step="0.01" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.tarehe') }} *</label>
                    <input type="date" name="tarehe" value="{{ old('tarehe', date('Y-m-d')) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.kategoria') }}</label>
                <input type="text" name="kategoria" value="{{ old('kategoria') }}"
                       list="kategoria-list"
                       placeholder="{{ app()->getLocale() === 'sw' ? 'mf. Kodi, Usafiri, Mishahara, Umeme' : 'e.g. Rent, Transport, Salaries, Utilities' }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                <datalist id="kategoria-list">
                    @foreach($kategoria_list as $k)
                    <option value="{{ $k }}">
                    @endforeach
                    <option value="{{ app()->getLocale() === 'sw' ? 'Kodi' : 'Rent' }}">
                    <option value="{{ app()->getLocale() === 'sw' ? 'Usafiri' : 'Transport' }}">
                    <option value="{{ app()->getLocale() === 'sw' ? 'Mishahara' : 'Salaries' }}">
                    <option value="{{ app()->getLocale() === 'sw' ? 'Umeme/Maji' : 'Utilities' }}">
                    <option value="{{ app()->getLocale() === 'sw' ? 'Vifaa' : 'Supplies' }}">
                </datalist>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="2"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">{{ old('maelezo') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('matumizi.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
