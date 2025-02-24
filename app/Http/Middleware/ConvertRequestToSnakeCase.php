<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConvertRequestToSnakeCase
{
    public function handle(Request $request, Closure $next)
    {
        $request->replace(
            collect($request->all())->mapWithKeys(function ($value, $key) {
                return [str()->snake($key) => $value];
            })->toArray()
        );

        return $next($request);
    }
}
