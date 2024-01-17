<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CheckDivisi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check the user's divisi_id
        $divisionId = Auth::user()->divisi_id;

        // Determine layout based on divisi_id
        $layout = ($divisionId === 1) ? 'layouts.manager' : 'layouts.staff';

        // Share the layout variable with all views
        View::share('layout', $layout);

        return $next($request);
    }
}
