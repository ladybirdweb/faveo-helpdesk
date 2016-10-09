# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.5.6 - TBD

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

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
