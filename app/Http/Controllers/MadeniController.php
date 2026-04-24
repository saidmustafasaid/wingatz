<?php

namespace App\Http\Controllers;

use App\Models\Deni;
use App\Models\Mteja;
use Illuminate\Http\Request;

class MadeniController extends Controller
{
    public function index(Request $request)
    {
        $query = Deni::with('mteja')->latest('tarehe');

        if ($request->filled('hali')) {
            $query->where('hali', $request->hali);
        }

        if ($request->filled('tafuta')) {
            $query->whereHas('mteja', fn($q) => $q->where('jina', 'like', '%' . $request->tafuta . '%'));
        }

        $madeni         = $query->paginate(15);
        $jumla_deni     = Deni::where('aina', 'deni')->where('hali', 'haijalipiwa')->sum('kiasi');
        $jumla_malipo   = Deni::where('aina', 'malipo')->sum('kiasi');
        $baki           = max(0, $jumla_deni - $jumla_malipo);

        return view('madeni.index', compact('madeni', 'jumla_deni', 'jumla_malipo', 'baki'));
    }

    public function create()
    {
        $wateja = Mteja::orderBy('jina')->get();

        return view('madeni.create', compact('wateja'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mteja_id'         => 'required|exists:wateja,id',
            'kiasi'            => 'required|numeric|min:1',
            'aina'             => 'required|in:deni,malipo',
            'tarehe'           => 'required|date',
            'tarehe_ya_kulipa' => 'nullable|date|after_or_equal:tarehe',
            'maelezo'          => 'nullable|string',
        ]);

        Deni::create($validated);

        return redirect()->route('madeni.index')
            ->with('success', __('messages.deni_limerekodiwa'));
    }

    public function markPaid(Deni $deni)
    {
        $deni->update(['hali' => 'imelipwa']);

        return back()->with('success', __('messages.deni_limelipwa'));
    }

    public function destroy(Deni $deni)
    {
        $deni->delete();

        return redirect()->route('madeni.index')
            ->with('success', __('messages.deni_limefutwa'));
    }
}
