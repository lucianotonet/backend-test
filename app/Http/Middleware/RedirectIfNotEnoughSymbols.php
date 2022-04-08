<?php

namespace App\Http\Middleware;

use App\Models\Symbol;
use Closure;
use Illuminate\Support\Facades\View;

class RedirectIfNotEnoughSymbols
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Symbol::count() < 6) {
            return redirect()->route('backstage.symbols.index')->with('warning', 'There are not enough symbols. Please add more symbols.');
        }
        return $next($request);
    }
}
