@extends('layouts.app')

@section('title', __('ui.ongeza_swali'))
@section('page-title', __('ui.ongeza_swali'))

@section('content')
<div class="py-4 max-w-lg">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('maswali.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.wateja') }} *</label>
                <select name="mteja_id" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="">-- {{ __('ui.chagua_mteja') }} --</option>
                    @foreach($wateja as $mteja)
                    <option value="{{ $mteja->id }}" {{ old('mteja_id') == $mteja->id ? 'selected' : '' }}>{{ $mteja->jina }}</option>
                    @endforeach
                </select>
                <a href="{{ route('wateja.create') }}" class="text-xs text-indigo-500 hover:underline mt-1 inline-block">+ {{ __('ui.ongeza_mteja') }}</a>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bidhaa') }} ({{ app()->getLocale() === 'sw' ? 'si lazima' : 'optional' }})</label>
                <select name="bidhaa_id"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="">-- {{ app()->getLocale() === 'sw' ? 'Swali la jumla' : 'General inquiry' }} --</option>
                    @foreach($bidhaa as $b)
                    <option value="{{ $b->id }}" {{ old('bidhaa_id') == $b->id ? 'selected' : '' }}>{{ $b->jina }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.ujumbe') }}</label>
                <textarea name="ujumbe" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ old('ujumbe') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.hali') }}</label>
                <select name="hali"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="inasubiri" {{ old('hali', 'inasubiri') === 'inasubiri' ? 'selected' : '' }}>{{ __('ui.inasubiri') }}</option>
                    <option value="imenunuliwa" {{ old('hali') === 'imenunuliwa' ? 'selected' : '' }}>{{ __('ui.imenunuliwa') }}</option>
                    <option value="imekimbia" {{ old('hali') === 'imekimbia' ? 'selected' : '' }}>{{ __('ui.imekimbia') }}</option>
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('maswali.index') }}" class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
