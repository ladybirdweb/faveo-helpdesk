URL shortener library
=====================

This library allows you to shorten a URL, reverse is also possible.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c4e06c9d-547c-47bb-8abb-fccc68b7df7a/big.png)](https://insight.sensiolabs.com/projects/c4e06c9d-547c-47bb-8abb-fccc68b7df7a)

[![Build Status](https://api.travis-ci.com/mremi/UrlShortener.png?branch=master)](https://travis-ci.org/mremi/UrlShortener)
[![Total Downloads](https://poser.pugx.org/mremi/url-shortener/downloads.png)](https://packagist.org/packages/mremi/url-shortener)
[![Latest Stable Version](https://poser.pugx.org/mremi/url-shortener/v/stable.png)](https://packagist.org/packages/mremi/url-shortener)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/mremi/UrlShortener/badges/quality-score.png?s=34c4ba6b0cd272673fa121c32a63e1ce668b9b2a)](https://scrutinizer-ci.com/g/mremi/UrlShortener/)
[![Code Coverage](https://scrutinizer-ci.com/g/mremi/UrlShortener/badges/coverage.png?s=7a8c3388ae7b50f35fd548b4b7874526c634e8c5)](https://scrutinizer-ci.com/g/mremi/UrlShortener/)

**Basic Docs**

* [Installation](#installation)
* [Baidu API](#baidu-api)
* [Bit.ly API](#bitly-api)
* [Google API](#google-api)
* [Sina API](#sina-api)
* [Wechat API](#wechat-api)
* [Chain providers](#chain-providers)
* [Retrieve link](#retrieve-link)
* [Contribution](#contribution)

<a name="installation"></a>

## Installation

The preferred method of installation is via [Composer](https://getcomposer.org/). Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require mremi/url-shortener
```

<a name="baidu-api"></a>

## Baidu API

### Shorten

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Baidu\BaiduProvider;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$baiduProvider = new BaiduProvider(
    ['connect_timeout' => 1, 'timeout' => 1]
);

$baiduProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener baidu:shorten --help
```

```bash
$ bin/shortener baidu:shorten http://www.google.com
```

Some options are available:

```bash
$ bin/shortener baidu:shorten http://www.google.com --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Baidu\BaiduProvider;

$link = new Link;
$link->setShortUrl('http://dwz.cn/dDlVEAt5');

$googleProvider = new BaiduProvider(
    ['connect_timeout' => 1, 'timeout' => 1]
);

$googleProvider->expand($link);
```

```bash
$ bin/shortener baidu:expand --help
```

```bash
$ bin/shortener baidu:expand http://dwz.cn/dDlVEAt5
```

Some options are available:

```bash
$ bin/shortener baidu:expand http://dwz.cn/dDlVEAt5 --options='{"connect_timeout":1,"timeout":1}'
```

<a name="bitly-api"></a>

## Bit.ly API V4

### Shorten

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Bitly\BitlyProvider;
use Mremi\UrlShortener\Provider\Bitly\OAuthClient;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$bitlyProvider = new BitlyProvider(
    new GenericAccessTokenAuthenticator('generic_access_token'), // or old OAuthClient('username', 'password')
    ['connect_timeout' => 1, 'timeout' => 1]
);

$bitlyProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener bitly:shorten --help
```

Some arguments are mandatory:

```bash
$ bin/shortener bitly:shorten username password http://www.google.com
```

Some options are available:

```bash
$ bin/shortener bitly:shorten username password http://www.google.com --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Bitly\BitlyProvider;
use Mremi\UrlShortener\Provider\Bitly\OAuthClient;

$link = new Link;
$link->setShortUrl('http://goo.gl/fbsS');

$bitlyProvider = new BitlyProvider(
    new GenericAccessTokenAuthenticator('generic_access_token'), // or old OAuthClient('username', 'password')
    ['connect_timeout' => 1, 'timeout' => 1]
);

$bitlyProvider->expand($link);
```

```bash
$ bin/shortener bitly:expand --help
```

Some arguments are mandatory:

```bash
$ bin/shortener bitly:expand username password http://bit.ly/ze6poY
```

Some options are available:

```bash
$ bin/shortener bitly:expand username password http://bit.ly/ze6poY --options='{"connect_timeout":1,"timeout":1}'
```

<a name="google-api"></a>

## Google API

### Shorten

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Google\GoogleProvider;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$googleProvider = new GoogleProvider(
    'api_key',
    ['connect_timeout' => 1, 'timeout' => 1]
);

$googleProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener google:shorten --help
```

Only one argument is mandatory (the long URL) but you can also provide a Google
API key:

```bash
$ bin/shortener google:shorten http://www.google.com
```

```bash
$ bin/shortener google:shorten http://www.google.com api_key
```

Some options are available:

```bash
$ bin/shortener google:shorten http://www.google.com --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Google\GoogleProvider;

$link = new Link;
$link->setShortUrl('http://goo.gl/fbsS');

$googleProvider = new GoogleProvider(
    'api_key',
    ['connect_timeout' => 1, 'timeout' => 1]
);

$googleProvider->expand($link);
```

```bash
$ bin/shortener google:expand --help
```

Only one argument is mandatory (the short URL) but you can also provide a
Google API key:

```bash
$ bin/shortener google:expand http://goo.gl/fbsS
```

```bash
$ bin/shortener google:expand http://goo.gl/fbsS api_key
```

Some options are available:

```bash
$ bin/shortener google:expand http://goo.gl/fbsS --options='{"connect_timeout":1,"timeout":1}'
```

<a name="sina-api"></a>

## Sina API

### Shorten

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Sina\SinaProvider;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$sinaProvider = new SinaProvider(
    'api_key',
    ['connect_timeout' => 1, 'timeout' => 1]
);

$sinaProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener sina:shorten --help
```

```bash
$ bin/shortener sina:shorten http://www.google.com api_key
```

Some options are available:

```bash
$ bin/shortener sina:shorten http://www.google.com api_key --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Sina\SinaProvider;

$link = new Link;
$link->setShortUrl('http://t.cn/h51yw');

$sinaProvider = new SinaProvider(
    'api_key',
    ['connect_timeout' => 1, 'timeout' => 1]
);

$googleProvider->expand($link);
```

```bash
$ bin/shortener sina:expand --help
```

```bash
$ bin/shortener sina:expand http://t.cn/h51yw api_key
```

Some options are available:

```bash
$ bin/shortener sina:expand http://t.cn/h51yw api_key --options='{"connect_timeout":1,"timeout":1}'
```

<a name="wechat-api"></a>

## Wechat API

### Shorten

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\Wechat\WechatProvider;
use Mremi\UrlShortener\Provider\Wechat\OAuthClient;

$link = new Link;
$link->setLongUrl('http://www.google.com');

$wechatProvider = new WechatProvider(
    new OAuthClient('username', 'password'),
    ['connect_timeout' => 1, 'timeout' => 1]
);

$wechatProvider->shorten($link);
```

You can also use the commands provided by this library, look at the help message:

```bash
$ bin/shortener wechat:shorten --help
```

Some arguments are mandatory:

```bash
$ bin/shortener wechat:shorten appid secret http://www.google.com
```

Some options are available:

```bash
$ bin/shortener wechat:shorten appid secret http://www.google.com --options='{"connect_timeout":1,"timeout":1}'
```

### Expand

Wechat does not support expand url yet.

<a name="chain-providers"></a>

## Chain providers

```php
<?php

use Mremi\UrlShortener\Model\Link;
use Mremi\UrlShortener\Provider\ChainProvider;

$chainProvider = new ChainProvider;
$chainProvider->addProvider($bitlyProvider);
$chainProvider->addProvider($googleProvider);
// add yours...

$link = new Link;
$link->setLongUrl('http://www.google.com');

$chainProvider->getProvider('bitly')->shorten($link);

$chainProvider->getProvider('google')->expand($link);
```

<a name="retrieve-link"></a>

## Retrieve link

You can retrieve some links using these finders:

```php
<?php

use Mremi\UrlShortener\Model\LinkManager;

$linkManager = new LinkManager($chainProvider);

$shortened = $linkManager->findOneByProviderAndShortUrl('bitly', 'http://bit.ly/ze6poY');

$expanded = $linkManager->findOneByProviderAndLongUrl('google', 'http://www.google.com');
```

<a name="contribution"></a>

## Contribution

Any question or feedback? Open an issue and I will try to reply quickly.

A feature is missing here? Feel free to create a pull request to solve it!

I hope this has been useful and has helped you. If so, share it and recommend
it! :)

[@mremitsme](https://twitter.com/mremitsme)
