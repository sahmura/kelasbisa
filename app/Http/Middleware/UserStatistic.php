<?php

namespace App\Http\Middleware;

use Closure;
use App\MentorStatistic;

class UserStatistic
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
        $isMentor = MentorStatistic::where('user_id', '=', $request->user()->id)->count();
        if ($isMentor != 0) {
            return $next($request);
        }

        return redirect('home');
    }
}
