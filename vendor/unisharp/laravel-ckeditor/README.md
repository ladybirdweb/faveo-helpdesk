CKEditor Package
=====================

## Note

**This is NOT the official CKEDITOR package.**

[CKEDITOR officially has its own composer package since 2014](https://ckeditor.com/blog/CKEditor-Supports-Bower-and-Composer/). Instead of using this package, we recommend you follow [the official CKEditor installation instructions with package managers](https://docs.ckeditor.com/ckeditor4/latest/guide/dev_package_managers.html#composer)

## Installation
### Set up package

```
composer require unisharp/laravel-ckeditor
```

### Add ServiceProvider

For Laravel 5.5+ you can skip this step. 

For Laravel 5.4 and earlier edit config/app.php, add the following file to `Application Service Providers` section.
```
Unisharp\Ckeditor\ServiceProvider::class,
```
### Publish the resources
```
php artisan vendor:publish --tag=ckeditor
```
## Usage

Default way (initiate by name or id) :

```javascript
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
```

Or if you want to initiate by jQuery selector :

```javascript
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
    <script>
        $('textarea').ckeditor();
        // $('.textarea').ckeditor(); // if class is prefered.
    </script>
```

## File Uploader Integration

 Instead of using KCFinder, we recommend [laravel-filemanager](https://github.com/UniSharp/laravel-filemanager) for the file uploader integration for better laravel user access control and specific per user folders.
