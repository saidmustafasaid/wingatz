@extends('layouts.app')

@section('title', __('ui.ongeza_msambazaji'))
@section('page-title', __('ui.ongeza_msambazaji'))

@section('content')
<div class="py-4 max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST" action="{{ route('wasambazaji.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.jina') }} *</label>
                <input type="text" name="jina" value="{{ old('jina') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.simu') }}</label>
                    <input type="text" name="simu" value="{{ old('simu') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.whatsapp') }}</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bidhaa_wanazouza') }}</label>
                <input type="text" name="bidhaa_wanazouza" value="{{ old('bidhaa_wanazouza') }}"
                       placeholder="{{ app()->getLocale() === 'sw' ? 'mf. Nguo, Viatu, Vifaa vya nyumba' : 'e.g. Clothes, Shoes, Electronics' }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="3"
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">{{ old('maelezo') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('wasambazaji.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
