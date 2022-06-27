<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckBlockedStatusUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() == true) {
            $get_status = DB::table('users')
                ->select('blocked')
                ->where('id', Auth::id())
                ->get();

            if (isset($get_status[0]->blocked)) {
                if ($get_status[0]->blocked === 0) {
                    return $next($request);
                } else {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect(route('login'));
                };
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect(route('login'));
            };
        } else {
            $get_status = DB::table('users')
                ->select('blocked')
                ->where('email', $request->email)
                ->get();
            if (isset($get_status[0]->blocked)) {
                if ($get_status[0]->blocked === 0) {
                    return $next($request);
                } else {
                    return redirect(route('login'));
                };
            } else {
                return redirect(route('login'));
            };
        }
    }
}
