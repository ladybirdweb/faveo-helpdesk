#Zipper

[![Build Status](https://travis-ci.org/Chumper/Zipper.png)](https://travis-ci.org/Chumper/Zipper)

This is a simple Wrapper around the ZipArchive methods with some handy functions.

##Installation

1a- To install this package for laravel 5 just require it in your

`composer.json` with `"Chumper/Zipper": "0.6.0"`

1b- To install this package for laravel 4 just require it in your

`composer.json` with `"Chumper/Zipper": "0.5.1"`

2- goto `app/config/app.php`

.add to providers

    'Chumper\Zipper\ZipperServiceProvider'

.add to aliases

    'Zipper' => 'Chumper\Zipper\Zipper'

You can now access Zipper with the `Zipper` alias.

##Simple example
```php
$files = glob('public/files/*');
Zipper::make('public/test.zip')->add($files);
```
- by default the package will create the `test.zip` in the project route folder but in the example above we changed it to `project_route/public/`.

####Another example
```php
$zipper = new \Chumper\Zipper\Zipper;

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

$zipper->make('test.zip')->extractTo('',array('mySuperPackage/composer.json'),Zipper::WHITELIST);
```

- You can easily chain most functions, except `getFileContent`, `getStatus`, `close` and `extractTo` which must come at the end of the chaine.

The main reason i wrote this little package is the `extractTo` method since it allows you to be very flexible when extracting zips.
So you can for example implement an update method which will just override the changed files.


##Functions

**make($pathToFile)**

`Create` or `Open` a zip archive; if the file does not exists it will create a new one.
It will return the Zipper instance so you can chain easily.


**add($files/folder)**

You can add and array of Files, or a Folder which all the files in that folder will then be added, so from the first example we could instead do something like `$files = 'public/files/';`.


**addString($filename, $content)**

add a single file to the zip by specifying a name and content as strings.


**remove($file/s)**

removes a single file or an array of files from the zip.


**folder($folder)**

Specify a folder to 'add files to' or 'remove files from' from the zip, example

	Zipper::make('test.zip')->folder('test')->add('composer.json');
	Zipper::make('test.zip')->folder('test')->remove('composer.json');


**home()**

Resets the folder pointer.


**zip($fileName)**

Uses the ZipRepository for file handling.


**getFileContent($filePath)**

get the content of a file in the zip. This will return the content or false.


**getStatus()**

get the opening status of the zip as integer.


**close()**

closes the zip and writes all changes.


**extractTo($path)**

Extracts the content of the zip archive to the specified location, for example

    Zipper::make('test.zip')->folder('test')->extractTo('foo');

This will go into the folder `test` in the zip file and extract the content of that folder only to the folder `foo`, this is equal to using the `Zipper::WHITELIST`.

This command is really nice to get just a part of the zip file, you can also pass a 2nd & 3rd param to specify a single or an array of files that will be

white listed

>**Zipper::WHITELIST**
>
	Zipper::make('test.zip')->extractTo('public', array('vendor'), Zipper::WHITELIST);
Which will extract the `test.zip` into the `public` folder but **only** the folder `vendor` inside the zip will be extracted.

or black listed

>**Zipper::BLACKLIST**
>
	Zipper::make('test.zip')->extractTo('public', array('vendor'), Zipper::BLACKLIST);
Which will extract the `test.zip` into the `public` folder except the folder `vendor` inside the zip will not be extracted.



##Development

May it is a goot idea to add other compress functions like rar, phar or bzip2 etc...
Everything is setup for that, if you want just fork and develop further.

If you need other functions or got errors, please leave an issue on github.
