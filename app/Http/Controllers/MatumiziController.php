<?php

namespace App\Http\Controllers;

use App\Models\Matumizi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MatumiziController extends Controller
{
    public function index(Request $request)
    {
        $query = Matumizi::latest('tarehe');

        if ($request->filled('tafuta')) {
            $query->where('kichwa', 'like', '%' . $request->tafuta . '%');
        }

        if ($request->filled('kategoria')) {
            $query->where('kategoria', $request->kategoria);
        }

        if ($request->filled('mwezi')) {
            [$mwaka, $mwezi] = explode('-', $request->mwezi);
            $query->whereYear('tarehe', $mwaka)->whereMonth('tarehe', $mwezi);
        }

        $matumizi         = $query->paginate(15);
        $kategoria_list   = Matumizi::whereNotNull('kategoria')->distinct()->pluck('kategoria');

        $mwezi_huu   = Carbon::now()->month;
        $mwaka_huu   = Carbon::now()->year;
        $jumla_mwezi = Matumizi::whereYear('tarehe', $mwaka_huu)->whereMonth('tarehe', $mwezi_huu)->sum('kiasi');
        $jumla_yote  = Matumizi::sum('kiasi');

        return view('matumizi.index', compact('matumizi', 'kategoria_list', 'jumla_mwezi', 'jumla_yote'));
    }

    public function create()
    {
        $kategoria_list = Matumizi::whereNotNull('kategoria')->distinct()->pluck('kategoria');

        return view('matumizi.create', compact('kategoria_list'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kichwa'    => 'required|string|max:255',
            'kiasi'     => 'required|numeric|min:0',
            'kategoria' => 'nullable|string|max:100',
            'tarehe'    => 'required|date',
            'maelezo'   => 'nullable|string',
        ]);

        Matumizi::create($validated);

        return redirect()->route('matumizi.index')
            ->with('success', __('messages.matumizi_yamerekodiwa'));
    }

    public function edit(Matumizi $matumizi)
    {
        $kategoria_list = Matumizi::whereNotNull('kategoria')->distinct()->pluck('kategoria');

        return view('matumizi.edit', compact('matumizi', 'kategoria_list'));
    }

    public function update(Request $request, Matumizi $matumizi)
    {
        $validated = $request->validate([
            'kichwa'    => 'required|string|max:255',
            'kiasi'     => 'required|numeric|min:0',
            'kategoria' => 'nullable|string|max:100',
            'tarehe'    => 'required|date',
            'maelezo'   => 'nullable|string',
        ]);

        $matumizi->update($validated);

        return redirect()->route('matumizi.index')
            ->with('success', __('messages.matumizi_yasasishwa'));
    }

    public function destroy(Matumizi $matumizi)
    {
        $matumizi->delete();

        return redirect()->route('matumizi.index')
            ->with('success', __('messages.matumizi_yamefutwa'));
    }
}
