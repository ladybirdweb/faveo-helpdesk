# Note

This is a very early stage package that aims to become a successor of [chumper/zipper](https://github.com/Chumper/Zipper) package.
It started as a fork because we needed Laravel 6.0 compatibility. I will try to make it compatible with Laravel 6 and up.

# Madzipper

This is a simple Wrapper around the ZipArchive methods with some handy functions.

[![Build Status](https://travis-ci.com/madnest/madzipper.svg?branch=master)](https://travis-ci.com/madnest/madzipper)

## Installation

1. For Laravel 6: `"madnest/madzipper": "1.0.x"` run `composer require madnest/madzipper`

2. Optionally go to `app/config/app.php`

  * add to providers `Madnest\Madzipper\MadzipperServiceProvider::class`
  * add to aliases `'Madzipper' => Madnest\Madzipper\Madzipper::class`

You can now access Madzipper with the `Madzipper` alias.

## Simple example
```php
$files = glob('public/files/*');
Madzipper::make('public/test.zip')->add($files)->close();
```
- by default the package will create the `test.zip` in the project route folder but in the example above we changed it to `project_route/public/`.

## Another example
```php
$zipper = new \Madnest\Madzipper\Madzipper;

$zipper->make('test.zip')->folder('test')->add('composer.json');
$zipper->zip('test.zip')->folder('test')->add('composer.json','test');

$zipper->remove('composer.lock');

$zipper->folder('mySuperPackage')->add(
    array(
        'vendor',
        'composer.json'
    ),
);

$zipper->getFileContent('mySuperPackage/composer.json');

$zipper->make('test.zip')->extractTo('', ['mySuperPackage/composer.json'], Madzipper::WHITELIST);

$zipper->close();
```

Note: Please be aware that you need to call `->close()` at the end to write the zip file to disk.

You can easily chain most functions, except `getFileContent`, `getStatus`, `close` and `extractTo` which must come at the end of the chain.

The main reason I wrote this little package is the `extractTo` method since it allows you to be very flexible when extracting zips. So you can for example implement an update method which will just override the changed files.


# Functions

## make($pathToFile)

`Create` or `Open` a zip archive; if the file does not exists it will create a new one.
It will return the Zipper instance so you can chain easily.


## add($files/folder)

You can add an array of Files, or a Folder and all the files in that folder will then be added, so from the first example we could instead do something like `$files = 'public/files/';`.


## addString($filename, $content)

add a single file to the zip by specifying a name and the content as strings.


## remove($file/s)

removes a single file or an array of files from the zip.


## folder($folder)

Specify a folder to 'add files to' or 'remove files from' from the zip, example

```php
Madzipper::make('test.zip')->folder('test')->add('composer.json');
Madzipper::make('test.zip')->folder('test')->remove('composer.json');
```

## listFiles($regexFilter = null)

Lists all files within archive (if no filter pattern is provided). Use `$regexFilter` parameter to filter files. See [Pattern Syntax](http://php.net/manual/en/reference.pcre.pattern.syntax.php) for regular expression syntax

> NB: `listFiles` ignores folder set with `folder` function


Example: Return all files/folders ending/not ending with '.log' pattern (case insensitive). This will return matches in sub folders and their sub folders also

```php
$logFiles = Madzipper::make('test.zip')->listFiles('/\.log$/i');
$notLogFiles = Madzipper::make('test.zip')->listFiles('/^(?!.*\.log).*$/i');
```


## home()

Resets the folder pointer.

## zip($fileName)

Uses the ZipRepository for file handling.


## getFileContent($filePath)

get the content of a file in the zip. This will return the content or false.


## getStatus()

get the opening status of the zip as integer.


## close()

closes the zip and writes all changes.


## extractTo($path)

Extracts the content of the zip archive to the specified location, for example

```php
Madzipper::make('test.zip')->folder('test')->extractTo('foo');
```

This will go into the folder `test` in the zip file and extract the content of that folder only to the folder `foo`, this is equal to using the `Madzipper::WHITELIST`.

This command is really nice to get just a part of the zip file, you can also pass a 2nd & 3rd param to specify a single or an array of files that will be

> NB: Php ZipArchive uses internally '/' as directory separator for files/folders in zip. So Windows users should not set
> whitelist/blacklist patterns with '\' as it will not match anything

white listed

>**Madzipper::WHITELIST**

```php
Madzipper::make('test.zip')->extractTo('public', array('vendor'), Madzipper::WHITELIST);
```

Which will extract the `test.zip` into the `public` folder but **only** files/folders starting with `vendor` prefix inside the zip will be extracted.

or black listed

>**Madzipper::BLACKLIST**
Which will extract the `test.zip` into the `public` folder except files/folders starting with `vendor` prefix inside the zip will not be extracted.


```php
Madzipper::make('test.zip')->extractTo('public', array('vendor'), Madzipper::BLACKLIST);
```

>**Madzipper::EXACT_MATCH**

```php
Madzipper::make('test.zip')
    ->folder('vendor')
    ->extractTo('public', array('composer', 'bin/phpunit'), Madzipper::WHITELIST | Madzipper::EXACT_MATCH);
```

Which will extract the `test.zip` into the `public` folder but **only** files/folders **exact matching names**. So this will:
 * extract file or folder named `composer` in folder named `vendor` inside zip to `public` resulting `public/composer`
 * extract file or folder named `bin/phpunit` in `vendor/bin/phpunit` folder inside zip to `public` resulting `public/bin/phpunit`

> **NB:** extracting files/folder from zip without setting Madzipper::EXACT_MATCH
> When zip has similar structure as below and only `test.bat` is given as whitelist/blacklist argument then `extractTo` would extract all those files and folders as they all start with given string

```
test.zip
 |- test.bat
 |- test.bat.~
 |- test.bat.dir/
    |- fileInSubFolder.log
```

## extractMatchingRegex($path, $regex)

Extracts the content of the zip archive matching regular expression to the specified location. See [Pattern Syntax](http://php.net/manual/en/reference.pcre.pattern.syntax.php) for regular expression syntax.

Example: extract all files ending with `.php` from `src` folder and its sub folders.
```php
Madzipper::make('test.zip')->folder('src')->extractMatchingRegex($path, '/\.php$/i');
```

Example: extract all files **except** those ending with `test.php` from `src` folder and its sub folders.
```php
Madzipper::make('test.zip')->folder('src')->extractMatchingRegex($path, '/^(?!.*test\.php).*$/i');
```

# Development

Maybe it is a good idea to add other compression functions like rar, phar or bzip2 etc...
Everything is setup for that, if you want just fork and develop further.

If you need other functions or got errors, please leave an issue on github.
