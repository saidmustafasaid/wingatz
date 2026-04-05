<?php

namespace App\Http\Controllers;

use App\Models\Swali;
use App\Models\Bidhaa;
use App\Models\Mteja;
use Illuminate\Http\Request;

class MaswalijController extends Controller
{
    public function index(Request $request)
    {
        $query = Swali::with(['mteja', 'bidhaa']);

        if ($request->filled('hali')) {
            $query->where('hali', $request->hali);
        }

        $maswali = $query->latest()->paginate(15);
        return view('maswali.index', compact('maswali'));
    }

    public function create()
    {
        $bidhaa = Bidhaa::inapatikana()->orderBy('jina')->get();
        $wateja = Mteja::orderBy('jina')->get();
        return view('maswali.create', compact('bidhaa', 'wateja'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mteja_id'  => 'required|exists:wateja,id',
            'bidhaa_id' => 'nullable|exists:bidhaa,id',
            'ujumbe'    => 'nullable|string',
            'hali'      => 'required|in:inasubiri,imenunuliwa,imekimbia',
        ]);

        Swali::create($validated);

        return redirect()->route('maswali.index')
            ->with('success', __('messages.swali_limeongezwa'));
    }

    public function update(Request $request, Swali $maswali)
    {
        $validated = $request->validate([
            'hali' => 'required|in:inasubiri,imenunuliwa,imekimbia',
        ]);

        $maswali->update($validated);

        return redirect()->route('maswali.index')
            ->with('success', __('messages.swali_limesasishwa'));
    }

    public function destroy(Swali $maswali)
    {
        $maswali->delete();
        return redirect()->route('maswali.index')
            ->with('success', __('messages.swali_limefutwa'));
    }
}
