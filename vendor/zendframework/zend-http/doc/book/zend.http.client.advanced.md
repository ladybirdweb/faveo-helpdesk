# HTTP Client - Advanced Usage

## HTTP Redirections

`Zend\Http\Client` automatically handles *HTTP* redirections, and by default will follow up to 5
redirections. This can be changed by setting the `maxredirects` configuration parameter.

According to the *HTTP*/1.1 RFC, *HTTP* 301 and 302 responses should be treated by the client by
resending the same request to the specified location - using the same request method. However, most
clients to not implement this and always use a `GET` request when redirecting. By default,
`Zend\Http\Client` does the same - when redirecting on a 301 or 302 response, all `GET` and POST
parameters are reset, and a `GET` request is sent to the new location. This behavior can be changed
by setting the `strictredirects` configuration parameter to boolean `TRUE`:

**Forcing RFC 2616 Strict Redirections on 301 and 302 Responses**

```php
// Strict Redirections
$client->setOptions(array('strictredirects' => true));

// Non-strict Redirections
$client->setOptions(array('strictredirects' => false));
```

You can always get the number of redirections done after sending a request using the
`getRedirectionsCount()` method.

## Adding Cookies and Using Cookie Persistence

`Zend\Http\Client` provides an easy interface for adding cookies to your request, so that no direct
header modification is required. Cookies can be added using either the addCookie() or `setCookies`
method. The `addCookie` method has a number of operating modes:

**Setting Cookies Using addCookie()**

```php
// Easy and simple: by providing a cookie name and cookie value
$client->addCookie('flavor', 'chocolate chips');

// By providing a Zend\Http\Header\SetCookie object
$cookie = Zend\Http\Header\SetCookie::fromString('Set-Cookie: flavor=chocolate%20chips');
$client->addCookie($cookie);

// Multiple cookies can be set at once by providing an
// array of Zend\Http\Header\SetCookie objects
$cookies = array(
    Zend\Http\Header\SetCookie::fromString('Set-Cookie: flavorOne=chocolate%20chips'),
    Zend\Http\Header\SetCookie::fromString('Set-Cookie: flavorTwo=vanilla'),
);
$client->addCookie($cookies);
```

The `setCookies()` method works in a similar manner, except that it requires an array of cookie
values as its only argument and also clears the cookie container before adding the new cookies:

**Setting Cookies Using setCookies()**

```php
// setCookies accepts an array of cookie values as $name => $value
$client->setCookies(array(
    'flavor' => 'chocolate chips',
    'amount' => 10,
));
```

For more information about `Zend\Http\Header\SetCookie` objects, see \[this
section\](zend.http.headers).

`Zend\Http\Client` also provides a means for simplifying cookie stickiness - that is having the
client internally store all sent and received cookies, and resend them on subsequent requests:
`Zend\Http\Cookies`. This is useful, for example when you need to log in to a remote site first and
receive and authentication or session ID cookie before sending further requests.

**Enabling Cookie Stickiness**

```php
$headers = $client->getRequest()->getHeaders();
$cookies = new Zend\Http\Cookies($headers);

// First request: log in and start a session
$client->setUri('http://example.com/login.php');
$client->setParameterPost(array('user' => 'h4x0r', 'password' => 'l33t'));
$client->setMethod('POST');

$response = $client->getResponse();
$cookies->addCookiesFromResponse($response, $client->getUri());

// Now we can send our next request
$client->setUri('http://example.com/read_member_news.php');
$client->setCookies($cookies->getMatchingCookies($client->getUri()));
$client->setMethod('GET');
```

For more information about the `Zend\Http\Cookies` class, see this section
&lt;zend.http.client.cookies&gt;.

## Setting Custom Request Headers

Setting custom headers is performed by first fetching the header container from the client's
`Zend\Http\Request` object. This method is quite diverse and can be used in several ways, as the
following example shows:

**Setting A Single Custom Request Header**

```php
// Fetch the container
$headers = $client->getRequest()->getHeaders();

// Setting a single header. Will not overwrite any
// previously-added headers of the same name.
$headers->addHeaderLine('Host', 'www.example.com');

// Another way of doing the exact same thing
$headers->addHeaderLine('Host: www.example.com');

// Another way of doing the exact same thing using
// the provided Zend\Http\Header class
$headers->addHeader(Zend\Http\Header\Host::fromString('Host: www.example.com'));

// You can also add multiple headers at once by passing an
// array to addHeaders using any of the formats below:
$headers->addHeaders(array(
    // Zend\Http\Header\* object
    Zend\Http\Header\Host::fromString('Host: www.example.com'),

    // Header name as array key, header value as array key value
    'Cookie' => 'PHPSESSID=1234567890abcdef1234567890abcdef',

    // Raw header string
    'Cookie: language=he',
));
```

`Zend\Http\Client` also provides a convenience method for setting request headers, `setHeaders`.
This method will create a new header container, add the specified headers and then store the new
header container in it's `Zend\Http\Request` object. As a consequence, any pre-existing headers will
be erased.

**Setting Multiple Custom Request Headers**

```php
// Setting multiple headers.  Will remove all existing
// headers and add new ones to the Request header container
$client->setHeaders(array(
    Zend\Http\Header\Host::fromString('Host: www.example.com'),
    'Accept-Encoding' => 'gzip,deflate',
    'X-Powered-By: Zend Framework',
));
```

## File Uploads

You can upload files through *HTTP* using the setFileUpload method. This method takes a file name as
the first parameter, a form name as the second parameter, and data as a third optional parameter. If
the third data parameter is `NULL`, the first file name parameter is considered to be a real file on
disk, and `Zend\Http\Client` will try to read this file and upload it. If the data parameter is not
`NULL`, the first file name parameter will be sent as the file name, but no actual file needs to
exist on the disk. The second form name parameter is always required, and is equivalent to the
"name" attribute of an `<input>` tag, if the file was to be uploaded through an *HTML* form. A
fourth optional parameter provides the file's content-type. If not specified, and `Zend\Http\Client`
reads the file from the disk, the `mime_content_type` function will be used to guess the file's
content type, if it is available. In any case, the default MIME type will be
application/octet-stream.

**Using setFileUpload to Upload Files**

```php
// Uploading arbitrary data as a file
$text = 'this is some plain text';
$client->setFileUpload('some_text.txt', 'upload', $text, 'text/plain');

// Uploading an existing file
$client->setFileUpload('/tmp/Backup.tar.gz', 'bufile');

// Send the files
$client->setMethod('POST');
$client->send();
```

In the first example, the `$text` variable is uploaded and will be available as `$_FILES['upload']`
on the server side. In the second example, the existing file `/tmp/Backup.tar.gz` is uploaded to the
server and will be available as `$_FILES['bufile']`. The content type will be guessed automatically
if possible - and if not, the content type will be set to 'application/octet-stream'.

> ## Note
#### Uploading files
When uploading files, the *HTTP* request content-type is automatically set to multipart/form-data.
Keep in mind that you must send a POST or PUT request in order to upload files. Most servers will
ignore the request body on other request methods.

## Sending Raw POST Data

You can use a `Zend\Http\Client` to send raw POST data using the `setRawBody()` method. This method
takes one parameter: the data to send in the request body. When sending raw POST data, it is
advisable to also set the encoding type using `setEncType()`.

**Sending Raw POST Data**

```php
$xml = '<book>' .
       '  <title>Islands in the Stream</title>' .
       '  <author>Ernest Hemingway</author>' .
       '  <year>1970</year>' .
       '</book>';
$client->setMethod('POST');
$client->setRawBody($xml);
$client->setEncType('text/xml');
$client->send();
```

The data should be available on the server side through *PHP*'s `$HTTP_RAW_POST_DATA` variable or
through the `php://input` stream.

> ## Note
#### Using raw POST data
Setting raw POST data for a request will override any POST parameters or file uploads. You should
not try to use both on the same request. Keep in mind that most servers will ignore the request body
unless you send a POST request.

## HTTP Authentication

Currently, `Zend\Http\Client` only supports basic *HTTP* authentication. This feature is utilized
using the `setAuth()` method, or by specifying a username and a password in the URI. The `setAuth()`
method takes 3 parameters: The user name, the password and an optional authentication type
parameter. As mentioned, currently only basic authentication is supported (digest authentication
support is planned).

**Setting HTTP Authentication User and Password**

```php
// Using basic authentication
$client->setAuth('shahar', 'myPassword!', Zend\Http\Client::AUTH_BASIC);

// Since basic auth is default, you can just do this:
$client->setAuth('shahar', 'myPassword!');

// You can also specify username and password in the URI
$client->setUri('http://christer:secret@example.com');
```

## Sending Multiple Requests With the Same Client

`Zend\Http\Client` was also designed specifically to handle several consecutive requests with the
same object. This is useful in cases where a script requires data to be fetched from several places,
or when accessing a specific *HTTP* resource requires logging in and obtaining a session cookie, for
example.

When performing several requests to the same host, it is highly recommended to enable the
'keepalive' configuration flag. This way, if the server supports keep-alive connections, the
connection to the server will only be closed once all requests are done and the Client object is
destroyed. This prevents the overhead of opening and closing *TCP* connections to the server.

When you perform several requests with the same client, but want to make sure all the
request-specific parameters are cleared, you should use the `resetParameters()` method. This ensures
that GET and POST parameters, request body and headers are reset and are not reused in the next
request.

> ## Note
#### Resetting parameters
Note that cookies are not reset by default when the `resetParameters()` method is used. To clean all
cookies as well, use `resetParameters(true)`, or call `clearCookies()` after calling
`resetParameters()`.

Another feature designed specifically for consecutive requests is the `Zend\Http\Cookies` object.
This "Cookie Jar" allow you to save cookies set by the server in a request, and send them back on
consecutive requests transparently. This allows, for example, going through an authentication
request before sending the actual data-fetching request.

If your application requires one authentication request per user, and consecutive requests might be
performed in more than one script in your application, it might be a good idea to store the Cookies
object in the user's session. This way, you will only need to authenticate the user once every
session.

**Performing consecutive requests with one client**

```php
// First, instantiate the client
$client = new Zend\Http\Client('http://www.example.com/fetchdata.php', array(
    'keepalive' => true
));

// Do we have the cookies stored in our session?
if (isset($_SESSION['cookiejar']) &&
    $_SESSION['cookiejar'] instanceof Zend\Http\Cookies) {

    $cookieJar = $_SESSION['cookiejar'];
} else {
    // If we don't, authenticate and store cookies
    $client->setUri('http://www.example.com/login.php');
    $client->setParameterPost(array(
        'user' => 'shahar',
        'pass' => 'somesecret'
    ));
    $response = $client->setMethod('POST')->send();
    $cookieJar = Zend\Http\Cookies::fromResponse($response);

    // Now, clear parameters and set the URI to the original one
    // (note that the cookies that were set by the server are now
    // stored in the jar)
    $client->resetParameters();
    $client->setUri('http://www.example.com/fetchdata.php');
}

// Add the cookies to the new request
$client->setCookies($cookieJar->getMatchingCookies($client->getUri()));
$response = $client->setMethod('GET')->send();

// Store cookies in session, for next page
$_SESSION['cookiejar'] = $cookieJar;
```

## Data Streaming

By default, `Zend\Http\Client` accepts and returns data as *PHP* strings. However, in many cases
there are big files to be received, thus keeping them in memory might be unnecessary or too
expensive. For these cases, `Zend\Http\Client` supports writing data to files (streams).

In order to receive data from the server as stream, use `setStream()`. Optional argument specifies
the filename where the data will be stored. If the argument is just `TRUE` (default), temporary file
will be used and will be deleted once response object is destroyed. Setting argument to `FALSE`
disables the streaming functionality.

When using streaming, `send()` method will return object of class `Zend\Http\Response\Stream`, which
has two useful methods: `getStreamName()` will return the name of the file where the response is
stored, and `getStream()` will return stream from which the response could be read.

You can either write the response to pre-defined file, or use temporary file for storing it and send
it out or write it to another file using regular stream functions.

> ## Receiving file from HTTP server with streaming
```php
$client-setStream(); // will use temp file
$response = $client-send();
// copy file
copy($response-getStreamName(), "my/downloads/file");
// use stream
$fp = fopen("my/downloads/file2", "w");
stream_copy_to_stream($response-getStream(), $fp);
// Also can write to known file
$client-setStream("my/downloads/myfile")-send();
```
