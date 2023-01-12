<?php

namespace Tixel\SafeLogger\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Tixel\SafeLogger\LogManager;

class LaravelServiceProvider extends ServiceProvider {
    public function boot()
    {
        $logger = new LogManager($this->app);
        $this->app->instance('log', $logger);
        $this->app->instance(LoggerInterface::class, $logger);
    }
}
