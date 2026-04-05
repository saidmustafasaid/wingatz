@extends('layouts.app')

@section('title', __('ui.hariri_uuzaji'))
@section('page-title', __('ui.hariri_uuzaji'))

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('mauzo.update', $mauzo) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bidhaa') }} *</label>
                <select name="bidhaa_id" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @foreach($bidhaa as $b)
                    <option value="{{ $b->id }}" {{ old('bidhaa_id', $mauzo->bidhaa_id) == $b->id ? 'selected' : '' }}>
                        {{ $b->jina }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bei_iliyouzwa') }} (TZS) *</label>
                <input type="number" name="bei_iliyouzwa" value="{{ old('bei_iliyouzwa', $mauzo->bei_iliyouzwa) }}"
                       required min="0" step="0.01"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.wateja') }} *</label>
                <select name="mteja_id" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    @foreach($wateja as $mteja)
                    <option value="{{ $mteja->id }}" {{ old('mteja_id', $mauzo->mteja_id) == $mteja->id ? 'selected' : '' }}>{{ $mteja->jina }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.tarehe') }} *</label>
                <input type="date" name="tarehe_ya_uuzaji" value="{{ old('tarehe_ya_uuzaji', $mauzo->tarehe_ya_uuzaji->format('Y-m-d')) }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ old('maelezo', $mauzo->maelezo) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('mauzo.index') }}" class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
