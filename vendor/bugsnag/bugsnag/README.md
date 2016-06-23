Bugsnag Notifier for PHP <img src="https://travis-ci.org/bugsnag/bugsnag-php.svg?branch=master" alt="build status" class="build-status">
========================

The Bugsnag Notifier for PHP gives you instant notification of errors and
exceptions in your PHP applications.

[Bugsnag](https://bugsnag.com) captures errors in real-time from your web,
mobile and desktop applications, helping you to understand and resolve them
as fast as possible. [Create a free account](https://bugsnag.com) to start
capturing errors from your applications.

The Bugsnag Notifier for PHP supports PHP 5.2+.


How to Install
--------------

### Using [Composer](http://getcomposer.org/) (Recommended)

1.  Install the `bugsnag/bugsnag-php` package:

    ```shell
    $ composer require "bugsnag/bugsnag:2.*"
    ```

### Using Phar Package

1.  Download the latest [bugsnag.phar](https://raw.github.com/bugsnag/bugsnag-php/master/build/bugsnag.phar)
    to your PHP project.

2.  Require it in your app.

    ```php
    require_once "/path/to/bugsnag.phar";
    ```

### Manual Installation

1.  Download and extract the [latest Bugsnag source code](https://github.com/bugsnag/bugsnag-php/archive/master.zip)
    to your PHP project.

2.  Require it in your app using the provided autoloader.

    ```php
    require_once "/path/to/Bugsnag/Autoload.php";
    ```


Configuration
-------------

1.  Configure Bugsnag with your API key:

    ```php
    $bugsnag = new Bugsnag_Client('YOUR-API-KEY-HERE');
    ```

2.  Enable automatic error and exception notification by attaching Bugsnag's
    error and exception handlers:

    ```php
    set_error_handler(array($bugsnag, 'errorHandler'));
    set_exception_handler(array($bugsnag, 'exceptionHandler'));
    ```

    If you app or PHP framework already has error handling functions, you can
    also call `$bugsnag->errorHandler` and `$bugsnag->exceptionHandler`
    directly from your existing functions, simply pass all parameters through.


Sending Custom Data With Exceptions
-----------------------------------

It is often useful to send additional meta-data about your app, such as
information about the currently logged in user, along with any
error or exceptions, to help debug problems.

Bugsnag supports sending user information, such as the user's name or email
address, by calling the [setUser](#setUser) function.

To send other custom data, you should define a *before-notify* function,
adding an array of "tabs" of custom data to the $metaData parameter.
For an example, see the [setBeforeNotifyFunction](#setbeforenotifyfunction)
documentation below.


Sending Custom Errors or Non-Fatal Exceptions
---------------------------------------------

You can easily tell Bugsnag about non-fatal or caught exceptions by
calling `notifyException`:

```php
$bugsnag->notifyException(new Exception('Something bad happened'));
```

You can also send custom errors to Bugsnag with `notifyError`:

```php
$bugsnag->notifyError('ErrorType', 'Something bad happened here too');
```

Both of these functions can also be passed an optional `$metaData` parameter,
which should take the following format:

```php
$metaData =  array(
    'account' => array(
        'paying' => true,
        'name' => 'Acme Co'
    )
);
```

### Severity

You can set the severity of an error in Bugsnag by including the severity option as the fourth parameter when
notifying bugsnag of the error,

```php
$bugsnag->notifyError('ErrorType', 'Something bad happened here too', NULL, "error")
```

Valid severities are `error`, `warning` and `info`.

Severity is displayed in the dashboard and can be used to filter the error list.
By default all crashes (or unhandled exceptions) are set to `error` and all
`$bugsnag->notify` calls default to `warning`.


Additional Configuration
------------------------

###setUser

Bugsnag helps you understand how many of your users are affected by each
error, and allows you to search for which errors affect a particular user
using your Bugsnag dashboard. To send useful user-specific information you can
call `setUser`:

```php
$bugsnag->setUser(array(
    'name' => 'Leeroy Jenkins',
    'email' => 'leeeeroy@jenkins.com'
));
```

The `name`, `email` and `id` fields are searchable, and everything you send in
this array will be displayed on your Bugsnag dashboard.

The `id` field is used also used by Bugsnag to determine the number of
impacted users. By default, we use the IP address of the request as the `id`.

###setReleaseStage

If you would like to distinguish between errors that happen in different
stages of the application release process (development, production, etc)
you can set the `releaseStage` that is reported to Bugsnag.

```php
$bugsnag->setReleaseStage('development');
```

By default this is set to "production".


###setNotifyReleaseStages

By default, we will notify Bugsnag of errors that happen in *any*
`releaseStage` If you would like to change which release stages notify
Bugsnag of errors you can call `setNotifyReleaseStages`:

```php
$bugsnag->setNotifyReleaseStages(array('development', 'production'));
```

###setMetaData

Sets additional meta-data to send with every bugsnag notification,
for example:

```php
$bugsnag->setMetaData(array(
    'account' => array(
        'paying' => true,
        'name' => 'Acme Co'
    )
));
```

###setContext

Bugsnag uses the concept of "contexts" to help display and group your
errors. Contexts represent what was happening in your application at the
time an error occurs. By default this will be set to the current request
URL and HTTP method, eg "GET /pages/documentation".

If you would like to set the bugsnag context manually, you can call
`setContext`:

```php
$bugsnag->setContext('Backport Job');
```

###setType

You can set the type of application executing the current code by using
`setType`:

```php
$bugsnag->setType('resque');
```

This is usually used to represent if you are running plain PHP code "php", via
a framework, eg "laravel", or executing through delayed worker code,
eg "resque". By default this is `NULL`.

###setFilters

Sets the strings to filter out from the `metaData` arrays before sending
them to Bugsnag. Use this if you want to ensure you don't send
sensitive data such as passwords, and credit card numbers to our
servers. Any keys which contain these strings will be filtered.

```php
$bugsnag->setFilters(array('password', 'credit_card'));
```

By default, this is set to be `array("password")`.

###setEndpoint

Set the endpoint to send error reports to. By default we'll send reports to
the standard `https://notify.bugsnag.com` endpoint, but you can override this
if you are using [Bugsnag Enterprise](https://bugsnag.com/enterprise), to
point to your own Bugsnag endpoint:

```php
$bugsnag->setEndpoint("http://bugsnag.internal.example.com");
```

###setTimeout

Define a custom timeout in seconds for the connection when notifying bugsnag.com.

```php
$bugsnag->setTimeout(2);
```

By default, this is set to be `2`.

###setBeforeNotifyFunction

Set a custom function to call before notifying Bugsnag of an error.
You can use this to call your own error handling functions, to add custom
tabs of data to each error on your Bugsnag dashboard, or to modify the
stacktrace.

To add custom tabs of meta-data, simply add to the `$metaData` array
that is passed as the first parameter to your function, for example:

```php
$bugsnag->setBeforeNotifyFunction('before_bugsnag_notify');

function before_bugsnag_notify(Bugsnag_Error $error) {
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

If Bugsnag is called by a wrapper library, you can remove stack frames from the
back-trace. For example:

```php
function before_bugsnag_notify(Bugsnag_Error $error) {

    $firstFrame = $error->stacktrace->frames[0];
    if ($firstFrame && $firstFrame['file'] === 'My_Logger.php') {
        array_splice($error->stacktrace->frames, 0, 1);
    }

}

```

You can also return `FALSE` from your beforeNotifyFunction to stop this error
from being sent to bugsnag.

###setAutoNotify

Controls whether bugsnag should automatically notify about any errors it detects in
the PHP error handlers.

```php
$bugsnag->setAutoNotify(FALSE);
```

By default, this is set to `TRUE`.

###setErrorReportingLevel

Set the levels of PHP errors to report to Bugsnag, by default we'll use
the value of `error_reporting` from your `php.ini` or any value you set
at runtime using the `error_reporting(...)` function.

If you'd like to send different levels of errors to Bugsnag, you can call
`setErrorReportingLevel`:

```php
$bugsnag->setErrorReportingLevel(E_ALL & ~E_NOTICE);
```

See PHP's [error reporting documentation](http://php.net/manual/en/errorfunc.configuration.php#ini.error-reporting)
for allowed values.

<!-- Custom anchor for linking from alerts -->
<div id="set-project-root"></div>
###setProjectRoot

We mark stacktrace lines as in-project if they come from files inside your
`projectRoot`. By default this value is automatically set to be
`$_SERVER['DOCUMENT_ROOT']` but sometimes this can cause problems with
stacktrace highlighting. You can set this manually by calling `setProjectRoot`:

```php
$bugsnag->setProjectRoot('/path/to/your/app');
```

If your app has files in many different locations, you should consider using
[setProjectRootRegex](#setprojectrootregex) instead.

###setProjectRootRegex

If your app has files in many different locations, you can set the a regular
expression for matching filenames in stacktrace lines that are part of your
application:

```php
$bugsnag->setProjectRootRegex('('.preg_quote('/app').'|'.preg_quote('/libs').')');
```

###setProxySettings

> Note: Proxy configuration is only possible if the PHP cURL extension is installed.

If your server is behind a proxy server, you can configure this as well:

```php
$bugsnag->setProxySettings(array(
    'host' => 'bugsnag.com',
    'port' => 42,
    'user' => 'username',
    'password' => 'password123'
));
```

Other than the host, none of these settings are mandatory.

###setAppVersion

If you tag your app releases with version numbers, Bugsnag can display these
on your dashboard if you call `setAppVersion`:

```php
$bugsnag->setAppVersion('1.2.3');
```

###setSendEnvironment

Bugsnag can transmit your `$_ENV` environment to help diagnose issues. This can
contain private/sensitive information, so we do not transmit this by default. To
send your environment, you can call `setSendEnvironment`:

```php
$bugsnag->setSendEnvironment(true);
```

###setSendCode

Bugsnag automatically sends a small snippet of the code that crashed to help
you diagnose even faster from within your dashboard. If you don't want to send
this snippet, you can call `setSendCode`:

```php
$bugsnag->setSendCode(false);
```

###setGroupingHash

Sets the grouping hash of the error report. All errors with the same grouping hash are grouped together. This is an advanced usage of the library and mis-using it will cause your errors not to group properly in your dashboard.

```php
$error->setGroupingHash($exception->message . $exception->class);
```

PHP Frameworks
--------------

### Laravel

Check out the [bugsnag-laravel](https://github.com/bugsnag/bugsnag-laravel) plugin.

### WordPress

Check out the [WordPress Error Monitoring by Bugsnag](http://wordpress.org/plugins/bugsnag/) plugin.

### CakePHP

Check out the third-party [Label305/bugsnag-cakephp](https://github.com/Label305/bugsnag-cakephp) plugin.

### Magento

Check out the official [Bugsnag Magento Extension](http://www.magentocommerce.com/magento-connect/bugsnag-notifier.html).

### Symfony2

Check out the third-party [evolution7/Evolution7BugsnagBundle](https://github.com/evolution7/Evolution7BugsnagBundle) or [wrep/bugsnag-php-symfony](https://github.com/wrep/bugsnag-php-symfony) bundles.

### Monolog
Check out the 3rd party log handler for monolog: [meadsteve/MonoSnag/](https://github.com/meadsteve/MonoSnag/)

### Silverstripe

Check out the third-party [evolution7/silverstripe-bugsnag-logger](https://github.com/evolution7/silverstripe-bugsnag-logger) plugin.

### Zend Framework 2

Check out the third-party [nickurt/bugsnag-php](https://github.com/nickurt/zf-bugsnag) plugin.


Building a Phar from Source
---------------------------

-   Install the composer dependencies

    ```shell
    $ composer install
    ```

-   Build the phar using `pharbuilder.php`. You may need to set `phar.readonly = Off` in your `php.ini`.

    ```shell
    php pharbuilder.php
    ```

A new `bugsnag.phar` will be generated in the `build` folder.


Reporting Bugs or Feature Requests
----------------------------------

Please report any bugs or feature requests on the github issues page for this
project here:

<https://github.com/bugsnag/bugsnag-php/issues>


Contributing
------------

-   [Fork](https://help.github.com/articles/fork-a-repo) the [notifier on github](https://github.com/bugsnag/bugsnag-php)
-   Commit and push until you are happy with your contribution
-   Run the tests to make sure they all pass: `composer install && vendor/bin/phpunit`
-   [Make a pull request](https://help.github.com/articles/using-pull-requests)
-   Thanks!


License
-------

The Bugsnag PHP notifier is free software released under the MIT License.
See [LICENSE.txt](https://github.com/bugsnag/bugsnag-php/blob/master/LICENSE.txt) for details.
