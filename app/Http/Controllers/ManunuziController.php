<?php

namespace App\Http\Controllers;

use App\Models\Bidhaa;
use App\Models\Msambazaji;
use App\Models\Ununuzi;
use Illuminate\Http\Request;

class ManunuziController extends Controller
{
    public function index(Request $request)
    {
        $query = Ununuzi::with(['bidhaa', 'msambazaji'])->latest('tarehe');

        if ($request->filled('tafuta')) {
            $query->whereHas('bidhaa', fn($q) => $q->where('jina', 'like', '%' . $request->tafuta . '%'));
        }

        if ($request->filled('tarehe_from')) {
            $query->where('tarehe', '>=', $request->tarehe_from);
        }
        if ($request->filled('tarehe_to')) {
            $query->where('tarehe', '<=', $request->tarehe_to);
        }

        $manunuzi = $query->paginate(15);
        $jumla_gharama = Ununuzi::selectRaw('SUM(idadi * bei_ya_kununulia) as jumla')->value('jumla') ?? 0;

        return view('manunuzi.index', compact('manunuzi', 'jumla_gharama'));
    }

    public function create()
    {
        $bidhaa      = Bidhaa::orderBy('jina')->get();
        $wasambazaji = Msambazaji::orderBy('jina')->get();

        return view('manunuzi.create', compact('bidhaa', 'wasambazaji'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bidhaa_id'       => 'required|exists:bidhaa,id',
            'msambazaji_id'   => 'nullable|exists:wasambazaji,id',
            'idadi'           => 'required|integer|min:1',
            'bei_ya_kununulia'=> 'required|numeric|min:0',
            'tarehe'          => 'required|date',
            'maelezo'         => 'nullable|string',
        ]);

        Ununuzi::create($validated);

        // Increase product stock
        $bidhaa = Bidhaa::findOrFail($validated['bidhaa_id']);
        $bidhaa->increment('idadi', $validated['idadi']);

        // Update cost price to latest purchase price
        $bidhaa->update(['bei_halisi' => $validated['bei_ya_kununulia']]);

        if ($bidhaa->hali === 'imesimamishwa') {
            $bidhaa->update(['hali' => 'inapatikana']);
        }

        return redirect()->route('manunuzi.index')
            ->with('success', __('messages.ununuzi_umerekodiwa'));
    }

    public function show(Ununuzi $manunuzi)
    {
        $manunuzi->load(['bidhaa', 'msambazaji']);

        return view('manunuzi.show', compact('manunuzi'));
    }

    public function destroy(Ununuzi $manunuzi)
    {
        // Reverse the stock increment
        $bidhaa = $manunuzi->bidhaa;
        if ($bidhaa) {
            $bidhaa->decrement('idadi', $manunuzi->idadi);
        }

        $manunuzi->delete();

        return redirect()->route('manunuzi.index')
            ->with('success', __('messages.ununuzi_umefutwa'));
    }
}
