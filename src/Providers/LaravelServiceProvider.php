<?php

namespace Tixel\SafeLogger\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Tixel\SafeLogger\LogManager;

class LaravelServiceProvider extends ServiceProvider {
    public function boot()
    {
        $logger = $this->app->make(LogManager::class);
        $this->app->bind('log', $logger);
        $this->app->bind(LoggerInterface::class, $logger);
    }
}
