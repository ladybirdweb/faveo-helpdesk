# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.4.1 - 2019-03-14

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#66](https://github.com/zendframework/ZendService_Apple_Apns/pull/66) fixes the schemes used for feedback notification URLs, to ensure they
  reference `tlsv1.2` specifically.

## 1.4.0 - 2019-03-13

### Added

- Nothing.

### Changed

- [#65](https://github.com/zendframework/ZendService_Apple_Apns/pull/65) changes the URI schemes used to push messages from `tls` to `tlsv1.2` due
  to a change in TLS versions supported by the endpoints.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.3.1 - 2019-02-07

### Added

- [#64](https://github.com/zendframework/ZendService_Apple_Apns/pull/64) adds support for PHP 7.3.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.3.0 - 2018-05-08

### Added

- [#63](https://github.com/zendframework/ZendService_Apple_Apns/pull/63) adds support for PHP 7.1 and 7.2.

- [#53](https://github.com/zendframework/ZendService_Apple_Apns/pull/53) adds support for the mutable-content Notification field within the `Message` implementation.

- [#48](https://github.com/zendframework/ZendService_Apple_Apns/pull/48) adds two new methods to `ZendService\Apple\Apns\Message\Alert`: `setAction($key)` and `getAction()`.
  These allow specifying an action property for notifications.

### Changed

- [#42](https://github.com/zendframework/ZendService_Apple_Apns/pull/42) modifies the allowed character set for tokens to include uppercase A-F.

### Deprecated

- Nothing.

### Removed

- [#63](https://github.com/zendframework/ZendService_Apple_Apns/pull/63) removes support for PHP 5.3, 5.4, and 5.5.

- [#63](https://github.com/zendframework/ZendService_Apple_Apns/pull/63) removes support for HHVM.

### Fixed

- [#49](https://github.com/zendframework/ZendService_Apple_Apns/pull/49) fixes how `Message::getPayload()` and `Message::getPayloadJson()` create a
  representation of the `aps` key when it is an empty value. With #18, the value was removed,
  which was incorrect; it is not rendered as an empty object.

- [#62](https://github.com/zendframework/ZendService_Apple_Apns/pull/62) modifies the `AbstractClient::connect()` method such that it now
  restores the previous error handler after catching a socket-related connection exception.

## 1.2.0 - 2015-12-09

### Added

- [#36](https://github.com/zendframework/ZendService_Apple_Apns/pull/36)
  Conection failures now raise a ```RuntimeException``` to allow you to catch
  stream_socket_client(): SSL: Connection reset by peer warnings.
- [#39](https://github.com/zendframework/ZendService_Apple_Apns/pull/39) Add
  safari push support

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.1.2 - 2015-12-09

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#40](https://github.com/zendframework/ZendService_Apple_Apns/pull/40) Add
  missing return $this

## 1.1.1 - 2015-10-13

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#38](https://github.com/zendframework/ZendService_Apple_Apns/pull/38) Fix
  apns error response when sending a message.
- [#34](https://github.com/zendframework/ZendService_Apple_Apns/pull/34) Fixed
  unit tests execution on travis

## 1.1.0 - 2015-07-29

### Added

- [#27](https://github.com/zendframework/ZendService_Apple_Apns/pull/27) Adds in
  ANS category support.
- [#29](https://github.com/zendframework/ZendService_Apple_Apns/pull/29) Add in
  ANS title, title-loc-key and title-loc-args.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#26](https://github.com/zendframework/ZendService_Apple_Apns/pull/26) Fixes a
  possible infinity fread in certain PHP versions.
- [#28](https://github.com/zendframework/ZendService_Apple_Apns/pull/28) Fixed docblocks
  that prevented proper code completion in some editors.
- [#29](https://github.com/zendframework/ZendService_Apple_Apns/pull/29) Force
  TLS vs. SSL due to [Apple moving to TLS](https://developer.apple.com/news/?id=10222014a).
