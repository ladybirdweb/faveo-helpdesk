Bugsnag Notifier for Laravel and Lumen
=====================================

The Bugsnag Notifier for Laravel gives you instant notification of errors and
exceptions in your Laravel PHP applications. We support Laravel 5, Laravel 4, Laravel 3, and Lumen.

[Bugsnag](https://bugsnag.com) captures errors in real-time from your web,
mobile and desktop applications, helping you to understand and resolve them
as fast as possible. [Create a free account](https://bugsnag.com) to start
capturing errors from your applications.

Check out this excellent [Laracasts screencast](https://laracasts.com/lessons/better-error-tracking-with-bugsnag) for a quick overview of how to use Bugsnag with your Laravel apps.


How to Install
---------------

### Laravel 5.0 +

1.  Install the `bugsnag/bugsnag-laravel` package

    ```shell
    $ composer require bugsnag/bugsnag-laravel:1.*
    ```

1. Update `config/app.php` to activate Bugsnag

    ```php
    # Add `BugsnagLaravelServiceProvider` to the `providers` array
    'providers' => array(
        ...
        Bugsnag\BugsnagLaravel\BugsnagLaravelServiceProvider::class,
    )

    # Add the `BugsnagFacade` to the `aliases` array
    'aliases' => array(
        ...
        'Bugsnag' => Bugsnag\BugsnagLaravel\BugsnagFacade::class,
    )
    ```

1. Use the Bugsnag exception handler from `App/Exceptions/Handler.php`.

    ```php
    # DELETE this line
    use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
    ```

    ```php
    # ADD this line instead
    use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;
    ```

    After this change, your file should look like this:

    ```php
    <?php namespace App\Exceptions;

    use Exception;
    use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;

    class Handler extends ExceptionHandler {
        ...
    }

    ```

1. Create the configuration file `config/bugsnag.php`:

    ```shell
    $ php artisan vendor:publish
    ```

1. Configure your `api_key` in your `.env` file:

    ```shell
    BUGSNAG_API_KEY=YOUR-API-KEY-HERE
    ```

1.  Optionally, you can add the `notify_release_stages` key to the `config/bugsnag.php` file
    to define which Laravel environments will send Exceptions to Bugsnag.

    ```php
    return array(
        'api_key' => env('BUGSNAG_API_KEY'),
        'notify_release_stages' => ['production', 'staging']
    );
    ```

### Laravel < 5.0

1.  Install the `bugsnag/bugsnag-laravel` package

    ```shell
    $ composer require bugsnag/bugsnag-laravel:1.*
    ```

1. Update app/config/app.php` to activate Bugsnag

    ```php
    # Add `BugsnagLaravelServiceProvider` to the `providers` array
    'providers' => array(
        ...
        'Bugsnag\BugsnagLaravel\BugsnagLaravelServiceProvider',
    )

    # Add the `BugsnagFacade` to the `aliases` array
    'aliases' => array(
        ...
        'Bugsnag' => 'Bugsnag\BugsnagLaravel\BugsnagFacade',
    )
    ```

1.  Generate a template Bugsnag config file

    ```shell
    $ php artisan config:publish bugsnag/bugsnag-laravel
    ```

1.  Update `app/config/packages/bugsnag/bugsnag-laravel/config.php` with your
    Bugsnag API key:

    ```php
    return array(
        'api_key' => 'YOUR-API-KEY-HERE'
    );
    ```

1.  Optionally, you can add the `notify_release_stages` key to the same file
    above to define which Laravel environments will send Exceptions to Bugsnag.

    ```php
    return array(
        'api_key' => 'YOUR-API-KEY-HERE',
        'notify_release_stages' => ['production', 'staging']
    );
    ```


### Lumen

1. In `bootstrap/app.php` add the line

    ```php
    $app->register('Bugsnag\BugsnagLaravel\BugsnagLumenServiceProvider');
    ```

    just before the line

    ```php
    require __DIR__ . '/../app/Http/routes.php';
    ```

2. Change the function `report` in `app/Exceptions/Handler.php` to look like this:

    ```php
    public function report(Exception $e) {
        app('bugsnag')->notifyException($e, []);
        return parent::report($e);
    }
    ```

3. Create a file `config/bugsnag.php` that contains your API key

    ```php
    <?php # config/bugsnag.php

    return array(
        'api_key' => 'YOUR-API-KEY-HERE'
    );
    ```




Sending Custom Data With Exceptions
-----------------------------------

It is often useful to send additional meta-data about your app, such as
information about the currently logged in user, along with any
error or exceptions, to help debug problems.

To send custom data, you should define a *before-notify* function,
adding an array of "tabs" of custom data to the $metaData parameter. For example:

```php
Bugsnag::setBeforeNotifyFunction("before_bugsnag_notify");

function before_bugsnag_notify($error) {
    // Do any custom error handling here

    // Also add some meta data to each error
    $error->setMetaData(array(
        "user" => array(
            "name" => "James",
            "email" => "james@example.com"
        )
    ));
}
```

See the [setBeforeNotifyFunction](https://bugsnag.com/docs/notifiers/php#setbeforenotifyfunction)
documentation on the `bugsnag-php` library for more information.


Sending Custom Errors or Non-Fatal Exceptions
---------------------------------------------

You can easily tell Bugsnag about non-fatal or caught exceptions by
calling `Bugsnag::notifyException`:

```php
Bugsnag::notifyException(new Exception("Something bad happened"));
```

You can also send custom errors to Bugsnag with `Bugsnag::notifyError`:

```php
Bugsnag::notifyError("ErrorType", "Something bad happened here too");
```

Both of these functions can also be passed an optional `$metaData` parameter,
which should take the following format:

```php
$metaData =  array(
    "user" => array(
        "name" => "James",
        "email" => "james@example.com"
    )
);
```


Error Reporting Levels
----------------------

By default we'll use the value of `error_reporting` from your `php.ini`
or any value you set at runtime using the `error_reporting(...)` function.

If you'd like to send different levels of errors to Bugsnag, you can call
`setErrorReportingLevel`, for example:

```php
Bugsnag::setErrorReportingLevel(E_ALL & ~E_NOTICE);
```


Additional Configuration
------------------------

The [Bugsnag PHP Client](https://bugsnag.com/docs/notifiers/php)
is available as `Bugsnag`, which allows you to set various
configuration options, for example:

```php
Bugsnag::setReleaseStage("production");
```

See the [Bugsnag Notifier for PHP documentation](https://bugsnag.com/docs/notifiers/php#additional-configuration)
for full configuration details.


Reporting Bugs or Feature Requests
----------------------------------

Please report any bugs or feature requests on the github issues page for this
project here:

<https://github.com/bugsnag/bugsnag-laravel/issues>


Contributing
------------

-   [Fork](https://help.github.com/articles/fork-a-repo) the [notifier on github](https://github.com/bugsnag/bugsnag-laravel)
-   Commit and push until you are happy with your contribution
-   Run the tests to make sure they all pass: `composer install && ./vendor/bin/phpunit`
-   [Make a pull request](https://help.github.com/articles/using-pull-requests)
-   Thanks!


License
-------

The Bugsnag Laravel notifier is free software released under the MIT License.
See [LICENSE.txt](https://github.com/bugsnag/bugsnag-laravel/blob/master/LICENSE.txt) for details.
