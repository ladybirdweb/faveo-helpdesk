## Filemanager ##

This package is to add [simogeo/Filemanager](https://github.com/simogeo/Filemanager) to Laravel 5.1 installation.

### Installation ###

Add Filemanager to your composer.json file to require Filemanager :
```
    require : {
        "laravel/framework": "5.1.*",
        "bestmomo/filemanager": "1.1.*"
    }
```

Update Composer :
```
    composer update
```

The next required step is to add the service provider to config/app.php :
```
    Bestmomo\Filemanager\FilemanagerServiceProvider::class,
```

### Publish ###

The last required step is to publish assets in your application with :
```
    php artisan vendor:publish
```

### User model ###

For Filemanager php connector you must create at least this function in user model :

```
public function accessMediasAll()
{
    // return true for access to all medias
}
```

If you want some users access only to one folder add this function :

```
public function accessMediasFolder()
{
    // return true for access to one folder
}
```
A folder with user{id} name will be created in filemanager/userfiles folder.

### Integration ###

You can now integrate Filemanager with any editor.

Simple example integration with CKEditor :
```
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CKEditor</title>
        <script src="//cdn.ckeditor.com/4.5.3/standard/ckeditor.js"></script>
    </head>
    <body>
        <textarea name="editor"></textarea>
        <script>
            CKEDITOR.replace( 'editor', {
                filebrowserBrowseUrl: '{!! url('filemanager/index.html') !!}'
            });
        </script>
    </body>
</html>
```



