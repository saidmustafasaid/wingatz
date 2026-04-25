@extends('layouts.app')

@section('title', __('ui.ongeza_ununuzi'))
@section('page-title', __('ui.ongeza_ununuzi'))

@section('content')
<div class="py-4 max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('manunuzi.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bidhaa') }} *</label>
                <select name="bidhaa_id" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option value="">— {{ __('ui.chagua_bidhaa') }} —</option>
                    @foreach($bidhaa as $b)
                    <option value="{{ $b->id }}" {{ old('bidhaa_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->jina }} ({{ app()->getLocale() === 'sw' ? 'Stock' : 'Stock' }}: {{ $b->idadi }} {{ $b->kitengo }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.msambazaji') }}</label>
                <select name="msambazaji_id"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option value="">— {{ app()->getLocale() === 'sw' ? 'Hakuna msambazaji' : 'No supplier' }} —</option>
                    @foreach($wasambazaji as $s)
                    <option value="{{ $s->id }}" {{ old('msambazaji_id', request('msambazaji_id')) == $s->id ? 'selected' : '' }}>
                        {{ $s->jina }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.idadi') }} *</label>
                    <input type="number" name="idadi" value="{{ old('idadi', 1) }}" min="1" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bei_ya_kununulia') }} *</label>
                    <input type="number" name="bei_ya_kununulia" value="{{ old('bei_ya_kununulia') }}" min="0" step="0.01" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.tarehe') }} *</label>
                <input type="date" name="tarehe" value="{{ old('tarehe', date('Y-m-d')) }}" required
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="2"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">{{ old('maelezo') }}</textarea>
            </div>

            <p class="text-xs text-indigo-600 bg-indigo-50 rounded-lg px-3 py-2">
                {{ app()->getLocale() === 'sw'
                    ? 'Baada ya kuhifadhi, idadi ya bidhaa itaongezeka na bei halisi itasasishwa.'
                    : 'After saving, product stock will increase and cost price will be updated.' }}
            </p>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('manunuzi.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
