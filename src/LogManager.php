<?php

namespace Tixel\SafeLogger;

use Illuminate\Log\LogManager as LaravelLogManager;

class LogManager extends LaravelLogManager {
    public function emergency($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->emergency($message, $this->mergeContexts($context));
    }

    public function alert($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->alert($message, $this->mergeContexts($context));
    }

    public function critical($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->critical($message, $this->mergeContexts($context));
    }

    public function error($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->error($message, $this->mergeContexts($context));
    }

    public function warning($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->warning($message, $this->mergeContexts($context));
    }

    public function notice($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->notice($message, $this->mergeContexts($context));
    }

    public function info($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->info($message, $this->mergeContexts($context));
    }

    public function debug($message, $context = []): void
    {
        $context = array_slice(func_get_args(), 1);

        $this->driver()->debug($message, $this->mergeContexts($context));
    }

    public function log($level, $message, $context = []): void
    {
        $context = array_slice(func_get_args(), 2);

        $this->driver()->log($level, $message, $this->mergeContexts($context));
    }

    /**
     * @param  $userPassedContext
     * @return array
     */
    protected function mergeContexts($userPassedContext)
    {
        return array_reduce($userPassedContext, function ($carry, $argument) {
            if (is_array($argument)) {
                $carry = array_merge($carry, $argument);
            } else {
                $carry[] = $argument;
            }

            return $carry;
        }, []);
    }
}