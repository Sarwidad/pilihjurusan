<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckServerStatus
{
    public function handle($request, Closure $next)
    {
        
        $isServerUp = true; 

        if ($isServerUp) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Server is down.'], 502);
        }
    }
}
