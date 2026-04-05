@extends('layouts.app')

@section('title', $wateja->jina)
@section('page-title', $wateja->jina)

@section('content')
<div class="py-4 space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('wateja.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">← {{ __('ui.rudi') }}</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info card -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold text-xl">
                        {{ strtoupper(substr($wateja->jina, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800 text-lg">{{ $wateja->jina }}</h2>
                        <p class="text-xs text-gray-400">{{ app()->getLocale() === 'sw' ? 'Mteja tangu' : 'Customer since' }} {{ $wateja->created_at->format('M Y') }}</p>
                    </div>
                </div>

                @if($wateja->simu)
                <div class="flex items-center gap-2 py-2 border-t border-gray-50 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $wateja->simu }}
                </div>
                @endif
                @if($wateja->whatsapp)
                <div class="flex items-center gap-2 py-2 border-t border-gray-50 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    {{ $wateja->whatsapp }}
                </div>
                @endif
                @if($wateja->maelezo)
                <p class="text-sm text-gray-500 mt-3 pt-3 border-t border-gray-50">{{ $wateja->maelezo }}</p>
                @endif

                <div class="flex gap-2 mt-4">
                    <a href="{{ route('wateja.edit', $wateja) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg text-sm transition">{{ __('ui.hariri') }}</a>
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">{{ __('ui.manunuzi_jumla') }}</span>
                    <span class="font-bold text-indigo-700">{{ $wateja->mauzo->count() }}</span>
                </div>
                <div class="flex justify-between text-sm border-t border-gray-50 pt-3">
                    <span class="text-gray-500">{{ __('ui.matumizi_jumla') }}</span>
                    <span class="font-bold text-gray-800">{{ number_format($wateja->mauzo->sum('bei_iliyouzwa')) }} TZS</span>
                </div>
                <div class="flex justify-between text-sm border-t border-gray-50 pt-3">
                    <span class="text-gray-500">{{ __('ui.maswali') }}</span>
                    <span class="font-bold text-gray-800">{{ $wateja->maswali->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Purchase history -->
        <div class="lg:col-span-2 space-y-4">
            @if($wateja->mauzo->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">{{ __('ui.mauzo') }}</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($wateja->mauzo->sortByDesc('tarehe_ya_uuzaji') as $uuzaji)
                    <div class="flex items-center justify-between px-5 py-3">
                        <div>
                            <p class="text-sm font-medium text-gray-700">{{ $uuzaji->bidhaa->jina ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $uuzaji->tarehe_ya_uuzaji->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">{{ number_format($uuzaji->bei_iliyouzwa) }} TZS</p>
                            <p class="text-xs text-green-600">+{{ number_format($uuzaji->faida) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($wateja->maswali->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-700">{{ __('ui.maswali') }}</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($wateja->maswali as $swali)
                    <div class="flex items-center justify-between px-5 py-3">
                        <div>
                            <p class="text-sm text-gray-700">{{ $swali->bidhaa->jina ?? (app()->getLocale() === 'sw' ? 'Swali la jumla' : 'General inquiry') }}</p>
                            @if($swali->ujumbe)
                            <p class="text-xs text-gray-400">{{ $swali->ujumbe }}</p>
                            @endif
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $swali->hali === 'inasubiri' ? 'bg-yellow-100 text-yellow-700' : ($swali->hali === 'imenunuliwa' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500') }}">
                            {{ __('ui.' . $swali->hali) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
