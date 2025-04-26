<?php

namespace Doker42\VisitorsWatcher;

use Doker42\VisitorsWatcher\Console\Commands\DeleteOldVisitors;
use Illuminate\Support\ServiceProvider;

class VisitorsWatcherServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/visitors.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'visitors');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/visitors'),
        ], 'visitors');

        $this->publishes([
            __DIR__ . '/../config/visitors.php' => config_path('visitors.php')
        ], 'visitors');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'visitors');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DeleteOldVisitors::class,
            ]);
        }
    }

    public function register()
    {
        //
    }

}

