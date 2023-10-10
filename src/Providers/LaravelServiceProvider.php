<?php

namespace Tixel\SafeLogger\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use Tixel\SafeLogger\LogManager;
use Illuminate\Support\Facades\Log;

class LaravelServiceProvider extends ServiceProvider {
    public function boot()
    {
        $logger = new LogManager($this->app);

        $oldLogger = resolve('log');
        if ($oldLogger) {
            $logger->setChannels((fn() => $this->channels)->call($oldLogger));
            $logger->setSharedContext((fn() => $this->sharedContext)->call($oldLogger));
            $logger->setCustomCreators((fn() => $this->customCreators)->call($oldLogger));
            $logger->setDateFormat((fn() => $this->dateFormat)->call($oldLogger));
        }

        $this->app->instance('log', $logger);
        $this->app->instance(LoggerInterface::class, $logger);
        Log::swap($logger);
    }
}