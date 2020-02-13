# Fetch [![Build Status](https://travis-ci.org/tedious/Fetch.svg?branch=master)](https://travis-ci.org/tedious/Fetch)

[![License](http://img.shields.io/packagist/l/tedivm/fetch.svg)](https://github.com/tedious/fetch/blob/master/LICENSE)
[![Latest Stable Version](http://img.shields.io/github/release/tedious/fetch.svg)](https://packagist.org/packages/tedivm/fetch)
[![Coverage Status](http://img.shields.io/coveralls/tedious/Fetch.svg)](https://coveralls.io/r/tedious/Fetch?branch=master)
[![Total Downloads](http://img.shields.io/packagist/dt/tedivm/fetch.svg)](https://packagist.org/packages/tedivm/fetch)

Fetch is a library for reading email and attachments, primarily using the POP 
and IMAP protocols.


## Installing

### Composer

Installing Fetch can be done through a variety of methods, although Composer is
recommended.

Until Fetch reaches a stable API with version 1.0 it is recommended that you
review changes before even Minor updates, although bug fixes will always be
backwards compatible.

```
"require": {
  "tedivm/fetch": "0.5.*"
}
```

### Pear

Fetch is also available through Pear.

```
$ pear channel-discover pear.tedivm.com
$ pear install tedivm/Fetch
```

### Github

Releases of Fetch are available on [Github](https://github.com/tedious/Fetch/releases).


## Sample Usage

This is just a simple code to show how to access messages by using Fetch. It uses Fetch
own autoload, but it can (and should be, if applicable) replaced with the one generated
by composer.


    $server = new \Fetch\Server('imap.example.com', 993);
    $server->setAuthentication('dummy', 'dummy');


    $messages = $server->getMessages();
    /** @var $message \Fetch\Message */
    foreach ($messages as $message) {
        echo "Subject: {$message->getSubject()}\nBody: {$message->getMessageBody()}\n";
    }


## License

Fetch is licensed under the BSD License. See the LICENSE file for details.
