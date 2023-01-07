# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.11.2 - 2019-12-30

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#207](https://github.com/zendframework/zend-http/pull/207) fixes case sensitivity for SameSite directive.

## 2.11.1 - 2019-12-04

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#204](https://github.com/zendframework/zend-http/pull/204) fixes numerous header classes to cast field value to string (since `HeaderInterface::getFieldValue()` specifies a return value of a string).

- [#182](https://github.com/zendframework/zend-http/pull/182) fixes detecting base uri in Request. Now `argv` is used only for CLI request as a fallback to detect script filename.

## 2.11.0 - 2019-12-03

### Added

- [#175](https://github.com/zendframework/zend-http/pull/175) adds support for Content Security Policy Level 3 Header directives.

- [#200](https://github.com/zendframework/zend-http/pull/200) adds support for additional directives in Content Security Policy header:
  - `block-all-mixed-content`,
  - `require-sri-for`,
  - `trusted-types`,
  - `upgrade-insecure-requests`.

- [#177](https://github.com/zendframework/zend-http/pull/177) adds support for Feature Policy header.

- [#186](https://github.com/zendframework/zend-http/pull/186) adds support for SameSite directive in Set-Cookie header.

### Changed

- [#194](https://github.com/zendframework/zend-http/pull/194) changes range of valid HTTP status codes to 100-599 (inclusive).

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#200](https://github.com/zendframework/zend-http/pull/200) fixes support for directives without value in Content Security Policy header.

## 2.10.1 - 2019-12-02

### Added

- Nothing.

### Changed

- [#190](https://github.com/zendframework/zend-http/pull/190) changes `ContentSecurityPolicy` to allow multiple values. Before it was not possible to provide multiple headers of that type.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#184](https://github.com/zendframework/zend-http/pull/184) fixes responses for request through the proxy with `HTTP/1.1 200 Connection established` header. 

- [#187](https://github.com/zendframework/zend-http/pull/187) fixes infinite recursion on invalid header. Now `InvalidArgumentException` exception is thrown. 

- [#188](https://github.com/zendframework/zend-http/pull/188) fixes `Client::setCookies` method to properly handle array of `SetCookie` objects. Per [documentation](https://docs.zendframework.com/zend-http/client/cookies/#usage) it should be allowed. 

- [#189](https://github.com/zendframework/zend-http/pull/189) fixes `Headers::toArray` method to properly handle headers of the same type. Behaviour was different depends how header has been attached (`addHeader` or `addHeaderLine` broken before). 

- [#198](https://github.com/zendframework/zend-http/pull/198) fixes merging options in Curl adapter. It was not possible to override integer-key options (constants) set via constructor with method `setOptions`. 

- [#198](https://github.com/zendframework/zend-http/pull/198) fixes allowed options type in `Proxy::setOptions`. `Traversable`, `array` or `Zend\Config` object is expected.

- [#198](https://github.com/zendframework/zend-http/pull/198) fixes various issues with `Proxy` adapter.

- [#199](https://github.com/zendframework/zend-http/pull/199) fixes saving resource to the file when streaming while client supports compression. Before, incorrectly, compressed resource was saved into the file.

## 2.10.0 - 2019-02-19

### Added

- [#173](https://github.com/zendframework/zend-http/pull/173) adds support for HTTP/2 requests and responses.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.9.1 - 2019-01-22

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#168](https://github.com/zendframework/zend-http/pull/168) fixes a problem when validating the connection timeout for the `Curl` and
  `Socket` client adapters; it now correctly identifies both integer and string
  integer values.

## 2.9.0 - 2019-01-08

### Added

- [#154](https://github.com/zendframework/zend-http/pull/154) adds the method `SetCookie::setEncodeValue()`. By default, Set-Cookie
  values are passed through `urlencode()`; when a boolean `false` is provided to
  this new method, the raw value will be used instead.

- [#166](https://github.com/zendframework/zend-http/pull/166) adds support for PHP 7.3.

### Changed

- [#154](https://github.com/zendframework/zend-http/pull/154) changes the behavior of `SetCookie::fromString()` slightly: if the parsed
  cookie value is the same as the one passed through `urldecode()`, the
  `SetCookie` header's `$encodeValue` property will be toggled off to ensure the
  value is not encoded in subsequent serializations, thus retaining the
  integrity of the value between usages.

- [#161](https://github.com/zendframework/zend-http/pull/161) changes how the Socket and Test adapters aggregate headers. Previously,
  they would `ucfirst()` the header name; now, they correctly leave the header
  names untouched, as header names should be considered case-insensitive.

- [#156](https://github.com/zendframework/zend-http/pull/156) changes how gzip and deflate decompression occur in responses, ensuring
  that if the Content-Length header reports 0, no decompression is attempted,
  and an empty string is returned.

### Deprecated

- Nothing.

### Removed

- [#166](https://github.com/zendframework/zend-http/pull/166) removes support for zend-stdlib v2 releases.

### Fixed

- Nothing.

## 2.8.3 - 2019-01-08

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#165](https://github.com/zendframework/zend-http/pull/165) fixes detection of the base URL when operating under a CLI environment.

- [#149](https://github.com/zendframework/zend-http/pull/149) provides fixes to `Client::setUri()` to ensure its status as a relative
  or absolute URI is correctly memoized.

- [#162](https://github.com/zendframework/zend-http/pull/162) fixes a typo in an exception message raised within `Cookies::fromString()`.

- [#121](https://github.com/zendframework/zend-http/pull/121) adds detection for non-numeric connection timeout values as well as
  integer casting to ensure the timeout is set properly in both the Curl and
  Socket adapters.

## 2.8.2 - 2018-08-13

### Added

- Nothing.

### Changed

- [#153](https://github.com/zendframework/zend-diactoros/pull/153) changes the reason phrase associated with the status code 425
  from "Unordered Collection" to "Too Early", corresponding to a new definition
  of the code as specified by the IANA.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#151](https://github.com/zendframework/zend-http/pull/151) fixes how Referer and other location-based headers report problems with
  invalid URLs provided in the header value, raising a `Zend\Http\Exception\InvalidArgumentException`
  in such cases. This change ensures the behavior is consistent with behavior
  prior to the 2.8.0 release.

## 2.8.1 - 2018-08-01

### Added

- Nothing.

### Changed

- This release modifies how `Zend\Http\PhpEnvironment\Request` marshals the
  request URI. In prior releases, we would attempt to inspect the
  `X-Rewrite-Url` and `X-Original-Url` headers, using their values, if present.
  These headers are issued by the ISAPI_Rewrite module for IIS (developed by
  HeliconTech). However, we have no way of guaranteeing that the module is what
  issued the headers, making it an unreliable source for discovering the URI. As
  such, we have removed this feature in this release of zend-http.

  If you are developing a zend-mvc application, you can mimic the
  functionality by adding a bootstrap listener like the following:

  ```php
  public function onBootstrap(MvcEvent $mvcEvent)
  {
      $request = $mvcEvent->getRequest();
      $requestUri = null;

      $httpXRewriteUrl = $request->getHeader('X-Rewrite-Url');
      if ($httpXRewriteUrl) {
          $requestUri = $httpXRewriteUrl->getFieldValue();
      }

      $httpXOriginalUrl = $request->getHeader('X-Original-Url');
      if ($httpXOriginalUrl) {
          $requestUri = $httpXOriginalUrl->getFieldValue();
      }

      if ($requestUri) {
          $request->setUri($requestUri)
      }
  }
  ```

  If you use a listener such as the above, make sure you also instruct your web
  server to strip any incoming headers of the same name so that you can
  guarantee they are issued by the ISAPI_Rewrite module.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.8.0 - 2018-04-26

### Added

- [#135](https://github.com/zendframework/zend-http/pull/135) adds a package suggestion of paragonie/certainty, which provides automated
  management of cacert.pem files.

- [#143](https://github.com/zendframework/zend-http/pull/143) adds support for PHP 7.2.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#140](https://github.com/zendframework/zend-http/pull/140) fixes retrieval of headers when multiple headers of the same name
  are added to the `Headers` instance; it now ensures that the last header added of the same
  type is retrieved when it is not a multi-value type. Previous values are overwritten.

- [#112](https://github.com/zendframework/zend-http/pull/112) provides performance improvements when parsing large chunked messages.

- introduces changes to `Response::fromString()` to pull the next line of the response
  and parse it for the status when a 100 status code is initially encountered, per https://tools.ietf.org/html/rfc7231\#section-6.2.1

- [#122](https://github.com/zendframework/zend-http/pull/122) fixes an issue with the stream response whereby if the `outputstream`
  option is set, the output file was opened twice; it is now opened exactly once.

- [#147](https://github.com/zendframework/zend-http/pull/147) fixes an issue with header retrieval when the header line is malformed.
  Previously, an exception would be raised if a specific `HeaderInterface` implementation determined
  the header line was invalid. Now, `Header::has()` will return false for such headers, allowing
  `Request::getHeader()` to return `false` or the provided default value. Additionally, in cases
  where the header name is malformed (e.g., `Useragent` instead of `User-Agent`, users can still
  retrieve by the submitted header name; they will receive a `GenericHeader` instance in such
  cases, however.

- [#133](https://github.com/zendframework/zend-http/pull/133) Adds back missing
  sprintf placeholder in CacheControl exception message

## 2.7.0 - 2017-10-13

### Added

- [#110](https://github.com/zendframework/zend-http/pull/110) Adds status
  codes 226, 308, 444, 499, 510, 599 with their corresponding constants and
  reason phrases.

### Changed

- [#120](https://github.com/zendframework/zend-http/pull/120) Changes handling
  of Cookie Max-Age parameter to conform to specification
  [rfc6265#section-5.2.2](https://tools.ietf.org/html/rfc6265#section-5.2.2).
  Specifically, non-numeric values are ignored and negative numbers are changed
  to 0.

### Deprecated

- Nothing.

### Removed

- [#115](https://github.com/zendframework/zend-http/pull/115) dropped php 5.5
  support

### Fixed

- [#130](https://github.com/zendframework/zend-http/pull/130) Fixed cURL
  adapter not resetting headers from previous request when used with output
  stream.

## 2.6.0 - 2017-01-31

### Added
- [#99](https://github.com/zendframework/zend-http/pull/99) added
  TimeoutException for cURL adapter.
- [#98](https://github.com/zendframework/zend-http/pull/98) added connection
  timeout (`connecttimeout`) for cURL and Socket adapters.
- [#97](https://github.com/zendframework/zend-http/pull/97) added support to
  `sslcafile` and `sslcapath` to cURL adapter.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.5.6 - 2017-01-31

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#107](https://github.com/zendframework/zend-http/pull/107) fixes the
  `Expires` header to allow values of `0` or `'0'`; these now resolve
  to the start of the unix epoch (1970-01-01).
- [#102](https://github.com/zendframework/zend-http/pull/102) fixes the Curl
  adapter timeout detection.
- [#93](https://github.com/zendframework/zend-http/pull/93) fixes the Content
  Security Policy CSP HTTP header when it is `none` (empty value).
- [#92](https://github.com/zendframework/zend-http/pull/92) fixes the flatten
  cookies value for array value (also multidimensional).
- [#34](https://github.com/zendframework/zend-http/pull/34) fixes the
  standard separator (&) for application/x-www-form-urlencoded.

## 2.5.5 - 2016-08-08

### Added

- [#44](https://github.com/zendframework/zend-http/pull/44),
  [#45](https://github.com/zendframework/zend-http/pull/45),
  [#46](https://github.com/zendframework/zend-http/pull/46),
  [#47](https://github.com/zendframework/zend-http/pull/47),
  [#48](https://github.com/zendframework/zend-http/pull/48), and
  [#49](https://github.com/zendframework/zend-http/pull/49) prepare the
  documentation for publication at https://zendframework.github.io/zend-http/

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#87](https://github.com/zendframework/zend-http/pull/87) fixes the
  `ContentLength` constructor to test for a non null value (vs a falsy value)
  before validating the value; this ensures 0 values may be specified for the
  length.
- [#85](https://github.com/zendframework/zend-http/pull/85) fixes infinite recursion
  on AbstractAccept. If you create a new Accept and try to call getFieldValue(),
  an infinite recursion and a fatal error happens.
- [#58](https://github.com/zendframework/zend-http/pull/58) avoid triggering a notice
  with special crafted accept headers. In the case the value of an accept header
  does not contain an equal sign, an "Undefined offset" notice is triggered.

## 2.5.4 - 2016-02-04

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#42](https://github.com/zendframework/zend-http/pull/42) updates dependencies
  to ensure it can work with PHP 5.5+ and 7.0+, as well as zend-stdlib
  2.5+/3.0+.

## 2.5.3 - 2015-09-14

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#23](https://github.com/zendframework/zend-http/pull/23) fixes a BC break
  introduced with fixes for [ZF2015-04](http://framework.zend.com/security/advisory/ZF2015-04),
  pertaining specifically to the `SetCookie` header. The fix backs out a
  check for message splitting syntax, as that particular class already encodes
  the value in a manner that prevents the attack. It also adds tests to ensure
  the security vulnerability remains patched.

## 2.5.2 - 2015-08-05

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#7](https://github.com/zendframework/zend-http/pull/7) fixes a call in the
  proxy adapter to `Response::extractCode()`, which does not exist, to
  `Response::fromString()->getStatusCode()`, which does.
- [#8](https://github.com/zendframework/zend-http/pull/8) ensures that the Curl
  client adapter enables the `CURLINFO_HEADER_OUT`, which is required to ensure
  we can fetch the raw request after it is sent.
- [#14](https://github.com/zendframework/zend-http/pull/14) fixes
  `Zend\Http\PhpEnvironment\Request` to ensure that empty `SCRIPT_FILENAME` and
  `SCRIPT_NAME` values which result in an empty `$baseUrl` will not raise an
  `E_WARNING` when used to do a `strpos()` check during base URI detection.
