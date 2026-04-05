@extends('layouts.app')

@section('title', __('ui.rekodi_uuzaji'))
@section('page-title', __('ui.rekodi_uuzaji'))

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('mauzo.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bidhaa') }} *</label>
                <select name="bidhaa_id" id="bidhaa_id" required onchange="jaza_bei()"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="">-- {{ __('ui.chagua_bidhaa') }} --</option>
                    @foreach($bidhaa as $b)
                    <option value="{{ $b->id }}"
                            data-bei="{{ $b->bei_yangu }}"
                            data-halisi="{{ $b->bei_halisi }}"
                            {{ request('bidhaa_id') == $b->id || old('bidhaa_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->jina }} ({{ app()->getLocale() === 'sw' ? 'Bei' : 'Price' }}: {{ number_format($b->bei_yangu) }})
                    </option>
                    @endforeach
                </select>
                @if($bidhaa->isEmpty())
                    <p class="text-xs text-amber-600 mt-1">{{ app()->getLocale() === 'sw' ? 'Hakuna bidhaa zinazopatikana. ' : 'No products available. ' }}<a href="{{ route('bidhaa.create') }}" class="underline">{{ __('ui.ongeza_bidhaa') }}</a></p>
                @endif
            </div>

            <!-- Price preview -->
            <div id="bei-preview" class="hidden bg-gray-50 rounded-lg px-4 py-3 text-sm space-y-1">
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('ui.bei_halisi') }}:</span>
                    <span id="bei-halisi-preview" class="font-medium text-gray-700"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('ui.faida') }} ({{ app()->getLocale() === 'sw' ? 'inayotarajiwa' : 'expected' }}):</span>
                    <span id="faida-preview-val" class="font-bold text-green-600"></span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bei_iliyouzwa') }} (TZS) *</label>
                <input type="number" name="bei_iliyouzwa" id="bei_iliyouzwa" value="{{ old('bei_iliyouzwa') }}"
                       required min="0" step="0.01" oninput="update_faida()"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                <div id="faida-actual" class="hidden mt-1 text-xs font-medium"></div>
            </div>

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
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.tarehe') }} *</label>
                <input type="date" name="tarehe_ya_uuzaji" value="{{ old('tarehe_ya_uuzaji', date('Y-m-d')) }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.maelezo') }}</label>
                <textarea name="maelezo" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 resize-none">{{ old('maelezo') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.hifadhi') }}</button>
                <a href="{{ route('mauzo.index') }}" class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 py-2.5 rounded-lg text-sm font-medium transition">{{ __('ui.rudi') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let halisi = 0;

function jaza_bei() {
    const sel = document.getElementById('bidhaa_id');
    const opt = sel.options[sel.selectedIndex];
    const bei = opt.dataset.bei || '';
    halisi = parseFloat(opt.dataset.halisi) || 0;

    if (bei) {
        document.getElementById('bei_iliyouzwa').value = bei;
        document.getElementById('bei-halisi-preview').textContent = parseInt(halisi).toLocaleString() + ' TZS';
        document.getElementById('bei-preview').classList.remove('hidden');
        update_faida();
    } else {
        document.getElementById('bei-preview').classList.add('hidden');
    }
}

function update_faida() {
    const bei = parseFloat(document.getElementById('bei_iliyouzwa').value) || 0;
    if (bei > 0 && halisi > 0) {
        const faida = bei - halisi;
        const el = document.getElementById('faida-actual');
        el.textContent = (faida >= 0 ? '+' : '') + faida.toLocaleString() + ' TZS {{ __("ui.faida") }}';
        el.className = faida >= 0 ? 'mt-1 text-xs font-medium text-green-600' : 'mt-1 text-xs font-medium text-red-600';
        el.classList.remove('hidden');

        document.getElementById('faida-preview-val').textContent = (bei - halisi).toLocaleString() + ' TZS';
        document.getElementById('bei-preview').classList.remove('hidden');
    }
}

// Auto-select if bidhaa_id passed in URL
window.onload = () => {
    const sel = document.getElementById('bidhaa_id');
    if (sel.value) jaza_bei();
};
</script>
@endpush
