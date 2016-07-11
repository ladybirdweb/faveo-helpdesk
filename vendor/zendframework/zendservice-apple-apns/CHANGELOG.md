# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

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
