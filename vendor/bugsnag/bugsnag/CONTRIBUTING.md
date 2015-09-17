Contributing
============

-   [Fork](https://help.github.com/articles/fork-a-repo) the [notifier on github](https://github.com/bugsnag/bugsnag-laravel)
-   Build and test your changes
-   Commit and push until you are happy with your contribution
-   [Make a pull request](https://help.github.com/articles/using-pull-requests)
-   Thanks!

Example apps
============

Test the notifier by running the application locally.

[Install composer](http://getcomposer.org/doc/01-basic-usage.md), and then cd into `example/php` and start the server:

    composer install
    php index.php


Releasing
=========

1. Commit all outstanding changes
1. Bump the version in `src/Bugsnag/Configuration.php`.
2. Update the CHANGELOG.md, and README if appropriate.
3. Build a new phar package

    composer install
    php pharbuilder.php

4. Commit, tag push

    git commit -am v1.x.x
    git tag v1.x.x
    git push origin master v1.x.x
