<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Symfony\Component\HttpFoundation\Response;

class TrackActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'module' => $request->segment(1),
                'action' => $request->method() . '-' . $request->path(),
                'description' => 'User visited ' . $request->path(),
                'ip_address' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}