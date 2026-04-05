<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LughaController extends Controller
{
    public function badilisha(Request $request, string $lugha)
    {
        if (in_array($lugha, ['sw', 'en'])) {
            session(['lugha' => $lugha]);
            app()->setLocale($lugha);
        }

        return redirect()->back();
    }
}
