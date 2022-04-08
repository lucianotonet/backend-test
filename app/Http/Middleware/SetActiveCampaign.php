<?php

namespace App\Http\Middleware;

use App\Models\Campaign;
use App\Models\Symbol;
use Closure;

class SetActiveCampaign
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
        $activeCampaign = null;

        if (session('activeCampaign')) {
            $activeCampaign = Campaign::find(session('activeCampaign'));

            if ($activeCampaign === null) {
                session()->forget('activeCampaign');
            }

            if (Symbol::count() < 6) {
                session()->forget('activeCampaign');
                session()->flash('warning', 'There are not enough symbols to start a campaign. Please add more symbols.');
            }
        }

        view()->share('activeCampaign', $activeCampaign);

        return $next($request);
    }
}
