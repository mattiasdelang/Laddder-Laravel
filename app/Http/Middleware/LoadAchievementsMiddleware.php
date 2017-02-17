<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class LoadAchievementsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Extract rankInfo from session if available.
        if (\Auth::user() && Session::has('RankInfo')) {
            $info = (object)json_decode(Session::get('RankInfo'), 1);

            // Overwrite empty rankInfo with info from Session
            $rankInfo = \App::make('RankInfo');
            $rankInfo->currentExp = $info->currentExp;
            $rankInfo->currentRank = (object)$info->currentRank;
            $rankInfo->nextRank = (object)$info->nextRank;
        }

        return $next($request);
    }
}
