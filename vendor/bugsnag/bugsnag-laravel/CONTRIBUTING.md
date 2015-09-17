Contributing
============

-   [Fork](https://help.github.com/articles/fork-a-repo) the [notifier on github](https://github.com/bugsnag/bugsnag-laravel)
-   Build and test your changes
-   Commit and push until you are happy with your contribution
-   [Make a pull request](https://help.github.com/articles/using-pull-requests)
-   Thanks!

Example apps
============

Bugsnag supports both Laravel 4 and Laravel 5. You can test these out by running the locally.

    brew tap josegonzalez/homebrew-php
    brew install php56 php56-mcrypt composer

Then cd into `example/laravel-4` and start the server:

    composer install
    php56 artisan serve --port 8004

The same works for `example/laravel-5` and start the server:

    composer install
    php56 artisan serve --port 8005

Releasing
=========

1. Commit all outstanding changes
1. Bump the version in `src/Bugsnag/BugsnagLaravel/BugsnagLaravelServiceProvider.php` and `src/Bugsnag/BugsnagLaravel/BugsnagLumenServiceProvider.php`
2. Update the CHANGELOG.md, and README if appropriate.
3. Commit, tag push

    git commit -am v1.x.x
    git tag v1.x.x
    git push origin master v1.x.x

