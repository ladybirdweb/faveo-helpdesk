#!/bin/sh

set -e
set -x

if [ "hhvm" != $TRAVIS_PHP_VERSION ]
then
  export CFLAGS="-L$HOME/libmaxminddb/lib"
  export CPPFLAGS="-I$HOME/libmaxminddb/include"
  cd ext
  phpize
  ./configure --with-maxminddb --enable-maxminddb-debug
  make clean
  make
  NO_INTERACTION=1 make test
  cd ..
fi
