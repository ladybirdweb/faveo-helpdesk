Datatable
=========

## Important

> **This package will not receive any new updates!**
> You can still use this package, but be preparared that there is no active development for this project.
>
> This package is `abandoned` and not recommended for new projects. 
> We recommend to use instead [Yajra's Package](https://github.com/yajra/laravel-datatables) which offers a nearly-similar API.

## Introduction
This is a __Laravel 4 package__ for the server and client side of datatables at http://datatables.net/

> A __Laravel 5__ package is [close to being completed](https://github.com/Chumper/Datatable/tree/develop). To install it:
>
>         composer require chumper/datatable "dev-develop"
>
> If you find any issues, please report them in the bug tracker!

*Please Note*, if you want Datatable 1.10 support & Laravel 5 support, try out our newest branch!

If you upgrade from version 2.1.* or below please make sure you adjust your app.php with the new alias:

```php
    // aliases array:

    //old
    //'Datatable' => 'Chumper\Datatable\Facades\Datatable',

    //new
    'Datatable' => 'Chumper\Datatable\Facades\DatatableFacade',
```

## Known Issues

* none i know of so far

## TODO

* fix incoming bugs
* code documentaion

## Features

This package supports:

*   Support for Collections and Query Builder
*   Easy to add and order columns
*   Includes a simple helper for the HTML side
*   Use your own functions and presenters in your columns
*   Search in your custom defined columns ( Collection only!!! )
*   Define your specific fields for searching and ordering
*   Add custom javascript values for the table
*   Tested! (Ok, maybe not fully, but I did my best :) )

## Please note!

There are some differences between the collection part and the query part of this package.
The differences are:

|  Difference  | Collection | Query |
| ---          |:----------:| :----:|
|Speed         | -          | +     |
Custom fields | + | +
Search in custom fields | + | -
Order by custom fields | + | -
Search outside the shown data (e.g.) database | - | +

For a detailed explanation please see the video below.
http://www.youtube.com/watch?v=c9fao_5Jo3Y

Please let me know any issues or features you want to have in the issues section.
I would be really thankful if you can provide a test that points to the issue.

## Installation

This package is available on http://packagist.org, just add it to your composer.json

	"chumper/datatable": "2.*"

Alternatively, you can install it using the `composer` command:

        composer require chumper/datatable "2.*"

It also has a ServiceProvider for usage in Laravel4. Add these lines to app.php:

```php
    // providers array:
	'Chumper\Datatable\DatatableServiceProvider',

    // aliases array:
    'Datatable' => 'Chumper\Datatable\Facades\DatatableFacade',
```

You can then access it under the `Datatable` alias.

To override the default configuration options you can publish the config file.

    php artisan config:publish chumper/datatable

You may now edit these options at app/config/packages/chumper/datatable/config.php.


## Basic Usage

There are two ways you can use the plugin, within one route or within two routes:

### Two routes

* Create two routes: One to deliver the view to the user, the other for datatable data, eg:

```php
    Route::resource('users', 'UsersController');
    Route::get('api/users', array('as'=>'api.users', 'uses'=>'UsersController@getDatatable'));
```

* Your main route will deliver a view to the user. This view should include references to your local copy of [datatables](http://datatables.net/). In the example below, files were copied from the datatables/media directories and written to public/assets. Please note that the scripts must be located above the call to Datatable:

```php
    <link rel="stylesheet" type="text/css" href="/assets/css/jquery.dataTables.css">
    <script type="text/javascript" src="/assets/js/jquery.js"></script>
    <script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>

    {{ Datatable::table()
    ->addColumn('id','Name')       // these are the column headings to be shown
    ->setUrl(route('api.users'))   // this is the route where data will be retrieved
    ->render() }}
```

* Create a controller function to return your data in a way that can be read by Datatables:

```php
    public function getDatatable()
    {
        return Datatable::collection(User::all(array('id','name')))
        ->showColumns('id', 'name')
        ->searchColumns('name')
        ->orderColumns('id','name')
        ->make();
    }
```

You should now have a working datatable on your page.

### One route

In your route you should use the Datatable::shouldHandle method which will check whether the plugin should handle the request or not.

```php
    if(Datatable::shouldHandle())
    {
        return Datatable::collection(User::all(array('id','name')))
            ->showColumns('id', 'name')
            ->searchColumns('name')
            ->orderColumns('id','name')
            ->make();
    }
```

The plugin will then query the same url for information. The shouldHandle method just checks for an ajax request and if sEcho is set.

## HTML Example

```php
	Datatable::table()
    ->addColumn('id',Lang::get('user.lastname'))
	->setUrl(URL::to('auth/users/table'))
    ->render();
```

With seperate table and script:
```php
		$table = Datatable::table()
        ->addColumn('Email2','Email', "Test")
        ->noScript();

        // to render the table:
        $table->render()

        // later in the view you can render the javascript:
        $table->script();
```

This will generate a HTML table with two columns (id, lastname -> your translation) and will set the URL for the ajax request.

>   Note: This package will **NOT** include the `datatable.js`, that is your work to do.
>   The reason is that for example i use Basset and everybody wants to do it their way...

If you want to provide your own template for the table just provide the path to the view in laravel style.

```php
	Datatable::table()
        ->addColumn('id',Lang::get('user.lastname'))
    	->setUrl(URL::to('auth/users/table'))
        ->render('views.templates.datatable');
```
## Server Example

```php
	Datatable::collection(User::all())
    ->showColumns('id')
    ->addColumn('name',function($model)
        {
            return $model->getPresenter()->yourProperty;
        }
    )->make();
```

This will generate a server side datatable handler from the collection `User::all()`.
It will add the `id` column to the result and also a custom column called `name`.
Please note that we need to pass a function as a second parameter, it will **always** be called
with the object the collection holds. In this case it would be the `User` model.

You could now also access all relationship, so it would be easy for a book model to show the author relationship.

```php
	Datatable::collection(User::all())
    ->showColumns('id')
    ->addColumn('name',function($model)
        {
            return $model->author->name;
        }
    )->make();
```

>   Note: If you pass a collection of arrays to the `collection` method you will have an array in the function, not a model.

The order of the columns is always defined by the user and will be the same order the user adds the columns to the Datatable.

## Query or Collection?

There is a difference between query() and collection().
A collection will be compiled before any operation - like search or order - will be performed so that it can also include your custom fields.
This said the collection method is not as performing as the query method where the search and order will be tackled before we query the database.

So if you have a lot of Entries (100k+) a collection will not perform well because we need to compile the whole amount of entries to provide accurate sets.
A query on the other side is not able to perform a search or orderBy correctly on your custom field functions.

>   TLTR: If you have no custom fields, then use query() it will be much faster
>   If you have custom fields but don't want to provide search and/or order on the fields use query().
>   Collection is the choice if you have data from somewhere else, just wrap it into a collection and you are good to go.
>   If you have custom fields and want to provide search and/or order on these, you need to use a collection.

Please also note that there is a significant difference betweeen the search and order functionality if you use query compared to collections.
Please see the following video for more details.

http://www.youtube.com/watch?v=c9fao_5Jo3Y

## Available functions

This package is separated into two smaller parts:

1. Datatable::table()
2. Datatable::collection()
3. Datatable::query()

The second and third one is for the server side, the first one is a helper to generate the needed table and javascript calls.

### Collection & Query

**collection($collection)**

Will set the internal engine to the collection.
For further performance improvement you can limit the number of columns and rows, i.e.:

	$users = User::activeOnly()->get('id','name');
	Datatable::collection($users)->...

**query($query)**

This will set the internal engine to a Eloquent query...
E.g.:

	$users = DB::table('users');
	Datatable::query($users)->...

The query engine is much faster than the collection engine but also lacks some functionality,
for further information look at the table above.

**showColumns(...$columns)**

This will add the named columns to the result.
>   Note: You need to pass the name in the format you would access it on the model or array.
>   example: in the db: `last_name`, on the model `lastname` -> showColumns('lastname')

You can provide as many names as you like

**searchColumns(..$fields)**

Will enable the table to allow search only in the given columns.
Please note that a collection behaves different to a builder object.

Note: If you want to search on number columns with the query engine, then you can also pass a search column like this
 ```
    //mysql
    ->searchColumns(array('id:char:255', 'first_name', 'last_name', 'address', 'email', 'age:char:255'))

    //postgree
    ->searchColumns(array('id:text', 'first_name', 'last_name', 'address', 'email', 'age:text'))
 ```

 This will cast the columns int the given types when searching on this columns

**orderColumns(..$fields)**

Will enable the table to allow ordering only in the given columns.
Please note that a collection behaves different to a builder object.

**addColumn($name, $function)**

Will add a custom field to the result set, in the function you will get the whole model or array for that row
E.g.:
```php
	Datatable::collection(User::all())
    ->addColumn('name',function($model)
        {
            return $model->author->name;
        }
    )->make();
```
You can also just add a predefined Column, like a DateColumn, a FunctionColumn, or a TextColumn
E.g.:

```php
	$column = new \Chumper\Datatable\Columns\TextColumn('foo', 'bar'); // Will always return the text bar
	//$column = new \Chumper\Datatable\Columns\FunctionColumn('foo', function($model){return $model->bar}); // Will return the bar column
	//$column = new \Chumper\Datatable\Columns\DateColumn('foo', DateColumn::TIME); // Will return the foo date object as toTimeString() representation
	//$column = new \Chumper\Datatable\Columns\DateColumn('foo', DateColumn::CUSTOM, 'd.M.Y H:m:i'); // Will return the foo date object as custom representation

	Datatable::collection(User::all())
    ->addColumn($column)
    ->make();
```

You can also overwrite the results returned by the QueryMethod by using addColumn in combination with showColumns.
You must name the column exactly like the database column that you're displaying using showColumns in order for this to work.

```php
	$column = new \Chumper\Datatable\Columns\FunctionColumn('foo', function ($row) { return strtolower($row->foo); }
	Datatable::query(DB::table('table')->select(array('foo')))
	         ->showColumns('foo')
	         ->addColumn($column)
	         ->orderColumns('foo')
	         ->searchColumns('foo')
	         ->make()
```
This will allow you to have sortable and searchable columns using the QueryEngine while also allowing you to modify the return value of that database column entry.

Eg: linking an user_id column to it's page listing
```php
	$column = new \Chumper\Datatable\Columns\FunctionColumn('user_id', function ($row) { return link_to('users/'.$row->user_id, $row->username) }
	Datatable::query(DB::table('table')->select(array('user_id', 'username')))
	         ->showColumns('user_id')
	         ->addColumn($column)
	         ->orderColumns('user_id')
	         ->searchColumns('user_id')
```


Please look into the specific Columns for further information.

**setAliasMapping()**

Will advise the Datatable to return the data mapped with the column name.
So instead of
```javascript
	{
		"aaData":[
			[3,"name","2014-02-02 23:28:14"]
		],
		"sEcho":9,
		"iTotalRecords":2,
		"iTotalDisplayRecords":1
	}
```
you will get something like this as response
```javascript
{
	"aaData":[
		{"id":2,"name":"Datatable","created_at":"Sun, Feb 2, 2014 7:17 PM"}
	],
	"sEcho":2,
	"iTotalRecords":2,
	"iTotalDisplayRecords":1
}
```

**make()**

This will handle the input data of the request and provides the result set.
> Without this command no response will be returned.

**clearColumns()**

This will reset all columns, mainly used for testing and debugging, not really useful for you.
>   If you don't provide any column with `showColumn` or `addColumn` then no column will be shown.
>   The columns in the query or collection do not have any influence which column will be shown.

**getOrder()**

This will return an array with the columns that will be shown, mainly used for testing and debugging, not really useful for you.

**getColumn($name)**

Will get a column by its name, mainly used for testing and debugging, not really useful for you.

### Specific QueryEngine methods

**setSearchWithAlias()**

If you want to use an alias column on the query engine and you don't get the correct results back while searching then you should try this flag.
E.g.:
```php
		Datatable::from(DB::table("users")->select(array('firstname', "users.email as email2"))->join('partners','users.partner_id','=','partners.id'))
        ->showColumns('firstname','email2')
        ->setSearchWithAlias()
        ->searchColumns("email2")
```

In SQL it is not allowed to have an alias in the where part (used for searching) and therefore the results will not counted correctly.

With this flag you enable aliases in the search part (email2 in searchColumns).

Please be aware that this flag will slow down your application, since we are getting the results back twice to count them manually.

**setDistinctCountGroup($value = true)**

If you are using `GROUP BY`'s inside the query that you are passing into the Datatable, then you may receive incorrect
totals from your SQL engine. Setting setDistinctCountGroup (__which most likely only works on MySQL__) will ensure that
the totals are based on your GROUP BY.

**setSearchOperator($value = "LIKE")**

With this method you can set the operator on searches like "ILIKE" on PostgreSQL for case insensitivity.

**setExactWordSearch**

Will advice the engines only to search for the exact given search string.

### Specific CollectionEngine methods

**setSearchStrip() & setOrderStrip()**

If you use the search functionality then you can advice
all columns to strip any HTML and PHP tags before searching this column.

This can be useful if you return a link to the model detail but still want to provide search ability in this column.

**setCaseSensitive($boolean = 'false')**

Set the search method to case sensitive or not, default is false

### Table

**noScript()**

With setting this property the Table will not render the javascript part.

You can render it manually with

**script($view = null)**

Will render the javascript if no view is given or the default one and will pass the class name, the options and the callbacks.

Example:

```php
		$table = Datatable::table()
        ->addColumn('Email2','Email', "Test")
        ->noScript();

        // to render the table:
        $table->render()

        // later in the view you can render the javascript:
        $table->script();
```

**setUrl($url)**

Will set the URL and options for fetching the content via ajax.

**setOptions($name, $value) OR setOptions($array)**

Will set a single option or an array of options for the jquery call.

You can pass as paramater something like this ('MyOption', 'ValueMyOption') or an Array with parameters, but some values in DataTable is a JSON so how can i pass a JSON in values? Use another array, like that:
setOptions(array("MyOption"=> array('MyAnotherOption'=> 'MyAnotherValue', 'MyAnotherOption2'=> 'MyAnotherValue2')));

```js

//GENERATE

jQuery(.Myclass).DataTable({
    MyOption: {
        MyAnotherOption: MyAnotherValue,
        MyAnotherOption2: MyAnotherValue2,
    }
});
```

As a sugestion, take a look at this 2 files javascript.blade.php && template.blade.php in vendor/Chumper/datatable/src/views. You'll understand all the logic and see why it's important to pass the parameter like an array (json_encode and others stuffs).

**setCallbacks($name, $value) OR setCallbacks($array)**

Will set a single callback function or an array of callbacks for the jquery call. DataTables callback functions are described at https://datatables.net/usage/callbacks. For example,

```php
    ->setCallbacks(
        'fnServerParams', 'function ( aoData ) {
            aoData.push( { "name": "more_data", "value": "my_value" } );
        }'
    )

```

**addColumn($name)**

Will add a column to the table, where the name will be rendered on the table head.
So you can provide the string that should be shown.

if you want to use the alias mapping feature of the server side table then you need to add an array like this

```php
Datatable::table()
    ->addColumn(array(
        'id'            => 'ID',
        'name'          => 'Name',
        'created_at'    => 'Erstellt'
        ))
	->render();
```
Please note that passing an assosiative array to the addColumn function will automatically enable the alias function on the table

**setAliasMapping(boolean)**

Here you can explicitly set if the table should be aliased or not.

**countColumns()**

This will return the number of columns that will be rendered later. Mainly for testing and debugging.

**getData()**

Will return the data that will be rendered into the table as an array.

**getOptions()**

Get all options as an array.

**render($view = template.blade)**

Renders the table. You can customize this by passing a view name.
Please see the template inside the package for further information of how the data is passed to the view.

**setData($data)**

Expects an array of arrays and will render this data when the table is shown.

**setCustomValues($name, $value) OR setCustomValues($array)**

Will set a single custom value, or an array of custom values, which will be passed to the view. You can access these values in your custom view file. For example, if you wanted to click anywhere on a row to go to a record (where the record id is in the first column of the table):

In the calling view:

```php
{{ DataTable::table()
    ->addColumn($columns)
    ->setUrl($ajaxRouteToTableData)
    ->setCustomValues('table-url', $pathToTableDataLinks)
    ->render('my.datatable.template') }}
```

In the datatable view (eg, 'my.datatable.template'):

```js
    @if (isset($values['table-url']))
        $('.{{$class}}').hover(function() {
            $(this).css('cursor', 'pointer');
        });
        $('.{{$class}}').on('click', 'tbody tr', function(e) {
            $id = e.currentTarget.children[0].innerHTML;
            $url = e.currentTarget.baseURI;
            document.location.href = "{{ $values['table-url'] }}/" + $id;
        });
    @endif
```


**setOrder(array $order)**

Defines the order that a datatable will be ordered by on first page load.
```php
{{ DataTable::table()
    ->addColumn('ID', 'First Name', 'Last Name')
    ->setUrl($ajaxRouteToTableData)
    ->setOrder(array(2=>'asc', 1=>'asc')) // sort by last name then first name
    ->render('my.datatable.template') }}
```
## Extras
Some extras features, using the Datatables api.

### TableTools

To use TableTools you will need to add some files in your project (https://datatables.net/extensions/tabletools/), if you want some help download the datatable's package and inside the extension folder go to /tabletools and study the examples. After, all the files include, don't forget to pass the parameters like this:

```js
//In view:

{{
    Datatable::table()
        ->addColumn('your columns here separated by comma')
        ->setUrl('your URL for server side')
        ->setOptions(
            array(
                'dom' =>"T<'clear'>lfrtip",
                'tableTools' => array(
                    "sSwfPath" => "your/path/to/swf/copy_csv_cls_pdf.swf",
                    "aButtons" => array("copy", "pdf", "xls")
                )
            )
        )
}}

```
If you want to get some properties like "which row did i click?", see the javascript.blade.php and the variable $values.

## Contributors

* [jgoux](https://github.com/jgoux) for helping with searching on number columns in the database
* [jijoel](https://github.com/jijoel) for helping with callback options and documentation

## Changelog

* 2.0.0:
	* Seperated Query and Collection Engine
	* Added single column search
	* Code cleanup

## Applications

https://github.com/hillelcoren/invoice-ninja (by Hillel Coren)

## License

This package is licensed under the MIT License
