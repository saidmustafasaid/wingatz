@extends('layouts.app')

@section('title', __('ui.ongeza_bidhaa'))
@section('page-title', __('ui.ongeza_bidhaa'))

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('bidhaa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.jina') }} *</label>
                <input type="text" name="jina" value="{{ old('jina') }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.kategoria') }}</label>
                <input type="text" name="kategoria" value="{{ old('kategoria') }}"
                       list="kategoria-list"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                <datalist id="kategoria-list">
                    @foreach($kategoria as $k)
                    <option value="{{ $k }}">
                    @endforeach
                </datalist>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bei_halisi') }} (TZS) *</label>
                    <input type="number" name="bei_halisi" value="{{ old('bei_halisi') }}" required min="0" step="0.01"
                           id="bei_halisi"
                           oninput="hitesabu()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bei_yangu') }} (TZS) *</label>
                    <input type="number" name="bei_yangu" value="{{ old('bei_yangu') }}" required min="0" step="0.01"
                           id="bei_yangu"
                           oninput="hitesabu()"
                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                </div>
            </div>

            <!-- Live profit preview -->
            <div id="faida-preview" class="hidden bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('ui.faida') }}:</span>
                    <span id="faida-thamani" class="font-bold text-green-700"></span>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-gray-600">{{ __('ui.faida_asilimia') }}:</span>
                    <span id="faida-asilimia" class="font-bold text-green-700"></span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.hali') }} *</label>
                <select name="hali" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="inapatikana" {{ old('hali', 'inapatikana') === 'inapatikana' ? 'selected' : '' }}>{{ __('ui.inapatikana') }}</option>
                    <option value="imeuzwa" {{ old('hali') === 'imeuzwa' ? 'selected' : '' }}>{{ __('ui.imeuzwa') }}</option>
                    <option value="imesimamishwa" {{ old('hali') === 'imesimamishwa' ? 'selected' : '' }}>{{ __('ui.imesimamishwa') }}</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ old('maelezo') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.picha') }}</label>
                <input type="file" name="picha" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('bidhaa.index') }}" class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitesabu() {
    const halisi = parseFloat(document.getElementById('bei_halisi').value) || 0;
    const yangu = parseFloat(document.getElementById('bei_yangu').value) || 0;
    const preview = document.getElementById('faida-preview');
    if (halisi > 0 && yangu > 0) {
        const faida = yangu - halisi;
        const asilimia = halisi > 0 ? ((faida / halisi) * 100).toFixed(1) : 0;
        document.getElementById('faida-thamani').textContent = faida.toLocaleString() + ' TZS';
        document.getElementById('faida-asilimia').textContent = asilimia + '%';
        preview.classList.remove('hidden');
        document.getElementById('faida-thamani').className = faida >= 0
            ? 'font-bold text-green-700' : 'font-bold text-red-600';
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endpush
