<?php

namespace App\Http\Controllers;

use App\Models\Uuzaji;
use App\Models\Bidhaa;
use App\Models\Mteja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MauzoController extends Controller
{
    private array $validationRules = [
        'bidhaa_id'        => 'required|exists:bidhaa,id',
        'mteja_id'         => 'required|exists:wateja,id',
        'idadi'            => 'required|integer|min:1',
        'bei_iliyouzwa'    => 'required|numeric|min:0',
        'tarehe_ya_uuzaji' => 'required|date',
        'maelezo'          => 'nullable|string',
    ];

    public function index(Request $request)
    {
        $baseQuery = Uuzaji::with(['bidhaa', 'mteja']);

        if ($request->filled('tafuta')) {
            $baseQuery->where(function ($q) use ($request) {
                $q->whereHas('bidhaa', fn($q) => $q->where('jina', 'like', '%' . $request->tafuta . '%'))
                  ->orWhereHas('mteja', fn($q) => $q->where('jina', 'like', '%' . $request->tafuta . '%'));
            });
        }

        if ($request->filled('tarehe_kuanzia')) {
            $baseQuery->where('tarehe_ya_uuzaji', '>=', $request->tarehe_kuanzia);
        }

        if ($request->filled('tarehe_hadi')) {
            $baseQuery->where('tarehe_ya_uuzaji', '<=', $request->tarehe_hadi);
        }

        $totals = (clone $baseQuery)->selectRaw('SUM(faida) as faida, SUM(bei_iliyouzwa) as mapato')->first();
        $jumla_faida  = $totals->faida  ?? 0;
        $jumla_mapato = $totals->mapato ?? 0;

        $mauzo = $baseQuery->latest('tarehe_ya_uuzaji')->paginate(15);

        return view('mauzo.index', compact('mauzo', 'jumla_faida', 'jumla_mapato'));
    }

    public function create()
    {
        $bidhaa = Bidhaa::where('hali', 'inapatikana')->where('idadi', '>', 0)->orderBy('jina')->get();
        $wateja = Mteja::orderBy('jina')->get();
        return view('mauzo.create', compact('bidhaa', 'wateja'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);
        $bidhaa    = Bidhaa::findOrFail($validated['bidhaa_id']);

        if ($bidhaa->idadi < $validated['idadi']) {
            return back()->withErrors(['idadi' => __('messages.stock_haitoshi')])->withInput();
        }

        Uuzaji::create($this->enrichData($validated, $bidhaa));

        $bidhaa->decrement('idadi', $validated['idadi']);
        if ($bidhaa->fresh()->idadi <= 0) {
            $bidhaa->update(['hali' => 'imeuzwa']);
        }

        return redirect()->route('mauzo.index')
            ->with('success', __('messages.uuzaji_umerekodiwa'));
    }

    public function show(Uuzaji $mauzo)
    {
        $mauzo->load(['bidhaa', 'mteja']);
        return view('mauzo.show', compact('mauzo'));
    }

    public function edit(Uuzaji $mauzo)
    {
        $bidhaa = Bidhaa::orderBy('jina')->get();
        $wateja = Mteja::orderBy('jina')->get();
        return view('mauzo.edit', compact('mauzo', 'bidhaa', 'wateja'));
    }

    public function update(Request $request, Uuzaji $mauzo)
    {
        $validated = $request->validate($this->validationRules);
        $bidhaa    = Bidhaa::findOrFail($validated['bidhaa_id']);

        // Restore old quantity then deduct new
        $bidhaa->increment('idadi', $mauzo->idadi);
        if ($bidhaa->fresh()->idadi < $validated['idadi']) {
            $bidhaa->decrement('idadi', $mauzo->idadi);
            return back()->withErrors(['idadi' => __('messages.stock_haitoshi')])->withInput();
        }
        $bidhaa->decrement('idadi', $validated['idadi']);

        $mauzo->update($this->enrichData($validated, $bidhaa));

        if ($bidhaa->fresh()->idadi <= 0) {
            $bidhaa->update(['hali' => 'imeuzwa']);
        } else {
            $bidhaa->update(['hali' => 'inapatikana']);
        }

        return redirect()->route('mauzo.show', $mauzo)
            ->with('success', __('messages.uuzaji_umesasishwa'));
    }

    public function destroy(Uuzaji $mauzo)
    {
        $bidhaa = $mauzo->bidhaa;
        if ($bidhaa) {
            $bidhaa->increment('idadi', $mauzo->idadi);
            $bidhaa->update(['hali' => 'inapatikana']);
        }
        $mauzo->delete();

        return redirect()->route('mauzo.index')
            ->with('success', __('messages.uuzaji_umefutwa'));
    }

    private function enrichData(array $validated, Bidhaa $bidhaa): array
    {
        $idadi                      = $validated['idadi'];
        $validated['bei_halisi']    = $bidhaa->bei_halisi;
        $validated['faida']         = ($validated['bei_iliyouzwa'] - $bidhaa->bei_halisi) * $idadi;
        $validated['bei_iliyouzwa'] = $validated['bei_iliyouzwa'] * $idadi;
        $validated['siku_za_kuuza'] = $bidhaa->created_at->diffInDays(Carbon::parse($validated['tarehe_ya_uuzaji']));
        return $validated;
    }
}
