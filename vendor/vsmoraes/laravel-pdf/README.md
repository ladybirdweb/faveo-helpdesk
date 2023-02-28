# pdf-laravel5

DOMPDF module for Laravel 5. Export your views as PDFs - with css support.

[![Build Status](https://api.travis-ci.org/vsmoraes/pdf-laravel5.svg)](https://travis-ci.org/vsmoraes/pdf-laravel5) [![Latest Stable Version](https://poser.pugx.org/vsmoraes/laravel-pdf/v/stable)](https://packagist.org/packages/vsmoraes/laravel-pdf) [![Total Downloads](https://poser.pugx.org/vsmoraes/laravel-pdf/downloads)](https://packagist.org/packages/vsmoraes/laravel-pdf) [![Latest Unstable Version](https://poser.pugx.org/vsmoraes/laravel-pdf/v/unstable)](https://packagist.org/packages/vsmoraes/laravel-pdf) [![License](https://poser.pugx.org/vsmoraes/laravel-pdf/license)](https://packagist.org/packages/vsmoraes/laravel-pdf)

## Instalation
Add:
```
"vsmoraes/laravel-pdf": "^2.0"
```
To your `composer.json`

or Run:
```
composer require vsmoraes/laravel-pdf
```

Then add:
```php
Vsmoraes\Pdf\PdfServiceProvider::class
```
To the `providers` array on your `config/app.php`

And

```php
'PDF' => 'Vsmoraes\Pdf\PdfFacade',
```
To the `aliases` array on yout `config/app.php` in order to enable the PDF facade

## Usage

```php
Route::get('/pdf/view', function() {
    $html = view('pdfs.example')->render();

    return PDF::load($html)->show();
});
```

### Force download
```php
Route::get('/pdf/download', function() {
    $html = view('pdfs.example')->render();

    return PDF::load($html)->download();
});
```

### Return PDF as string
```php
Route::get('/pdf/output', function() {
    $html = view('pdfs.example')->render();

    return PDF::load($html)
        ->output();
});
```

### Set paper size and orientation
```php
    Route::get('/pdf/output', function() {
        $html = view('pdfs.example')->render();
    
        return PDF::load($html, 'A4', 'landscape')
            ->output();
    });
```

### Output to a file
```php
Route::get('/pdf/output', function() {
    $html = view('pdfs.example')->render();

    PDF::load($html)
        ->filename('/tmp/example1.pdf')
        ->output();

    return 'PDF saved';
});
```

### Inject on your controller
```php
<?php namespace App\Http\Controllers;

use Vsmoraes\Pdf\Pdf;

class HomeController extends BaseControler
{
    private $pdf;

    public function __construct(Pdf $pdf)
    {
        $this->pdf = $pdf;
    }

    public function helloWorld()
    {
        $html = view('pdfs.example1')->render();

        return $this->pdf
            ->load($html)
            ->show();
    }
}
```

## Configuration
Dompdf allows you to configure a bunch of things on your PDF file. In previous versions we used to accomplish this through environment vars, now you can change this configuration keys on the fly:

```php
Route::get('/pdf/view', function() {
    $html = view('pdfs.example')->render();
    
    $defaultOptions = PDF::getOptions();
    $defaultOptions->setDefaultFont('Courier');
    
    return PDF::setOptions($defaultOptions)->load($html)->download();
});
```

For the complete configuration reference: [Dompdf options](https://github.com/dompdf/dompdf/blob/master/src/Options.php)
