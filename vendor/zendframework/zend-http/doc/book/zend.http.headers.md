# The Headers Class

## Overview

The `Zend\Http\Headers` class is a container for HTTP headers. It is typically accessed as part of a
`Zend\Http\Request` or `Zend\Http\Response` `getHeaders()` call. The Headers container will lazily
load actual Header objects as to reduce the overhead of header specific parsing.

The `Zend\Http\Header\*` classes are the domain specific implementations for the various types of
Headers that one might encounter during the typical HTTP request. If a header of unknown type is
encountered, it will be implemented as a `Zend\Http\Header\GenericHeader` instance. See the below
table for a list of the various HTTP headers and the API that is specific to each header type.

## Quick Start

The quickest way to get started interacting with header objects is by getting an already populated
Headers container from a request or response object.

```php
// $client is an instance of Zend\Http\Client

// You can retrieve the request headers by first retrieving
// the Request object and then calling getHeaders on it
$requestHeaders  = $client->getRequest()->getHeaders();

// The same method also works for retrieving Response headers
$responseHeaders = $client->getResponse()->getHeaders();
```

`Zend\Http\Headers` can also extract headers from a string:

```php
$headerString = <<<EOB
Host: www.example.com
Content-Type: text/html
Content-Length: 1337
EOB;

$headers = Zend\Http\Headers::fromString($headerString);
// $headers is now populated with three objects
//   (1) Zend\Http\Header\Host
//   (2) Zend\Http\Header\ContentType
//   (3) Zend\Http\Header\ContentLength
```

Now that you have an instance of `Zend\Http\Headers` you can manipulate the individual headers it
contains using the provided public API methods outlined in the "Available
Methods&lt;zend.http.headers.methods&gt;" section.

## Configuration Options

No configuration options are available.

## Available Methods

**Headers::fromString**  
`Headers::fromString(string $string)`

Populates headers from string representation

Parses a string for headers, and aggregates them, in order, in the current instance, primarily as
strings until they are needed (they will be lazy loaded).

Returns `Zend\Http\Headers`

<!-- -->

**setPluginClassLoader**  
`setPluginClassLoader(Zend\Loader\PluginClassLocator $pluginClassLoader)`

Set an alternate implementation for the plugin class loader

Returns `Zend\Http\Headers`

<!-- -->

**getPluginClassLoader**  
`getPluginClassLoader()`

Return an instance of a `Zend\Loader\PluginClassLocator`, lazyload and inject map if necessary.

Returns `Zend\Loader\PluginClassLocator`

<!-- -->

**addHeaders**  
`addHeaders(array|Traversable $headers)`

Add many headers at once

Expects an array (or `Traversable` object) of type/value pairs.

Returns `Zend\Http\Headers`

<!-- -->

**addHeaderLine**  
`addHeaderLine(string $headerFieldNameOrLine, string $fieldValue)`

Add a raw header line, either in name =&gt; value, or as a single string 'name: value'

This method allows for lazy-loading in that the parsing and instantiation of Header object will be
delayed until they are retrieved by either `get()` or `current()`.

Returns `Zend\Http\Headers`

<!-- -->

**addHeader**  
`addHeader(Zend\Http\Header\HeaderInterface $header)`

Add a Header to this container, for raw values see `addHeaderLine()` and `addHeaders()`.

Returns `Zend\Http\Headers`

<!-- -->

**removeHeader**  
`removeHeader(Zend\Http\Header\HeaderInterface $header)`

Remove a Header from the container

Returns bool

<!-- -->

**clearHeaders**  
`clearHeaders()`

Clear all headers

Removes all headers from queue

Returns `Zend\Http\Headers`

<!-- -->

**get**  
`get(string $name)`

Get all headers of a certain name/type

Returns false| `Zend\Http\Header\HeaderInterface`| `ArrayIterator`

<!-- -->

**has**  
`has(string $name)`

Test for existence of a type of header

Returns bool

<!-- -->

**next**  
`next()`

Advance the pointer for this object as an iterator

Returns void

<!-- -->

**key**  
`key()`

Return the current key for this object as an iterator

Returns mixed

<!-- -->

**valid**  
`valid()`

Is this iterator still valid?

Returns bool

<!-- -->

**rewind**  
`rewind()`

Reset the internal pointer for this object as an iterator

Returns void

<!-- -->

**current**  
`current()`

Return the current value for this iterator, lazy loading it if need be

Returns `Zend\Http\Header\HeaderInterface`

<!-- -->

**count**  
`count()`

Return the number of headers in this container. If all headers have not been parsed, actual count
could increase if MultipleHeader objects exist in the Request/Response. If you need an exact count,
iterate.

Returns int

<!-- -->

**toString**  
`toString()`

Render all headers at once

This method handles the normal iteration of headers; it is up to the concrete classes to prepend
with the appropriate status/request line.

Returns string

<!-- -->

**toArray**  
`toArray()`

Return the headers container as an array

Returns array

<!-- -->

**forceLoading**  
`forceLoading()`

By calling this, it will force parsing and loading of all headers, after this `count()` will be
accurate

Returns bool

## Zend\\Http\\Header\\HeaderInterface Methods

**fromString**  
`fromString(string $headerLine)`

Factory to generate a header object from a string

Returns `Zend\Http\Header\GenericHeader`

<!-- -->

**getFieldName**  
`getFieldName()`

Retrieve header field name

Returns string

<!-- -->

**getFieldValue**  
`getFieldValue()`

Retrieve header field value

Returns string

<!-- -->

**toString**  
`toString()`

Cast to string as a well formed HTTP header line

Returns in form of "NAME: VALUE"

Returns string

## Zend\\Http\\Header\\AbstractAccept Methods

**parseHeaderLine**  
`parseHeaderLine(string $headerLine)`

Parse the given header line and add the values

Returns void

**getFieldValuePartsFromHeaderLine**  
`getFieldValuePartsFromHeaderLine(string $headerLine)`

Parse the Field Value Parts represented by a header line

Throws `Zend\Http\Header\Exception\InvalidArgumentException` if the header is invalid

Returns array

**getFieldValue**  
`getFieldValue(array|null $values = null)`

Get field value

Returns string

**match**  
`match(array|string $matchAgainst)`

Match a media string against this header. Returns the matched value or false

Returns `Accept\FieldValuePart\AcceptFieldValuePart` or bool

**getPrioritized**  
`getPrioritized()`

Returns all the keys, values and parameters this header represents

Returns array

## Zend\\Http\\Header\\AbstractDate Methods

**setDateFormat**  
static `setDateFormat(int $format)`

Set date output format.

Returns void

**getDateFormat**  
static `getDateFormat()`

Return current date output format

Returns string

**setDate**  
`setDate(string|DateTime $date)`

Set the date for this header, this can be a string or an instance of DateTime

Throws `Zend\Http\Header\Exception\InvalidArgumentException` if the date is neither a valid string
nor an instance of `\DateTime`.

Returns self

**getDate**  
`getDate()`

Return date for this header

Returns self

**compareTo**  
`compareTo(string|DateTime $date)`

Compare provided date to date for this header. Returns &lt; 0 if date in header is less than
`$date`; &gt; 0 if it's greater, and 0 if they are equal. See
[strcmp](http://www.php.net/manual/en/function.strcmp.php).

Returns int

**date**  
`date()`

Return date for this header as an instance of `\DateTime`

Returns `\DateTime`

**fromTimestamp**  
`fromTimestamp(int $time)`

Create date-based header from Unix timestamp

Returns self

**fromTimeString**  
`fromTimeString(string $time)`

Create date-based header from strtotime()-compatible string

Returns self

## Zend\\Http\\Header\\AbstractLocation Methods

**setUri**  
`setUri(string|Zend\Uri\UriInterface $uri)`

Set the URI/URL for this header, this can be a string or an instance of `Zend\Uri\Http`

Throws `Zend\Http\Header\Exception\InvalidArgumentException` if `$uri` is neither a valid URL nor an
instance of `Zend\Uri\UriInterface`.

Returns self

**getUri**  
`getUri()`

Return the URI for this header

Returns string

**uri**  
`uri()`

Return the URI for this header as an instance of `Zend\Uri\Http`

Returns `Zend\Uri\UriInterface`

## List of HTTP Header Types

Some header classes expose methods for manipulating their value. The following list contains all of
the classes available in the `Zend\Http\Header\*` namespace, as well as any specific methods they
contain. All these classes implement `Zend\Http\Header\HeaderInterface` and its
methods&lt;zend.http.headers.header-description&gt;.

**Accept**  
See `Zend\Http\Header\AbstractAccept` methods&lt;zend.http.header.abstractaccept.methods&gt;.

`addMediaType(string $type, int|float $priority = 1)`  
Add a media type, with the given priority

Returns self

`hasMediaType(string $type)`  
Does the header have the requested media type?

Returns bool

<!-- -->

**AcceptCharset**  
See `Zend\Http\Header\AbstractAccept` methods&lt;zend.http.header.abstractaccept.methods&gt;.

`addCharset(string $type, int|float $priority = 1)`  
Add a charset, with the given priority

Returns self

`hasCharset(string $type)`  
Does the header have the requested charset?

Returns bool

<!-- -->

**AcceptEncoding**  
See `Zend\Http\Header\AbstractAccept` methods&lt;zend.http.header.abstractaccept.methods&gt;.

`addEncoding(string $type, int|float $priority = 1)`  
Add an encoding, with the given priority

Returns self

`hasEncoding(string $type)`  
Does the header have the requested encoding?

Returns bool

<!-- -->

**AcceptLanguage**  
See `Zend\Http\Header\AbstractAccept` methods&lt;zend.http.header.abstractaccept.methods&gt;.

`addLanguage(string $type, int|float $priority = 1)`  
Add a language, with the given priority

Returns self

`hasLanguage(string $type)`  
Does the header have the requested language?

Returns bool

<!-- -->

**AcceptRanges**  
`getRangeUnit()`

`setRangeUnit($rangeUnit)`

<!-- -->

**Age**  
`getDeltaSeconds()`  
Get number of seconds

Returns int

`setDeltaSeconds()`  
Set number of seconds

Returns self

<!-- -->

**Allow**  
`getAllMethods()`  
Get list of all defined methods

Returns array

`getAllowedMethods()`  
Get list of allowed methods

Returns array

`allowMethods(array|string $allowedMethods)`  
Allow methods or list of methods

Returns self

`disallowMethods(array|string $allowedMethods)`  
Disallow methods or list of methods

Returns self

`denyMethods(array|string $allowedMethods)`  
Convenience alias for `disallowMethods()`

Returns self

`isAllowedMethod(string $method)`  
Check whether method is allowed

Returns bool

<!-- -->

**AuthenticationInfo**  
No additional methods

<!-- -->

**Authorization**  
No additional methods

<!-- -->

**CacheControl**  
`isEmpty()`  
Checks if the internal directives array is empty

Returns bool

`addDirective(string $key, string|bool $value)`  
Add a directive

For directives like 'max-age=60', $value = '60'

For directives like 'private', use the default $value = true

Returns self

`hasDirective(string $key)`  
Check the internal directives array for a directive

Returns bool

`getDirective(string $key)`  
Fetch the value of a directive from the internal directive array

Returns string|null

`removeDirective(string $key)`  
Remove a directive

Returns self

<!-- -->

**Connection**  
`setValue($value)`  
Set arbitrary header value

RFC allows any token as value, 'close' and 'keep-alive' are commonly used

Returns self

`isPersistent()`  
Whether the connection is persistent

Returns bool

`setPersistent(bool $flag)`  
Set Connection header to define persistent connection

Returns self

<!-- -->

**ContentDisposition**  
No additional methods

<!-- -->

**ContentEncoding**  
No additional methods

<!-- -->

**ContentLanguage**  
No additional methods

<!-- -->

**ContentLength**  
No additional methods

<!-- -->

**ContentLocation**  
See `Zend\Http\Header\AbstractLocation` methods&lt;zend.http.header.abstractlocation.methods&gt;.

<!-- -->

**ContentMD5**  
No additional methods

<!-- -->

**ContentRange**  
No additional methods

<!-- -->

**ContentSecurityPolicy**  
`getDirectives()`  
Retrieve the defined directives for the policy

Returns an array

`setDirective(string $name, array $sources)`  
Set the directive with the given name to include the sources

As an example: an auction site wishes to load images from any URI, plugin content from a list of
trusted media providers (including a content distribution network), and scripts only from a server
under its control hosting sanitized ECMAScript:

```php
// http://www.w3.org/TR/2012/CR-CSP-20121115/#sample-policy-definitions
// Example #2
$csp = new ContentSecurityPolicy();
$csp->setDirective('default-src', array()) // No sources
    ->setDirective('img-src', array('*'))
    ->setDirective('object-src' array('media1.example.com', 'media2.example.com',
'*.cdn.example.com'))
    ->setDirective('script-src', array('trustedscripts.example.com'));
```

Returns self

<!-- -->

**ContentTransferEncoding**  
No additional methods

<!-- -->

**ContentType**  
`match(array|string $matchAgainst)`  
Determine if the mediatype value in this header matches the provided criteria

Returns bool|string

`getMediaType()`  
Get the media type

Returns string

`setMediaType(string $mediaType)`  
Set the media type

Returns self

`getParameters()`  
Get any additional content-type parameters currently set

Returns array

`setParameters(array $parameters)`  
Set additional content-type parameters

Returns self

`getCharset()`  
Get the content-type character set encoding, if any

Returns string|null

`setCharset(string $charset)`  
Set the content-type character set encoding

Returns self

<!-- -->

**Cookie**  
Extends `ArrayObject`

static `fromSetCookieArray(array $setCookies)`

`setEncodeValue()`

`getEncodeValue()`

<!-- -->

**Date**  
See `Zend\Http\Header\AbstractDate` methods&lt;zend.http.header.abstractdate.methods&gt;.

<!-- -->

**Etag**  
No additional methods

<!-- -->

**Expect**  
No additional methods

<!-- -->

**Expires**  
See `Zend\Http\Header\AbstractDate` methods&lt;zend.http.header.abstractdate.methods&gt;.

<!-- -->

**From**  
No additional methods

<!-- -->

**Host**  
No additional methods

<!-- -->

**IfMatch**  
No additional methods

<!-- -->

**IfModifiedSince**  
See `Zend\Http\Header\AbstractDate` methods&lt;zend.http.header.abstractdate.methods&gt;.

<!-- -->

**IfNoneMatch**  
No additional methods

<!-- -->

**IfRange**  
No additional methods

<!-- -->

**IfUnmodifiedSince**  
See `Zend\Http\Header\AbstractDate` methods&lt;zend.http.header.abstractdate.methods&gt;.

<!-- -->

**KeepAlive**  
No additional methods

<!-- -->

**LastModified**  
See `Zend\Http\Header\AbstractDate` methods&lt;zend.http.header.abstractdate.methods&gt;.

<!-- -->

**Location**  
See `Zend\Http\Header\AbstractLocation` methods&lt;zend.http.header.abstractlocation.methods&gt;.

<!-- -->

**MaxForwards**  
No additional methods

<!-- -->

**Origin**  
No additional methods

<!-- -->

**Pragma**  
No additional methods

<!-- -->

**ProxyAuthenticate**  
`toStringMultipleHeaders(array $headers)`

<!-- -->

**ProxyAuthorization**  
No additional methods

<!-- -->

**Range**  
No additional methods

<!-- -->

**Referer**  
See `Zend\Http\Header\AbstractLocation` methods&lt;zend.http.header.abstractlocation.methods&gt;.

<!-- -->

**Refresh**  
No additional methods

<!-- -->

**RetryAfter**  
See `Zend\Http\Header\AbstractDate` methods&lt;zend.http.header.abstractdate.methods&gt;.

`setDeltaSeconds(int $delta)`  
Set number of seconds

Returns self

`getDeltaSeconds()`  
Get number of seconds

Returns int

<!-- -->

**Server**  
No additional methods

<!-- -->

**SetCookie**  
`getName()` / `setName(string $name)`  
The cookie name

`getValue()` / `setValue(string $value)`  
The cookie value

`getExpires()` / `setExpires(int|string $expires)`  
The time frame the cookie is valid for, null is a session cookie

`getPath()` / `setPath(string $path)`  
The URI path the cookie is bound to

`getDomain()` / `setDomain(string $domain)`  
The domain the cookie applies to

`getMaxAge()` / `setMaxAge(int $maxAge)`  
The maximum age of the cookie

`getVersion()` / `setVersion(int $version)`  
The cookie version

`isSecure()`  
Whether the cookies contains the Secure flag

Returns bool

`setSecure(bool $secure)`  
Set whether the cookies contains the Secure flag

Returns self

`isHttponly()`  
Whether the cookies can be accessed via HTTP only

Returns bool

`setHttponly(bool $httponly)`  
Set whether the cookies can be accessed via HTTP only

Returns self

`isExpired()`  
Whether the cookie is expired

Returns bool

`isSessionCookie()`  
Whether the cookie is a session cookie

Returns bool

`setQuoteFieldValue(bool $quotedValue)`  
Set whether the value for this cookie should be quoted

Returns self

`hasQuoteFieldValue()`  
Check whether the value for this cookie should be quoted

Returns bool

`isValidForRequest()`  
Whether the cookie is valid for a given request domain, path and isSecure

Returns bool

`match(string $uri, bool $matchSessionCookies, int $now)`  
Checks whether the cookie should be sent or not in a specific scenario

Returns bool

static `matchCookieDomain(string $cookieDomain, string $host)`  
Check if a cookie's domain matches a host name.

Returns bool

static `matchCookiePath(string $cookiePath, string $path)`  
Check if a cookie's path matches a URL path

Returns bool

`toStringMultipleHeaders(array $headers)`  
Returns string

<!-- -->

**TE**  
No additional methods

<!-- -->

**Trailer**  
No additional methods

<!-- -->

**TransferEncoding**  
No additional methods

<!-- -->

**Upgrade**  
No additional methods

<!-- -->

**UserAgent**  
No additional methods

<!-- -->

**Vary**  
No additional methods

<!-- -->

**Via**  
No additional methods

<!-- -->

**Warning**  
No additional methods

<!-- -->

**WWWAuthenticate**  
`toStringMultipleHeaders(array $headers)`

## Examples

**Retrieving headers from a Zend\\Http\\Headers object**

```php
// $client is an instance of Zend\Http\Client
$response = $client->send();
$headers = $response->getHeaders();

// We can check if the Request contains a specific header by
// using the ``has`` method. Returns boolean ``TRUE`` if at least
// one matching header found, and ``FALSE`` otherwise
$headers->has('Content-Type');

// We can retrieve all instances of a specific header by using
// the ``get`` method:
$contentTypeHeaders = $headers->get('Content-Type');
```

There are three possibilities for the return value of the above call to the `get` method:

> -   If no Content-Type header was set in the Request, `get` will return false.
- If only one Content-Type header was set in the Request, `get` will return an instance of
`Zend\Http\Header\ContentType`.
- If more than one Content-Type header was set in the Request, `get` will return an ArrayIterator
containing one `Zend\Http\Header\ContentType` instance per header.

**Adding headers to a Zend\\Http\\Headers object**

```php
$headers = new Zend\Http\Headers();

// We can directly add any object that implements Zend\Http\Header\HeaderInterface
$typeHeader = Zend\Http\Header\ContentType::fromString('Content-Type: text/html');
$headers->addHeader($typeHeader);

// We can add headers using the raw string representation, either
// passing the header name and value as separate arguments...
$headers->addHeaderLine('Content-Type', 'text/html');

// .. or we can pass the entire header as the only argument
$headers->addHeaderLine('Content-Type: text/html');

// We can also add headers in bulk using addHeaders, which accepts
// an array of individual header definitions that can be in any of
// the accepted formats outlined below:
$headers->addHeaders(array(

    // An object implementing Zend\Http\Header\HeaderInterface
    Zend\Http\Header\ContentType::fromString('Content-Type: text/html'),

    // A raw header string
    'Content-Type: text/html',

    // We can also pass the header name as the array key and the
    // header content as that array key's value
    'Content-Type' => 'text/html');

));
```

**Removing headers from a Zend\\Http\\Headers object**

We can remove all headers of a specific type using the `removeHeader` method, which accepts a single
object implementing `Zend\Http\Header\HeaderInterface`

```php
// $headers is a pre-configured instance of Zend\Http\Headers

// We can also delete individual headers or groups of headers
$matches = $headers->get('Content-Type');

// If more than one header was found, iterate over the collection
// and remove each one individually
if ($matches instanceof ArrayIterator) {
    foreach ($headers as $header) {
        $headers->removeHeader($header);
    }
// If only a single header was found, remove it directly
} elseif ($matches instanceof Zend\Http\Header\HeaderInterface) {
    $headers->removeHeader($header);
}

// In addition to this, we can clear all the headers currently stored in
// the container by calling the clearHeaders() method
$matches->clearHeaders();
```
