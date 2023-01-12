<?php

use Orchestra\Testbench\TestCase;

use Tixel\SafeLogger\LogManager;

class LogManagerTest extends TestCase {
    public function testContextCanIncludeAnyNumberOfArguments()
    {
        $manager = new LogManager($this->app);

        $stack = $manager->stack(['single']);
        $stack->listen(function ($message) use (&$context) {
            $context = $message->context;
        });

        $object = (object) [];

        $manager->error('foo', 'text', 15, [
            'key' => 'value',
        ], $object);

        $this->assertSame([
            'text',
            15,
            'key' => 'value',
            $object,
        ], $context);
    }
}