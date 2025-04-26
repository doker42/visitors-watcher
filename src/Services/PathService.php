<?php

namespace Doker42\VisitorsWatcher\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class PathService
{
    protected static string $cacheKey = 'public_base_paths';

    /**
     * Получить публичные базовые пути
     */
    public static function getPublicBasePaths(): array
    {
        return Cache::rememberForever(self::$cacheKey, function () {
            return self::getPublicPaths();
        });
    }

    public static function getPublicPaths()
    {
        return collect(Route::getRoutes())
            ->filter(function ($route) {
                $middlewares = $route->gatherMiddleware();

                return !collect($middlewares)->contains(function ($middleware) {
                    return str_contains($middleware, 'auth')
                        || str_contains($middleware, 'api')
                        || str_contains($middleware, 'admin');
                });
            })
            ->map(function ($route) {
                $uri = $route->uri();

                if (str_contains($uri, '{')) {
                    $uri = strstr($uri, '{', true);
                    $uri = rtrim($uri, '/');
                }

                return '/' . ltrim($uri, '/');
            })
            ->unique()
            ->values()
            ->all();
    }


    public function refreshCache(): void
    {
        Cache::forget(self::$cacheKey);
        self::getPublicBasePaths();
    }

}