@extends('layouts.app')

@section('title', __('ui.ongeza_deni'))
@section('page-title', __('ui.ongeza_deni'))

@section('content')
<div class="py-4 max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('madeni.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.mteja') }} *</label>
                <select name="mteja_id" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <option value="">— {{ __('ui.chagua_mteja') }} —</option>
                    @foreach($wateja as $m)
                    <option value="{{ $m->id }}" {{ old('mteja_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->jina }} @if($m->simu)({{ $m->simu }})@endif
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('ui.aina') }} *</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="aina" value="deni" {{ old('aina', 'deni') === 'deni' ? 'checked' : '' }} class="text-purple-600">
                        <span class="text-sm font-medium text-red-700">{{ __('ui.deni') }} ({{ app()->getLocale() === 'sw' ? 'Anakudai' : 'Owes you' }})</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="aina" value="malipo" {{ old('aina') === 'malipo' ? 'checked' : '' }} class="text-purple-600">
                        <span class="text-sm font-medium text-green-700">{{ __('ui.malipo') }} ({{ app()->getLocale() === 'sw' ? 'Amelipa' : 'Payment received' }})</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.kiasi') }} (TZS) *</label>
                    <input type="number" name="kiasi" value="{{ old('kiasi') }}" min="1" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.tarehe') }} *</label>
                    <input type="date" name="tarehe" value="{{ old('tarehe', date('Y-m-d')) }}" required
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ app()->getLocale() === 'sw' ? 'Tarehe ya Kulipa (hiari)' : 'Due Date (optional)' }}
                </label>
                <input type="date" name="tarehe_ya_kulipa" value="{{ old('tarehe_ya_kulipa') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="2"
                          placeholder="{{ app()->getLocale() === 'sw' ? 'mf. Deni la bidhaa za nguo, tarehe ya mwezi...' : 'e.g. Debt for clothing goods, monthly credit...' }}"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">{{ old('maelezo') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('madeni.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
