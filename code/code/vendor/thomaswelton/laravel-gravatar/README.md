[![Build Status](https://travis-ci.org/thomaswelton/laravel-gravatar.png?branch=master)](https://travis-ci.org/thomaswelton/laravel-gravatar)
[![Latest Stable Version](https://poser.pugx.org/thomaswelton/laravel-gravatar/v/stable.png)](https://packagist.org/packages/thomaswelton/laravel-gravatar)
[![Total Downloads](https://poser.pugx.org/thomaswelton/laravel-gravatar/downloads.png)](https://packagist.org/packages/thomaswelton/laravel-gravatar)
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/thomaswelton/laravel-gravatar/trend.png)](https://bitdeli.com/free "Bitdeli Badge")


## Installation

Update your `composer.json` file to include this package as a dependency
```json
"thomaswelton/laravel-gravatar": "~1.0"
```

Register the Gravatar service provider by adding it to the providers array in the `config/app.php` file.
```
Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider
```

Alias the Gravatar facade by adding it to the aliases array in the `config/app.php` file.
```php
'aliases' => array(
	'Gravatar' => 'Thomaswelton\LaravelGravatar\Facades\Gravatar'
)
```

## Configuration - Optional

Copy the config file into your project by running
```
php artisan vendor:publish
```

### Default Image

Update the config file to specify the default avatar size to use and a default image to be return if no Gravatar is found.

Allowed defaults:
- (bool)   `false`
- (string) `404`
- (string) `mm`: (mystery-man) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash).
- (string) `identicon`: a geometric pattern based on an email hash.
- (string) `monsterid`: a generated 'monster' with different colors, faces, etc.
- (string) `wavatar`: generated faces with differing features and backgrounds.
- (string) `retro`: awesome generated, 8-bit arcade-style pixelated faces.

Example images can be viewed on [the Gravatar website](https://gravatar.com/site/implement/images/).

### Content Ratings

By default only "G" rated images will be shown. You can change this system wide in the config file by editing `'maxRating' => 'g'` allowed values are
- `g`: suitable for display on all websites with any audience type.
- `pg`: may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
- `r`: may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
- `x`: may contain hardcore sexual imagery or extremely disturbing violence.

The content rating can be changed by changing the `$rating` argument when calling `Gravatar::src` or `Gravatar::image`.


## Usage

### Gravatar::exists($email)
Returns a boolean telling if the given `$email` has got a Gravatar.

### Gravatar::src($email, $size = null, $rating = null)

Returns the https URL for the Gravatar of the email address specified.
Can optionally pass in the size required as an integer. The size will be contained within a range between 1 - 512 as gravatar will no return sizes greater than 512 of less than 1

```html
<!-- Show image with default dimensions -->
<img src="{{ Gravatar::src('thomaswelton@me.com') }}">

<!-- Show image at 200px -->
<img src="{{ Gravatar::src('thomaswelton@me.com', 200) }}">

<!-- Show image at 512px scaled in HTML to 1024px -->
<img src="{{ Gravatar::src('thomaswelton@me.com', 1024) }}" width=1024>
```

### Gravatar::image($email, $alt = null, $attributes = array(), $rating = null)

Returns the HTML for an `<img>` tag

```php
// Show image with default dimensions
echo Gravatar::image('thomaswelton@me.com');

// Show image at 200px
echo Gravatar::image('thomaswelton@me.com', 'Some picture', array('width' => 200, 'height' => 200));

// Show image at 512px scaled in HTML to 1024px
echo Gravatar::image('thomaswelton@me.com', 'Some picture', array('width' => 1024, 'height' => 1024));
```
