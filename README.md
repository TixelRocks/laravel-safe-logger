# laravel-safe-logger
A safe Laravel logger that will never crash your app

## Introduction

This repo is based on a failed Laravel framework PR from us:
https://github.com/laravel/framework/pull/45604

Because we still find it to be very useful we extracted it to a package.

The idea is very simple and can be formulated in one sentence:

### Logging facility should never crash your app ###

Or to re-phrase:

### Under no circumstances, none at all, logging facility should crash your app ###

People rely on logs when things go bad so the last thing you want to happen is
for things to go bad because of logging.

As an example, try crashing JavaScript's console.log (good luck!):

```javascript
console.log('plain message')
// plain message
console.log('plain message', 123, [])
// plain message 123 []
```

You can send anything and it just works. Because when things go bad, you don't want to worry
about logs making things even worse.

Now coming back to Laravel, it's trivial to break the whole application when using the Log
facade:

```php
Log::emergency('Something bad happened!', false);
Illuminate\Log\LogManager::emergency(): Argument #2 ($context) must be of type array, bool given, called in vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php on line 338 in vendor/psy/psysh/src/Exception/TypeErrorException.php on line 53.
```

If this looks too artificial, here is a real-world example:

```php
try {
    $details = $api->request(); // $api is some kind of a third-party SDK
} catch (ClientException $e) {
    // $e->getResponse() might have a nice JSON error message but might have a CDN's HTML error or something else
    Log::emergency("Oh no, we got a failed API request!", json_decode($e->getResponse()->getContent()));
}
```

And yes - developers CAN be careful and always pass correct arguments, a string and an array,
but do we want to be careful with loggers? Does that make sense for you?

If you refer to the PSR documentation:
https://www.php-fig.org/psr/psr-3/

```
1.3 Context
...The array can contain anything. Implementors MUST ensure they treat context data with as much lenience as possible. A given value in the context MUST NOT throw an exception nor raise any php error, warning or notice.
```

It actually mentions how we should never throw any errors or exceptions and should be as lenient as possible.

## Installation

```bash
$ composer require tixelrocks/laravel-safe-logger
```

That's it! Now we can do "funky" stuff like:

```php
Log::emergency("Hello", $results, 'Another message');
```

Of course, we don't have to. But it's just nice to be able not to worry about Log crashing
your app ever.