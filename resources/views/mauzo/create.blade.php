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
                            data-idadi="{{ $b->idadi }}"
                            data-kitengo="{{ $b->kitengo ?? 'kipande' }}"
                            {{ request('bidhaa_id') == $b->id || old('bidhaa_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->jina }} — {{ number_format($b->bei_yangu) }} TZS ({{ app()->getLocale() === 'sw' ? 'Stoku' : 'Stock' }}: {{ $b->idadi }} {{ $b->kitengo ?? '' }})
                    </option>
                    @endforeach
                </select>
                @if($bidhaa->isEmpty())
                    <p class="text-xs text-amber-600 mt-1">{{ app()->getLocale() === 'sw' ? 'Hakuna bidhaa zinazopatikana. ' : 'No products available. ' }}<a href="{{ route('bidhaa.create') }}" class="underline">{{ __('ui.ongeza_bidhaa') }}</a></p>
                @endif
            </div>

            <!-- Quantity + stock status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ app()->getLocale() === 'sw' ? 'Idadi ya Kuuza' : 'Quantity to Sell' }} *</label>
                <div class="flex items-center gap-3">
                    <input type="number" name="idadi" id="idadi" value="{{ old('idadi', 1) }}"
                           required min="1" step="1" oninput="update_faida()"
                           class="w-32 border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"/>
                    <span id="kitengo-label" class="text-sm text-gray-500"></span>
                </div>
                <div id="stock-info" class="hidden mt-1 text-xs"></div>
            </div>

            <!-- Price preview -->
            <div id="bei-preview" class="hidden bg-gray-50 rounded-lg px-4 py-3 text-sm space-y-1">
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ __('ui.bei_halisi') }} ({{ app()->getLocale() === 'sw' ? 'kwa moja' : 'per unit' }}):</span>
                    <span id="bei-halisi-preview" class="font-medium text-gray-700"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">{{ app()->getLocale() === 'sw' ? 'Faida inayotarajiwa (jumla)' : 'Expected profit (total)' }}:</span>
                    <span id="faida-preview-val" class="font-bold text-green-600"></span>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-1 mt-1">
                    <span class="text-gray-500">{{ app()->getLocale() === 'sw' ? 'Jumla ya malipo' : 'Total payment' }}:</span>
                    <span id="jumla-preview" class="font-bold text-indigo-700"></span>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('ui.bei_iliyouzwa') }} {{ app()->getLocale() === 'sw' ? '(kwa moja, TZS)' : '(per unit, TZS)' }} *</label>
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
let halisi = 0, stokuMax = 0;

function jaza_bei() {
    const sel  = document.getElementById('bidhaa_id');
    const opt  = sel.options[sel.selectedIndex];
    const bei  = opt.dataset.bei  || '';
    halisi     = parseFloat(opt.dataset.halisi)  || 0;
    stokuMax   = parseInt(opt.dataset.idadi)     || 0;
    const ktn  = opt.dataset.kitengo || '';

    document.getElementById('kitengo-label').textContent = ktn;

    const stockEl = document.getElementById('stock-info');
    if (bei) {
        document.getElementById('bei_iliyouzwa').value = bei;
        document.getElementById('bei-halisi-preview').textContent = parseInt(halisi).toLocaleString() + ' TZS';
        stockEl.textContent = '{{ app()->getLocale() === "sw" ? "Stoku iliyopo" : "Available stock" }}: ' + stokuMax + ' ' + ktn;
        stockEl.className   = stokuMax > 0 ? 'mt-1 text-xs text-green-600' : 'mt-1 text-xs text-red-600';
        stockEl.classList.remove('hidden');
        document.getElementById('bei-preview').classList.remove('hidden');
        update_faida();
    } else {
        document.getElementById('bei-preview').classList.add('hidden');
        stockEl.classList.add('hidden');
    }
}

function update_faida() {
    const bei   = parseFloat(document.getElementById('bei_iliyouzwa').value) || 0;
    const idadi = parseInt(document.getElementById('idadi').value)  || 1;

    // Stock warning
    const stockEl = document.getElementById('stock-info');
    if (stokuMax > 0 && idadi > stokuMax) {
        stockEl.textContent = '{{ app()->getLocale() === "sw" ? "Stoku haitoshi! Iliyopo" : "Not enough stock! Available" }}: ' + stokuMax;
        stockEl.className = 'mt-1 text-xs text-red-600 font-semibold';
        stockEl.classList.remove('hidden');
    } else if (stokuMax > 0) {
        stockEl.textContent = '{{ app()->getLocale() === "sw" ? "Stoku iliyopo" : "Available stock" }}: ' + stokuMax;
        stockEl.className = 'mt-1 text-xs text-green-600';
        stockEl.classList.remove('hidden');
    }

    if (bei > 0 && halisi > 0) {
        const faida_kwa_moja = bei - halisi;
        const faida_jumla    = faida_kwa_moja * idadi;
        const jumla_malipo   = bei * idadi;

        const el = document.getElementById('faida-actual');
        el.textContent = (faida_kwa_moja >= 0 ? '+' : '') + faida_kwa_moja.toLocaleString() + ' TZS {{ __("ui.faida") }} {{ app()->getLocale() === "sw" ? "kwa moja" : "per unit" }}';
        el.className = faida_kwa_moja >= 0 ? 'mt-1 text-xs font-medium text-green-600' : 'mt-1 text-xs font-medium text-red-600';
        el.classList.remove('hidden');

        document.getElementById('faida-preview-val').textContent = faida_jumla.toLocaleString() + ' TZS';
        document.getElementById('jumla-preview').textContent = jumla_malipo.toLocaleString() + ' TZS';
        document.getElementById('bei-preview').classList.remove('hidden');
    }
}

window.onload = () => {
    const sel = document.getElementById('bidhaa_id');
    if (sel.value) jaza_bei();
};
</script>
@endpush
