<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && $request->path() === '/') {
            $visitorHash = hash('sha256', $request->ip().'|'.$request->userAgent());
            VisitorLog::firstOrCreate([
                'visitor_hash' => $visitorHash,
                'visited_on' => now()->toDateString(),
            ]);
        }

        return $next($request);
    }
}
