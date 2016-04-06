# Laravel-5-breadcrumbs-bundle
A simple solution for breadcrumbs in Laravel 5+

Edit the .json
============

Edit your .json file and add the following line to your "require"

``"mjanssen/laravel-5-breadcrumbs": "dev-master"``

After this run the `composer update` to update your framework and get the breadcrumb class loaded into your files.
The files will be placed in the `vendor/mjanssen/laravel-5-breadcrumbs` folder.

After the files will be downloaded and stored in your Vendor folder, the class needs to be autoloaded by Composer.
To do this, edit your own composer.json file to match it like this:

```
"psr-4": {
  "App\\": "app/",
    "mjanssen\\BreadcrumbsBundle\\": "vendor/mjanssen/laravel-5-breadcrumbs/src"
  }
```

After you updated the composer.json reload the composer autoload file.

``composer dump-autoload``

The class can now be used within the framework. Make sure you **use** it in *controllers* for example.

``use mjanssen\BreadcrumbsBundle\Breadcrumbs;``

Usage
======

As my first breadcrumb bundle (https://github.com/mjanssen/Laravel-4-breadcrumb) needed some attention (automatic generating, updated config file etc...).
This breadcrumb bundle is optimized for Laravel 5.

At first, the Breadcrumbs will be empty. To add breadcrumbs, use the *addBreadcrumb()* function

```
// Three breadcrumbs will be stored
Breadcrumbs::addBreadcrumb('Home', '/');
Breadcrumbs::addBreadcrumb('Second crumb', '/second-page');
Breadcrumbs::addBreadcrumb('Third crumb', '/second-page/third-page');
```

To generate the breadcrumb HTML, you can use the *generate()* function.
```
// Will return the html for the three previous set breadcrumbs.
Breadcrumbs::generate();
```

Additional methods
--------------

For an easy way of generating breadcrumbs, the bundle also provides an *automatic()* function. This function will retreive the
segments from the current url, and builds the breadcrumbs around them. *Breadcrumb::generate()* is not needed, since the
*automatic()* function will build the breadcrumbs, and returns the HTML for the breadcrumbs.

``Breadcrumbs::automatic();``

Example global usage
--------------

If you are interested to make use of the breadcrumbs globally, you can use the view composer function to make this happen.

Create a view called ``breadcrumbs.blade.php``

Inside the ``AppServiceProvider`` create a function called *composer()*, and call it from the already existing *boot()* function.
Inside the *composer()* function you can set composers for views. We will compose the breadcrumbs view.

```
View::composer('components.breadcrumbs', function() {

	$data = [
		'global_breadcrumbs' => Breadcrumbs::automatic()
	];

	view()->share($data);
});
```

Inside the ``breadcrumbs.blade.php`` file, you are now able to use the ``{!! $global_breadcrumbs !!}`` var.
Include the view from a ``master.blade.php`` file (or whatever your layout file is called). This can be done with ``@include``

``@include(components/breadcrumbs) // Assuming you placed the breadcrumbs.blade.php file in a components folder``

The breadcrumbs will now show up on every page where your layout is used.

Options
======

```
uppercaseFirst
useSeparator
bootstrapSeparator
separator
lastBreadcrumbClickable
automaticFirstCrumb
ulLiClass
bootstrap
except
```

Additionally you can use a config file to edit some features, for example the separator. To do this, create a php file in the
``/config`` folder called: ``breadcrumbs.php``. The source files of this Repo, there will be an example config file which
includes all the available options + information about them.

Config file can be found at: https://github.com/mjanssen/Laravel-5-breadcrumbs-bundle/blob/master/config_file_breadcrumbs.php
