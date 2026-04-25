@extends('layouts.app')

@section('title', __('ui.madeni'))
@section('page-title', __('ui.madeni'))

@section('content')
<div class="py-4 space-y-4">

    <!-- Summary cards -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">{{ app()->getLocale() === 'sw' ? 'Madeni Yanayodaiwa' : 'Outstanding Debts' }}</p>
            <p class="text-2xl font-bold text-red-600 mt-1">{{ number_format($jumla_deni) }} TZS</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">{{ app()->getLocale() === 'sw' ? 'Malipo Yaliyopokelewa' : 'Payments Received' }}</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($jumla_malipo) }} TZS</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <p class="text-sm text-gray-500">{{ app()->getLocale() === 'sw' ? 'Baki Inayodaiwa' : 'Balance Owed' }}</p>
            <p class="text-2xl font-bold {{ $baki > 0 ? 'text-orange-600' : 'text-green-600' }} mt-1">{{ number_format($baki) }} TZS</p>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <form method="GET" class="flex gap-2 flex-1 flex-wrap">
            <input type="text" name="tafuta" value="{{ request('tafuta') }}"
                   placeholder="{{ __('ui.tafuta') }}..."
                   class="flex-1 min-w-36 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <select name="hali" class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                <option value="">{{ __('ui.zote') }}</option>
                <option value="haijalipiwa" {{ request('hali') === 'haijalipiwa' ? 'selected' : '' }}>{{ __('ui.haijalipiwa') }}</option>
                <option value="imelipwa" {{ request('hali') === 'imelipwa' ? 'selected' : '' }}>{{ __('ui.imelipwa') }}</option>
            </select>
            <button type="submit" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-semibold">{{ __('ui.chuja') }}</button>
        </form>
        <a href="{{ route('madeni.create') }}" class="btn-primary text-white px-5 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ __('ui.ongeza_deni') }}
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.mteja') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.aina') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.kiasi') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">{{ __('ui.tarehe') }}</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600 hidden md:table-cell">{{ __('ui.hali') }}</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">{{ __('ui.hatua') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($madeni as $deni)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3">
                        <a href="{{ route('wateja.show', $deni->mteja) }}" class="font-semibold text-indigo-700 hover:underline">{{ $deni->mteja->jina ?? '-' }}</a>
                        @if($deni->maelezo)<p class="text-xs text-gray-400 truncate max-w-40">{{ $deni->maelezo }}</p>@endif
                    </td>
                    <td class="px-5 py-3 hidden md:table-cell">
                        <span class="text-xs px-2 py-1 rounded-full {{ $deni->aina === 'deni' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $deni->aina === 'deni' ? __('ui.deni') : __('ui.malipo') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right font-semibold {{ $deni->aina === 'deni' ? 'text-red-600' : 'text-green-600' }}">
                        {{ $deni->aina === 'deni' ? '-' : '+' }}{{ number_format($deni->kiasi) }} TZS
                    </td>
                    <td class="px-5 py-3 text-gray-500">
                        {{ $deni->tarehe->format('d M Y') }}
                        @if($deni->tarehe_ya_kulipa && $deni->hali === 'haijalipiwa')
                        <p class="text-xs text-orange-500">{{ app()->getLocale() === 'sw' ? 'Kulipa' : 'Due' }}: {{ $deni->tarehe_ya_kulipa->format('d M Y') }}</p>
                        @endif
                    </td>
                    <td class="px-5 py-3 hidden md:table-cell">
                        <span class="text-xs px-2 py-1 rounded-full {{ $deni->hali === 'haijalipiwa' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ $deni->hali === 'haijalipiwa' ? __('ui.haijalipiwa') : __('ui.imelipwa') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex justify-end gap-2">
                            @if($deni->hali === 'haijalipiwa' && $deni->aina === 'deni')
                            <form method="POST" action="{{ route('madeni.mark_paid', $deni) }}">
                                @csrf
                                <button class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-lg hover:bg-green-200 transition">
                                    {{ app()->getLocale() === 'sw' ? 'Limelipwa' : 'Mark Paid' }}
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('madeni.destroy', $deni) }}" onsubmit="return confirm('{{ __('ui.uthibitisho_futa') }}')">
                                @csrf @method('DELETE')
                                <button class="text-xs bg-red-100 text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-200 transition">{{ __('ui.futa') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">{{ __('ui.hakuna_rekodi') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $madeni->withQueryString()->links() }}</div>
</div>
@endsection
