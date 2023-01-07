PHP Console Highlighter
=======================

Highlight PHP code in console (terminal).

Example
-------
![Example](http://jakubonderka.github.io/php-console-highlight-example.png)

Install
-------

Just run the following command to install it:

    composer require --dev php-parallel-lint/php-console-highlighter:"0.*"

Usage
-------
```php
<?php
use JakubOnderka\PhpConsoleColor\ConsoleColor;
use JakubOnderka\PhpConsoleHighlighter\Highlighter;

require __DIR__ . '/vendor/autoload.php';

$highlighter = new Highlighter(new ConsoleColor());

$fileContent = file_get_contents(__FILE__);
echo $highlighter->getWholeFile($fileContent);
```

------

[![Downloads this Month](https://img.shields.io/packagist/dm/php-parallel-lint/php-console-highlighter.svg)](https://packagist.org/packages/php-parallel-lint/php-console-highlighter)
[![Build Status](https://travis-ci.org/php-parallel-lint/PHP-Console-Highlighter.svg?branch=master)](https://travis-ci.org/php-parallel-lint/PHP-Console-Highlighter)
[![License](https://poser.pugx.org/php-parallel-lint/php-console-highlighter/license.svg)](https://packagist.org/packages/php-parallel-lint/php-console-highlighter)
