<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Repositories\Competitions;
use App\Competition;

class GetCurrentCompetition
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
        $competitions = new Competitions();
        $id = 3;
        $currentCompetition = Competition::find($id);

        View::share(compact(
            'currentCompetition',
        ));

        return $next($request);
    }
}
