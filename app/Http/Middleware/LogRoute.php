<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LogRoute
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
        $response = $next($request);

        if (app()->environment('local')) {
            $log = [
                'URI' => $request->getUri(),
                'METHOD' => $request->getMethod(),
                'REQUEST_BODY' => $request->all(),
                'RESPONSE' => $response->getContent()
            ];

            \App\Models\Response::insert([
                "status"=>0,
                "value"=>json_encode($log),
                //"author"=>isset(Auth::id())?Auth::id():0
            ]);
        }

        return $response;
    }
}
