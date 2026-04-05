<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $lugha = session('lugha', config('app.locale'));
        app()->setLocale($lugha);
        return $next($request);
    }
}
