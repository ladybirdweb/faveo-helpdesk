CHANGELOG
=========

0.2.0 (2016-06-10)
------------------

* Added handling of additional error codes that the web service may return.
* A `USER_ID_UNKNOWN` error will now throw a
  `MaxMind\Exception\AuthenticationException`.
* Added support for `proxy` option. Closes #6.

0.1.0 (2016-05-23)
------------------

* A `PERMISSION_REQUIRED` error will now throw a `PermissionRequiredException`
  exception.
* Added a `.gitattributes` file to exclude tests from Composer releases.
  GitHub #7.
* Updated included cert bundle.

0.0.4 (2015-07-21)
------------------

* Added extremely basic tests for the curl calls.
* Fixed broken POSTs.

0.0.3 (2015-06-30)
------------------

* Floats now work with the `timeout` and `connectTimeout` options. Fix by
  Benjamin Pick. GitHub PR #2.
* `curl_error` is now used instead of `curl_strerror`. The latter is only
  available for PHP 5.5 or later. Fix by Benjamin Pick. GitHub PR #1.


0.0.2 (2015-06-09)
------------------

* An exception is now immediately thrown curl error rather than letting later
  status code checks throw an exception. This improves the exception message
  greatly.
* If this library is inside a phar archive, the CA certs are copied out of the
  archive to a temporary file so that curl can use them.

0.0.1 (2015-06-01)
------------------

* Initial release.
