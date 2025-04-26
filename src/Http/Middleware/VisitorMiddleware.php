<?php

namespace Doker42\VisitorsWatcher\Http\Middleware;

use Closure;
use Doker42\VisitorsWatcher\Jobs\HandleRequest;
use Doker42\VisitorsWatcher\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $this->getRequestData($request);

        if (Visitor::isIgnoredIp($data['ip'])) {
            return $next($request);
        }

        if (Visitor::isBanned($data['ip'])) {
            sleep(config('visitors.banned.sleep_time'));
            abort(404);
        }

        if (
            collect(config('admin.bad_agents'))->first(fn($agent) => str_contains($data['agent'], $agent)) ||
            collect(config('admin.bad_paths'))->first(fn($segment) => str_contains($data['path'], $segment))
        ) {
            sleep(config('visitors.bad_request.sleep_time'));
            return response('Access Denied', 418)
                ->header('X-Defense', 'Honeypot')
                ->header('Retry-After', '86400'); // 1 день
        }

        dispatch(new HandleRequest($data));

        return $next($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getRequestData(Request $request): array
    {
        return [
            'ip'     => $request->getClientIp(),
            'url'    => $request->getRequestUri(),
            'path'   => '/' . $request->path(),
            'method' => $request->method(),
            'agent'  => strtolower($request->userAgent() ?? ''),
        ];
    }
}
