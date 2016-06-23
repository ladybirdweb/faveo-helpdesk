#!/bin/sh

set -e
set -x

mkdir -p build/logs
./vendor/bin/phpunit -c .coveralls-phpunit.xml.dist

if [ "hhvm" != "$TRAVIS_PHP_VERSION" ]
then
    echo "mbstring.internal_encoding=utf-8" >> ~/.phpenv/versions/"$(phpenv version-name)"/etc/php.ini
    echo "mbstring.func_overload = 7" >> ~/.phpenv/versions/"$(phpenv version-name)"/etc/php.ini
    ./vendor/bin/phpunit

    echo "extension = ext/modules/maxminddb.so" >> ~/.phpenv/versions/"$(phpenv version-name)"/etc/php.ini
    ./vendor/bin/phpunit
fi

./vendor/bin/phpcs --standard=PSR2 src/
