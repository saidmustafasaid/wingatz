<?php

namespace App\Http\Controllers;

use App\Models\Bidhaa;
use App\Models\Uuzaji;
use App\Models\Mteja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RipotiController extends Controller
{
    public function index(Request $request)
    {
        $mwaka = $request->get('mwaka', Carbon::now()->year);

        // Single GROUP BY query for all 12 months instead of 12 separate queries
        $mwezi_data = Uuzaji::whereYear('tarehe_ya_uuzaji', $mwaka)
            ->selectRaw('MONTH(tarehe_ya_uuzaji) as namba, COUNT(*) as idadi, SUM(faida) as faida, SUM(bei_iliyouzwa) as mapato')
            ->groupByRaw('MONTH(tarehe_ya_uuzaji)')
            ->get()
            ->keyBy('namba');

        $mauzo_kwa_mwezi = collect(range(1, 12))->map(function ($m) use ($mwaka, $mwezi_data) {
            $row = $mwezi_data->get($m);
            return [
                'mwezi'  => Carbon::create($mwaka, $m, 1)->format('M'),
                'idadi'  => $row?->idadi ?? 0,
                'faida'  => $row?->faida ?? 0,
                'mapato' => $row?->mapato ?? 0,
            ];
        });

        $bidhaa_bora = Bidhaa::withSum('mauzo', 'faida')
            ->withCount('mauzo')
            ->having('mauzo_sum_faida', '>', 0)
            ->orderByDesc('mauzo_sum_faida')
            ->take(10)
            ->get();

        $wateja_bora = Mteja::withCount('mauzo')
            ->withSum('mauzo', 'bei_iliyouzwa')
            ->orderByDesc('mauzo_count')
            ->take(10)
            ->get();

        $wastani_siku_kategoria = Bidhaa::join('mauzo', 'bidhaa.id', '=', 'mauzo.bidhaa_id')
            ->whereNotNull('bidhaa.kategoria')
            ->whereNotNull('mauzo.siku_za_kuuza')
            ->selectRaw('bidhaa.kategoria, AVG(mauzo.siku_za_kuuza) as wastani_siku, COUNT(*) as idadi')
            ->groupBy('bidhaa.kategoria')
            ->get();

        // Four year-totals in one query
        $mwaka_stats = Uuzaji::whereYear('tarehe_ya_uuzaji', $mwaka)
            ->selectRaw('COUNT(*) as idadi, SUM(faida) as faida, SUM(bei_iliyouzwa) as mapato, SUM(bei_halisi) as gharama')
            ->first();

        $faida_jumla_mwaka   = $mwaka_stats->faida    ?? 0;
        $mapato_jumla_mwaka  = $mwaka_stats->mapato   ?? 0;
        $gharama_jumla_mwaka = $mwaka_stats->gharama  ?? 0;
        $idadi_mauzo_mwaka   = $mwaka_stats->idadi    ?? 0;

        $miaka = Uuzaji::selectRaw('YEAR(tarehe_ya_uuzaji) as mwaka')
            ->distinct()
            ->orderBy('mwaka', 'desc')
            ->pluck('mwaka');

        return view('ripoti.index', compact(
            'mauzo_kwa_mwezi', 'bidhaa_bora', 'wateja_bora',
            'wastani_siku_kategoria', 'faida_jumla_mwaka', 'mapato_jumla_mwaka',
            'gharama_jumla_mwaka', 'idadi_mauzo_mwaka', 'mwaka', 'miaka'
        ));
    }
}
