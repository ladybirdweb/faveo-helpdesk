# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.1.0 - 2018-05-08

### Added

- [#35](https://github.com/zendframework/ZendService_Google_Gcm/pull/35) adds support for PHP 7.1 and 7.2.

- [#13](https://github.com/zendframework/ZendService_Google_Gcm/pull/13) adds constants mapping to common GCM error codes as `ZendService\Gcm\Response::ERROR_*`.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- [#35](https://github.com/zendframework/ZendService_Google_Gcm/pull/35) removes support for PHP 5.5.

- [#35](https://github.com/zendframework/ZendService_Google_Gcm/pull/35) removes support for HHVM.

### Fixed

- [#18](https://github.com/zendframework/ZendService_Google_Gcm/pull/18) adds a `Content-Length` header with the message length prior to sending
  messages to GCM; this fixes 411 errors previously observed.

## 2.0.0 - 2017-01-17

### Added

- [#27](https://github.com/zendframework/ZendService_Google_Gcm/pull/27) PSR-4 schema
- [#27](https://github.com/zendframework/ZendService_Google_Gcm/pull/27) PHP >= 5.5 & 7
- [#20](https://github.com/zendframework/ZendService_Google_Gcm/pull/25) Notification and priority parameters for FCM

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#27](https://github.com/zendframework/ZendService_Google_Gcm/pull/27) Fix travis CI integration
- [#27](https://github.com/zendframework/ZendService_Google_Gcm/pull/27) Fix coding style (use ::class and short arrays)
- [#27](https://github.com/zendframework/ZendService_Google_Gcm/pull/27) Fix docblocks for IDE integration
- [#20](https://github.com/zendframework/ZendService_Google_Gcm/pull/25) Change endpoint to FCM

## 1.0.3 - 2015-10-13

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#12](https://github.com/zendframework/ZendService_Google_Gcm/pull/12) -
  Updated GCM URL.
