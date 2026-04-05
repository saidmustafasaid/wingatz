<?php

namespace App\Http\Controllers;

use App\Models\Bidhaa;
use App\Models\Mteja;
use App\Models\Uuzaji;
use App\Models\Swali;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Bidhaa counts in one query
        $bidhaa_stats = Bidhaa::selectRaw("
            COUNT(*) as jumla,
            SUM(CASE WHEN hali = 'inapatikana' THEN 1 ELSE 0 END) as zinapatikana,
            SUM(CASE WHEN hali = 'imeuzwa' THEN 1 ELSE 0 END) as zimeuzwa
        ")->first();

        $jumla_bidhaa       = $bidhaa_stats->jumla;
        $bidhaa_zinapatikana = $bidhaa_stats->zinapatikana;
        $bidhaa_zimeuzwa    = $bidhaa_stats->zimeuzwa;
        $jumla_wateja       = Mteja::count();

        $mwezi_huu = Carbon::now()->month;
        $mwaka_huu = Carbon::now()->year;

        // Monthly and total aggregates in two queries instead of four
        $mwezi_stats = Uuzaji::whereMonth('tarehe_ya_uuzaji', $mwezi_huu)
            ->whereYear('tarehe_ya_uuzaji', $mwaka_huu)
            ->selectRaw('COUNT(*) as idadi, SUM(faida) as faida')
            ->first();

        $faida_mwezi = $mwezi_stats->faida ?? 0;
        $mauzo_mwezi = $mwezi_stats->idadi ?? 0;

        $jumla_stats = Uuzaji::selectRaw('SUM(faida) as faida, SUM(bei_iliyouzwa) as mapato')->first();
        $faida_jumla  = $jumla_stats->faida ?? 0;
        $mapato_jumla = $jumla_stats->mapato ?? 0;

        $miezi_6 = Carbon::now()->subMonths(5)->startOfMonth();
        $faida_by_month = Uuzaji::where('tarehe_ya_uuzaji', '>=', $miezi_6)
            ->selectRaw("DATE_FORMAT(tarehe_ya_uuzaji, '%Y-%m') as ym, SUM(faida) as faida, SUM(bei_iliyouzwa) as mapato")
            ->groupByRaw("DATE_FORMAT(tarehe_ya_uuzaji, '%Y-%m')")
            ->get()
            ->keyBy('ym');

        $mauzo_chart = collect(range(5, 0))->map(function ($miezi) use ($faida_by_month) {
            $tarehe = Carbon::now()->subMonths($miezi);
            $key    = $tarehe->format('Y-m');
            $row    = $faida_by_month->get($key);
            return [
                'mwezi' => $tarehe->format('M Y'),
                'faida' => $row?->faida ?? 0,
                'mauzo' => $row?->mapato ?? 0,
            ];
        });

        $mauzo_hivi_karibuni = Uuzaji::with(['bidhaa', 'mteja'])->latest()->take(5)->get();

        $bidhaa_bora = Bidhaa::withCount('mauzo')
            ->withSum('mauzo', 'faida')
            ->orderByDesc('mauzo_sum_faida')
            ->take(5)
            ->get();

        $maswali_yanayosubiri = Swali::with(['mteja', 'bidhaa'])
            ->where('hali', 'inasubiri')
            ->latest()
            ->take(5)
            ->get();

        $wastani_siku = Uuzaji::whereNotNull('siku_za_kuuza')->avg('siku_za_kuuza');

        return view('dashboard', compact(
            'jumla_bidhaa', 'bidhaa_zinapatikana', 'bidhaa_zimeuzwa',
            'jumla_wateja', 'faida_mwezi', 'mauzo_mwezi', 'faida_jumla',
            'mapato_jumla', 'mauzo_chart', 'mauzo_hivi_karibuni',
            'bidhaa_bora', 'maswali_yanayosubiri', 'wastani_siku'
        ));
    }
}
