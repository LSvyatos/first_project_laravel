<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckAccess
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
        $id=Auth::id();
        if($id)
        {
         $check=(new \App\Http\Controllers\Users\Privileges)->get();
          if($check>1)
          {
           return $next($request);
          }
        }
        return $next($request);
        abort(403, 'Access denied');
    }
}
