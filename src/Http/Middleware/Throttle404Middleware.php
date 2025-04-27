<?php

namespace Doker42\VisitorsWatcher\Http\Middleware;

use Closure;
use Doker42\VisitorsWatcher\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Throttle404Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        if (Visitor::isIgnoredIp($ip)) {
            return $next($request);
        }

        $key = "404_attempts:{$ip}";

        $attempts = Cache::get($key, 0);

        if ($attempts >= config('visitors.middleware.throttle_404.attempts')) {
            sleep(config('visitors.middleware.throttle_404.sleep_time'));
        }

        $response = $next($request);

        if ($response->getStatusCode() === Response::HTTP_NOT_FOUND) {
            Cache::put($key, $attempts + 1, now()->addHour());
        }

        return $response;
    }
}
