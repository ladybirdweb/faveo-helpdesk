# GravatarLib

GravatarLib is a small library intended to provide easy integration of gravatar-provided avatars.

## copyright

(c) 2011 emberlabs.org

## license

This library is licensed under the MIT license; you can find a full copy of the license itself in the file /LICENSE

## requirements

* PHP 5.3.0 or newer
* hash() function must be available, along with the md5 algorithm

## usage

We'll assume you're using this git repository as a git submodule, and have it located at `includes/emberlabs/GravatarLib/` according to namespacing rules, for easy autoloading.

### general example

``` php
	<?php
	include __DIR__ . '/includes/emberlabs/GravatarLib/Gravatar.php';
    $gravatar = new \emberlabs\GravatarLib\Gravatar();
	// example: setting default image and maximum size
	$gravatar->setDefaultImage('mm')
		->setAvatarSize(150);
	// example: setting maximum allowed avatar rating
	$gravatar->setMaxRating('pg');
	$avatar = $gravatar->buildGravatarURL('someemail@domain.com');
```

### setting the default image

Gravatar provides several pre-fabricated default images for use when the email address provided does not have a gravatar or when the gravatar specified exceeds your maximum allowed content rating.
The provided images are 'mm', 'identicon', 'monsterid', 'retro', and 'wavatar'.  To set the default iamge to use on your site, use the method `\emberlabs\GravatarLib\Gravatar->setDefaultImage()`
In addition, you can also set your own default image to be used by providing a valid URL to the image you wish to use.

Here are a couple of examples...

``` php
	$gravatar->setDefaultImage('wavatar');
```

``` php
	$gravatar->setDefaultImage('http://yoursitehere.com/path/to/image.png');
```



#### WARNING
If an invalid default image is specified (both an invalid prefab default image and an invalid URL is provided), this method will throw an exception of class `\InvalidArgumentException`.

### setting avatar size

Gravatar allows avatar images ranging from 1px to 512px in size -- and you, the developer or site administrator can specify the exact size of avatar that you want.
By default, the avatar size provided is 80px.  To set the avatar size for use on your site, use the method `\emberlabs\GravatarLib\Gravatar->setAvatarSize()`, and specify the avatar size with an integer representing the size in pixels.

An example of setting the avatar size is provided below:

``` php
	$gravatar->setAvatarSize(184);
```



#### WARNING
If an invalid size (less than 1, greater than 512) or a non-integer value is specified, this method will throw an exception of class `\InvalidArgumentException`.

### setting the maximum content rating

Gravatar provides four levels for rating avatars by, which are named similar to entertainment media ratings scales used in the United States.  They are, by order of severity (first is safe for everyone to see, last is explicit), "g", "pg", "r", and "x".
By default, the maximum content rating is set to "g".  You can set the maximum allowable rating on avatars embedded within your site by using the method `\emberlabs\GravatarLib\Gravatar->setMaxRating()`.  Please note that any avatars that do not fall under your maximum content rating will be replaced with the default image you have specified.

Here's an example of how to set the maximum content rating:

``` php
	$gravatar->setMaxRating('r');
```



#### WARNING
If an invalid maximum rating is specified, this method will throw an exception of class `\InvalidArgumentException`.

### enabling secure images

If your site is served over HTTPS, you'll likely want to serve gravatars over HTTPS as well to avoid "mixed content warnings".
To enable "secure images" mode, call the method `\emberlabs\GravatarLib\Gravatar->enableSecureImages()` before generating any gravatar URLs.
To check to see if you are using "secure images" mode, call the method `\emberlabs\GravatarLib\Gravatar->usingSecureImages()`, which will return a boolean value regarding whether or not secure images mode is enabled.

### twig integration

It's extremely easy to hook this library up as a template asset to the [Twig template engine](http://www.twig-project.org/).

When you've got an instance of the Twig_Environment ready, add in your instantiated gravatar object as a twig "global" like so:

``` php
	<?php
	// include the lib file here, or use an autoloader if you wish
	include __DIR__ . '/includes/emberlabs/GravatarLib/Gravatar.php';
	// instantiate the gravatar library object
    $gravatar = new \emberlabs\GravatarLib\Gravatar();

	// ... do whatever you want with your settings here

	// here, we will assume $twig is an already-created instance of Twig_Environment
	$twig->addGlobal('gravatar', $gravatar);
```

Now in your twig templates, you can get a user's gravatar with something like this snip of code:

(note: this template snip assumes that the "email" template variable contains the email of the user to grab the gravatar for)

```
	<img src="User avatar" src="{{ gravatar.get(email)|raw }}" />
```

We are also using the raw filter here to preserve XHTML 1.0 Strict compliance; the generated gravatar URL contains the `&amp;` character, and if the filter was not used it would be double-escaped.
