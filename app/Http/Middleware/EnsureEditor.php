<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEditor
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->hasRole('editor') && !auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}

