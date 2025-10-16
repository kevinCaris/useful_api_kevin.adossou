<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckModuleActive
{
    public function handle(Request $request, Closure $next, $moduleId)
    {
        $user = auth()->user();

        $module = $user->modules()->where('module_id', $moduleId)->where('active', true)->first();

        if (!$module) {
            return response()->json(['error' => 'Module inactive. Please activate this module to use it.'], 403);
        }

        return $next($request);
    }
}
