<?php

namespace App\Http\Controllers;

use App\Models\Swali;
use App\Models\Uuzaji;
use App\Models\Bidhaa;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = collect();

        // Pending inquiries
        $pending = Swali::with('mteja', 'bidhaa')
            ->where('hali', 'inasubiri')
            ->latest()
            ->take(5)
            ->get();

        foreach ($pending as $swali) {
            $notifications->push([
                'type'    => 'inquiry',
                'icon'    => 'chat',
                'color'   => 'blue',
                'title'   => $swali->mteja->jina ?? 'Mteja',
                'body'    => $swali->ujumbe,
                'time'    => $swali->created_at->diffForHumans(),
                'url'     => route('maswali.index'),
            ]);
        }

        // Sales from today
        $todaySales = Uuzaji::with('bidhaa', 'mteja')
            ->whereDate('created_at', today())
            ->latest()
            ->take(5)
            ->get();

        foreach ($todaySales as $sale) {
            $notifications->push([
                'type'  => 'sale',
                'icon'  => 'sale',
                'color' => 'green',
                'title' => 'Uuzaji: ' . ($sale->bidhaa->jina ?? '—'),
                'body'  => 'TZS ' . number_format($sale->faida) . ' faida — ' . ($sale->mteja->jina ?? ''),
                'time'  => $sale->created_at->diffForHumans(),
                'url'   => route('mauzo.index'),
            ]);
        }

        // Suspended products
        $suspended = Bidhaa::where('hali', 'imesimamishwa')->latest()->take(3)->get();

        foreach ($suspended as $bidhaa) {
            $notifications->push([
                'type'  => 'product',
                'icon'  => 'box',
                'color' => 'orange',
                'title' => __('ui.bidhaa_imesimamishwa'),
                'body'  => $bidhaa->jina,
                'time'  => $bidhaa->updated_at->diffForHumans(),
                'url'   => route('bidhaa.index'),
            ]);
        }

        $sorted = $notifications->sortByDesc('time')->values();

        return response()->json([
            'count'         => $notifications->count(),
            'notifications' => $sorted,
        ]);
    }
}
