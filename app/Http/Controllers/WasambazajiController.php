<?php

namespace App\Http\Controllers;

use App\Models\Msambazaji;
use Illuminate\Http\Request;

class WasambazajiController extends Controller
{
    public function index(Request $request)
    {
        $query = Msambazaji::withCount('manunuzi')->withSum('manunuzi', 'jumla');

        if ($request->filled('tafuta')) {
            $query->where('jina', 'like', '%' . $request->tafuta . '%')
                  ->orWhere('simu', 'like', '%' . $request->tafuta . '%');
        }

        $wasambazaji = $query->latest()->paginate(15);

        return view('wasambazaji.index', compact('wasambazaji'));
    }

    public function create()
    {
        return view('wasambazaji.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jina'              => 'required|string|max:255',
            'simu'              => 'nullable|string|max:20',
            'whatsapp'          => 'nullable|string|max:20',
            'bidhaa_wanazouza'  => 'nullable|string|max:255',
            'maelezo'           => 'nullable|string',
        ]);

        Msambazaji::create($validated);

        return redirect()->route('wasambazaji.index')
            ->with('success', __('messages.msambazaji_ameongezwa'));
    }

    public function show(Msambazaji $wasambazaji)
    {
        $wasambazaji->load(['manunuzi.bidhaa']);
        $jumla_manunuzi = $wasambazaji->manunuzi->sum(fn($m) => $m->idadi * $m->bei_ya_kununulia);

        return view('wasambazaji.show', compact('wasambazaji', 'jumla_manunuzi'));
    }

    public function edit(Msambazaji $wasambazaji)
    {
        return view('wasambazaji.edit', compact('wasambazaji'));
    }

    public function update(Request $request, Msambazaji $wasambazaji)
    {
        $validated = $request->validate([
            'jina'              => 'required|string|max:255',
            'simu'              => 'nullable|string|max:20',
            'whatsapp'          => 'nullable|string|max:20',
            'bidhaa_wanazouza'  => 'nullable|string|max:255',
            'maelezo'           => 'nullable|string',
        ]);

        $wasambazaji->update($validated);

        return redirect()->route('wasambazaji.show', $wasambazaji)
            ->with('success', __('messages.msambazaji_amesasishwa'));
    }

    public function destroy(Msambazaji $wasambazaji)
    {
        $wasambazaji->delete();

        return redirect()->route('wasambazaji.index')
            ->with('success', __('messages.msambazaji_amefutwa'));
    }
}
