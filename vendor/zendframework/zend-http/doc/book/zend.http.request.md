# The Request Class

## Overview

The `Zend\Http\Request` object is responsible for providing a fluent API that allows a developer to
interact with all the various parts of an HTTP request.

A typical HTTP request looks like this:
## 
##     | METHOD | URI | VERSION |
##     |        HEADERS         |
##     |         BODY           |

In simplified terms, the request consists of a method, *URI* and HTTP version number which together
make up the "Request Line." Next come the HTTP headers, of which there can be 0 or more. After that
is the request body, which is typically used when a client wishes to send data to the server in the
form of an encoded file, or include a set of POST parameters, for example. More information on the
structure and specification of a HTTP request can be found in [RFC-2616 on the W3.org
site](http://www.w3.org/Protocols/rfc2616/rfc2616-sec5.html).

## Quick Start

Request objects can either be created from the provided `fromString()` factory, or, if you wish to
have a completely empty object to start with, by simply instantiating the `Zend\Http\Request` class.

```php
use Zend\Http\Request;

$request = Request::fromString(<<<EOS
POST /foo HTTP/1.1
\r\n
HeaderField1: header-field-value1
HeaderField2: header-field-value2
\r\n\r\n
foo=bar&
EOS
);

// OR, the completely equivalent

$request = new Request();
$request->setMethod(Request::METHOD_POST);
$request->setUri('/foo');
$request->getHeaders()->addHeaders(array(
    'HeaderField1' => 'header-field-value1',
    'HeaderField2' => 'header-field-value2',
));
$request->getPost()->set('foo', 'bar');
```

## Configuration Options

No configuration options are available.

## Available Methods

**Request::fromString**  
`Request::fromString(string $string)`

A factory that produces a Request object from a well-formed HTTP Request string.

Returns `Zend\Http\Request`

<!-- -->

**setMethod**  
`setMethod(string $method)`

Set the method for this request.

Returns `Zend\Http\Request`

<!-- -->

**getMethod**  
`getMethod()`

Return the method for this request.

Returns string

<!-- -->

**setUri**  
`setUri(string|Zend\Uri\Http $uri)`

Set the URI/URL for this request; this can be a string or an instance of `Zend\Uri\Http`.

Returns `Zend\Http\Request`

<!-- -->

**getUri**  
`getUri()`

Return the URI for this request object.

Returns `Zend\Uri\Http`

<!-- -->

**getUriString**  
`getUriString()`

Return the URI for this request object as a string.

Returns string

<!-- -->

**setVersion**  
`setVersion(string $version)`

Set the HTTP version for this object, one of 1.0 or 1.1 (`Request::VERSION_10`,
`Request::VERSION_11`).

Returns `Zend\Http\Request`

<!-- -->

**getVersion**  
`getVersion()`

Return the HTTP version for this request.

Returns string

<!-- -->

**setQuery**  
`setQuery(Zend\Stdlib\ParametersInterface $query)`

Provide an alternate Parameter Container implementation for query parameters in this object. (This
is NOT the primary API for value setting; for that, see `getQuery()`).

Returns `Zend\Http\Request`

<!-- -->

**getQuery**  
`getQuery(string|null $name, mixed|null $default)`

Return the parameter container responsible for query parameters or a single query parameter.

Returns `string`, `Zend\Stdlib\ParametersInterface`, or `null` depending on value of `$name`
argument.

<!-- -->

**setPost**  
`setPost(Zend\Stdlib\ParametersInterface $post)`

Provide an alternate Parameter Container implementation for POST parameters in this object. (This is
NOT the primary API for value setting; for that, see `getPost()`).

Returns `Zend\Http\Request`

<!-- -->

**getPost**  
`getPost(string|null $name, mixed|null $default)`

Return the parameter container responsible for POST parameters or a single POST parameter.

Returns `string`, `Zend\Stdlib\ParametersInterface`, or `null` depending on value of `$name`
argument.

<!-- -->

**getCookie**  
`getCookie()`

Return the Cookie header, this is the same as calling
*$request-&gt;getHeaders()-&gt;get('Cookie');*.

Returns `Zend\Http\Header\Cookie`

<!-- -->

**setFiles**  
`setFiles(Zend\Stdlib\ParametersInterface $files)`

Provide an alternate Parameter Container implementation for file parameters in this object, (This is
NOT the primary API for value setting; for that, see `getFiles()`).

Returns `Zend\Http\Request`

<!-- -->

**getFiles**  
`getFiles(string|null $name, mixed|null $default)`

Return the parameter container responsible for file parameters or a single file parameter.

Returns `string`, `Zend\Stdlib\ParametersInterface`, or `null` depending on value of `$name`
argument.

<!-- -->

**setHeaders**  
`setHeaders(Zend\Http\Headers $headers)`

Provide an alternate Parameter Container implementation for headers in this object, (this is NOT the
primary API for value setting, for that see `getHeaders()`).

Returns `Zend\Http\Request`

<!-- -->

**getHeaders**  
`getHeaders(string|null $name, mixed|null $default)`

Return the container responsible for storing HTTP headers. This container exposes the primary API
for manipulating headers set in the HTTP request. See the section on
Zend\\\\Http\\\\Headers&lt;zend.http.headers&gt; for more information.

Returns `Zend\Http\Headers` if `$name` is `null`. Returns `Zend\Http\Header\HeaderInterface` or
`ArrayIterator` if `$name` matches one or more stored headers, respectively.

<!-- -->

**setMetadata**  
`setMetadata(string|int|array|Traversable $spec, mixed $value)`

Set message metadata.

Non-destructive setting of message metadata; always adds to the metadata, never overwrites the
entire metadata container.

Returns `Zend\Http\Request`

<!-- -->

**getMetadata**  
`getMetadata(null|string|int $key, null|mixed $default)`

Retrieve all metadata or a single metadatum as specified by key.

Returns mixed

<!-- -->

**setContent**  
`setContent(mixed $value)`

Set request body (content).

Returns `Zend\Http\Request`

<!-- -->

**getContent**  
`getContent()`

Get request body (content).

Returns mixed

<!-- -->

**isOptions**  
`isOptions()`

Is this an OPTIONS method request?

Returns bool

<!-- -->

**isGet**  
`isGet()`

Is this a GET method request?

Returns bool

<!-- -->

**isHead**  
`isHead()`

Is this a HEAD method request?

Returns bool

<!-- -->

**isPost**  
`isPost()`

Is this a POST method request?

Returns bool

<!-- -->

**isPut**  
`isPut()`

Is this a PUT method request?

Returns bool

<!-- -->

**isDelete**  
`isDelete()`

Is this a DELETE method request?

Returns bool

<!-- -->

**isTrace**  
`isTrace()`

Is this a TRACE method request?

Returns bool

<!-- -->

**isConnect**  
`isConnect()`

Is this a CONNECT method request?

Returns bool

<!-- -->

**isPatch**  
`isPatch()`

Is this a PATCH method request?

Returns bool

<!-- -->

**isXmlHttpRequest**  
`isXmlHttpRequest()`

Is this a Javascript XMLHttpRequest?

Returns bool

<!-- -->

**isFlashRequest**  
`isFlashRequest()`

Is this a Flash request?

Returns bool

<!-- -->

**renderRequestLine**  
`renderRequestLine()`

Return the formatted request line (first line) for this HTTP request.

Returns string

<!-- -->

**toString**  
`toString()`

Returns string

<!-- -->

**\_\_toString**  
`__toString()`

Allow PHP casting of this object.

Returns string

## Examples

**Generating a Request object from a string**

```php
use Zend\Http\Request;

$string = "GET /foo HTTP/1.1\r\n\r\nSome Content";
$request = Request::fromString($string);

$request->getMethod();    // returns Request::METHOD_GET
$request->getUri();       // returns Zend\Uri\Http object
$request->getUriString(); // returns '/foo'
$request->getVersion();   // returns Request::VERSION_11 or '1.1'
$request->getContent();   // returns 'Some Content'
```

**Retrieving and setting headers**

```php
use Zend\Http\Request;
use Zend\Http\Header\Cookie;

$request = new Request();
$request->getHeaders()->get('Content-Type'); // return content type
$request->getHeaders()->addHeader(new Cookie(array('foo' => 'bar')));
foreach ($request->getHeaders() as $header) {
    echo $header->getFieldName() . ' with value ' . $header->getFieldValue();
}
```

**Retrieving and setting GET and POST values**

```php
use Zend\Http\Request;

$request = new Request();

// getPost() and getQuery() both return, by default, a Parameters object, which extends ArrayObject
$request->getPost()->foo = 'Foo value';
$request->getQuery()->bar = 'Bar value';
$request->getPost('foo'); // returns 'Foo value'
$request->getQuery()->offsetGet('bar'); // returns 'Bar value'
```

**Generating a formatted HTTP Request from a Request object**

```php
use Zend\Http\Request;

$request = new Request();
$request->setMethod(Request::METHOD_POST);
$request->setUri('/foo');
$request->getHeaders()->addHeaders(array(
    'HeaderField1' => 'header-field-value1',
    'HeaderField2' => 'header-field-value2',
));
$request->getPost()->set('foo', 'bar');
$request->setContent($request->getPost()->toString());
echo $request->toString();

/** Will produce:
POST /foo HTTP/1.1
HeaderField1: header-field-value1
HeaderField2: header-field-value2

foo=bar
*/
```
