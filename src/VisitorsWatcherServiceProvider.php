<?php

namespace Doker42\VisitorsWatcher;

use Doker42\VisitorsWatcher\Console\Commands\DeleteOldVisitors;
use Doker42\VisitorsWatcher\Http\Middleware\Throttle404Middleware;
use Doker42\VisitorsWatcher\Http\Middleware\Throttle404WithRateLimiter;
use Doker42\VisitorsWatcher\Http\Middleware\VisitorMiddleware;
use Illuminate\Support\ServiceProvider;

class VisitorsWatcherServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/visitors.php');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'visitors');

        $this->publishes([
            __DIR__ . '/resources/assets' => public_path('vendor/visitors'),
        ], 'visitors');

        $this->publishes([
            __DIR__ . '/config/visitors.php' => config_path('visitors.php')
        ], 'visitors');

        $this->publishesMigrations([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'visitors');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DeleteOldVisitors::class,
            ]);
        }

        $this->registerMiddleware();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/visitors.php', 'visitors'
        );
    }


    protected function registerMiddleware(): void
    {
        if (config('visitors.middleware.visitors.enabled', true)) {
            $this->app->booted(function () {
                $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
                $kernel->pushMiddleware(VisitorMiddleware::class);
            });
        }

        if (config('visitors.middleware.throttle_404.enabled', true)) {
            $this->app->booted(function () {
                $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
                $kernel->pushMiddleware(Throttle404Middleware::class);
            });
        }

        if (config('visitors.middleware.throttle_404with_limit.enabled', true)) {
            $this->app->booted(function () {
                $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
                $kernel->pushMiddleware(Throttle404WithRateLimiter::class);
            });
        }
    }
}

