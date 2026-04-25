<?php

namespace App\Http\Controllers;

use App\Models\Bidhaa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BidhaaController extends Controller
{
    private array $validationRules = [
        'jina'           => 'required|string|max:255',
        'maelezo'        => 'nullable|string',
        'picha'          => 'nullable|image|max:2048',
        'bei_halisi'     => 'required|numeric|min:0',
        'bei_yangu'      => 'required|numeric|min:0',
        'bei_jumla'      => 'nullable|numeric|min:0',
        'kategoria'      => 'nullable|string|max:100',
        'hali'           => 'required|in:inapatikana,imeuzwa,imesimamishwa',
        'idadi'          => 'required|integer|min:0',
        'kitengo'        => 'required|string|max:50',
        'idadi_ya_chini' => 'nullable|integer|min:0',
    ];

    public function index(Request $request)
    {
        $query = Bidhaa::query();

        if ($request->filled('tafuta')) {
            $query->where('jina', 'like', '%' . $request->tafuta . '%');
        }

        if ($request->filled('hali')) {
            $query->where('hali', $request->hali);
        }

        if ($request->filled('kategoria')) {
            $query->where('kategoria', $request->kategoria);
        }

        $bidhaa    = $query->latest()->paginate(12);
        $kategoria = $this->getKategoria();

        return view('bidhaa.index', compact('bidhaa', 'kategoria'));
    }

    public function create()
    {
        $kategoria = $this->getKategoria();
        return view('bidhaa.create', compact('kategoria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules);
        $validated = $this->handlePichaUpload($request, $validated);

        Bidhaa::create($validated);

        return redirect()->route('bidhaa.index')
            ->with('success', __('messages.bidhaa_imeongezwa'));
    }

    public function show(Bidhaa $bidhaa)
    {
        $bidhaa->load(['mauzo.mteja', 'maswali.mteja']);
        return view('bidhaa.show', compact('bidhaa'));
    }

    public function edit(Bidhaa $bidhaa)
    {
        $kategoria = $this->getKategoria();
        return view('bidhaa.edit', compact('bidhaa', 'kategoria'));
    }

    public function update(Request $request, Bidhaa $bidhaa)
    {
        $validated = $request->validate($this->validationRules);

        if ($request->hasFile('picha')) {
            Storage::disk('public')->delete($bidhaa->picha ?? '');
            $validated['picha'] = $request->file('picha')->store('bidhaa', 'public');
        }

        $bidhaa->update($validated);

        return redirect()->route('bidhaa.show', $bidhaa)
            ->with('success', __('messages.bidhaa_imesasishwa'));
    }

    public function destroy(Bidhaa $bidhaa)
    {
        Storage::disk('public')->delete($bidhaa->picha ?? '');
        $bidhaa->delete();

        return redirect()->route('bidhaa.index')
            ->with('success', __('messages.bidhaa_imefutwa'));
    }

    private function getKategoria()
    {
        return Bidhaa::whereNotNull('kategoria')->distinct()->pluck('kategoria');
    }

    private function handlePichaUpload(Request $request, array $validated): array
    {
        if ($request->hasFile('picha')) {
            $validated['picha'] = $request->file('picha')->store('bidhaa', 'public');
        }
        return $validated;
    }
}
