Contributing
============

-   [Fork](https://help.github.com/articles/fork-a-repo) the [notifier on github](https://github.com/bugsnag/bugsnag-laravel)
-   Build and test your changes. Run the tests using [phpunit](https://phpunit.de) (vendored to `vendor/bin/phpunit`)
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
2. Bump the version in `src/Bugsnag/Configuration.php`.
3. Update the CHANGELOG.md, and README if appropriate.
4. Build a new phar package
   * NB: You may need to set `phar.readonly = Off` in /usr/local/etc/php/5.4/php.ini
     * If not located in /usr/local/etc, check /private/etc/php.ini
     * If not in /private/etc/php.ini:

       ```
       sudo cp /private/etc/php.ini.default /private/etc/php.ini
       ```
   * Then:

    ```
    composer install
    php pharbuilder.php
    ```

5. Commit, tag push

    ```
    git commit -am v2.x.x
    git tag v2.x.x
    git push origin master && git push --tags
    ```
6. Update the setup guides for PHP (and its frameworks) with any new content.
