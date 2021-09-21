---
id: errors
title: Errors
---

The `ExceptionHandler` is a basic handler to manage `Exception` and `ExceptionError` events. It is responsible for handling errors and exception event reporting to a defined logger.

The `BasicException` is the base class to be extended by any exceptions we want to be handled by the `ExceptionHandler`.

## Extending the Handler

The `ExceptionHandler` can be extended to provide alternative loggers and handle more event types. Any exception classes wanting to use the extended handler can do so by providing it to the parent constructor.

```php
use GoDaddy\WordPress\MWC\Common\Exceptions\BaseException;
use GoDaddy\WordPress\MWC\Common\Exceptions\ExceptionHandler;

class MyHandler extends ExceptionHandler {
}

class MyException extends BaseException {

    public function __construct(string $message)
    {
        parent::__construct($message, new MyHandler());
    }
}
```

## Callback

The `BaseException` does not provide additional handling for exceptions other than [reporting](errors#report-events) them. Child implementation can override the basic empty `callback` to include additional handling when an `Exception` is to be [reported](errors#report-events).

```php
use GoDaddy\WordPress\MWC\Common\Exceptions\BaseException;

class MyException extends BaseException {

    public function callback()
    {
        // do something
    }   
}
```

## Context

The `context` internal method is intended to provide additional system configuration data when a `BaseException` event is logged.

Children implementations can extend this method to provide additional data, if necessary.

```php
use GoDaddy\WordPress\MWC\Common\Exceptions\ExceptionHandler;

class MyHandler extends ExceptionHandler {

    protected function context() : array
    {
        $context = parent::context();
        $context['myKey'] = 'myValue';
        return $context;
    }   
}
```

## Error Handling

When the `ExceptionHandler` is instantiated, it will automatically convert PHP errors to `ErrorException` exceptions, via `handleError` method.

## Event Handling

When the `ExceptionHandler` is instantiated, it will automatically handle `Exception` events to be [reported](errors#report-events), via `handleException` method.

## Ignore events

The `ignore` method can be used to define exceptions that should be ignored by the handler.

```php
use GoDaddy\WordPress\MWC\Common\Exceptions\ExceptionHandler;

$handler = new ExceptionHandler();
$handler->ignore('MyCustomException');

```

## Report events

The base `report` method will check if the current exception event is [ignored](#ignore-events) and if not, it will invoke a [callback](#callback) and then [log](#alternative-loggers) the event.

```php
use GoDaddy\WordPress\MWC\Common\Exceptions\BaseException;
use GoDaddy\WordPress\MWC\Common\Exceptions\ExceptionHandler;

$handler = new ExceptionHandler();
$handler->report(new BaseException());
```

## Alternative loggers

The `getLogger` method can be overridden by child implementations to define an alternative [logger](/components/logger) for custom handling of exception reporting.

```php
use GoDaddy\WordPress\MWC\Common\Exceptions\ExceptionHandler;
use GoDaddy\WordPress\MWC\Common\Loggers\Logger;

class MyHandler extends ExceptionHandler {

    protected function getLogger() : Logger
    {
        return ( new class extends Logger { 
            // Logger implementation instance
        } );
    }   
}
```