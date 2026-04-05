<?php

namespace App\Http\Controllers;

use App\Models\Mteja;
use Illuminate\Http\Request;

class WatejaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mteja::withCount('mauzo')->withSum('mauzo', 'faida');

        if ($request->filled('tafuta')) {
            $query->where(function ($q) use ($request) {
                $q->where('jina', 'like', '%' . $request->tafuta . '%')
                  ->orWhere('simu', 'like', '%' . $request->tafuta . '%');
            });
        }

        $wateja = $query->latest()->paginate(15);
        return view('wateja.index', compact('wateja'));
    }

    public function create()
    {
        return view('wateja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jina'    => 'required|string|max:255',
            'simu'    => 'nullable|string|max:20',
            'whatsapp'=> 'nullable|string|max:20',
            'maelezo' => 'nullable|string',
        ]);

        Mteja::create($validated);

        return redirect()->route('wateja.index')
            ->with('success', __('messages.mteja_ameongezwa'));
    }

    public function show(Mteja $wateja)
    {
        $wateja->load(['mauzo.bidhaa', 'maswali.bidhaa']);
        return view('wateja.show', compact('wateja'));
    }

    public function edit(Mteja $wateja)
    {
        return view('wateja.edit', compact('wateja'));
    }

    public function update(Request $request, Mteja $wateja)
    {
        $validated = $request->validate([
            'jina'    => 'required|string|max:255',
            'simu'    => 'nullable|string|max:20',
            'whatsapp'=> 'nullable|string|max:20',
            'maelezo' => 'nullable|string',
        ]);

        $wateja->update($validated);

        return redirect()->route('wateja.show', $wateja)
            ->with('success', __('messages.mteja_amesasishwa'));
    }

    public function destroy(Mteja $wateja)
    {
        $wateja->delete();
        return redirect()->route('wateja.index')
            ->with('success', __('messages.mteja_amefutwa'));
    }
}
