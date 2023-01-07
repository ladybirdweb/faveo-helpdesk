# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 3.1.2 - 2019-10-09

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#46](https://github.com/zendframework/zend-json/pull/46) changes
  curly braces in array and string offset access to square brackets
  in order to prevent issues under the upcoming PHP 7.4 release.

- [#37](https://github.com/zendframework/zend-json/pull/37) fixes
  output of `\Zend\Json::prettyPrint` to not remove spaces after
  commas in value.

## 3.1.1 - 2019-06-18

### Added

- [#44](https://github.com/zendframework/zend-json/pull/44) adds support for PHP 7.3.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.1.0 - 2018-01-04

### Added

- [#35](https://github.com/zendframework/zend-json/pull/35) and
  [#39](https://github.com/zendframework/zend-json/pull/39) add support for PHP
  7.1 and PHP 7.2.

### Deprecated

- Nothing.

### Removed

- [#35](https://github.com/zendframework/zend-json/pull/35) removes support for
  PHP 5.5.

- [#35](https://github.com/zendframework/zend-json/pull/35) removes support for
  HHVM.

### Fixed

- [#38](https://github.com/zendframework/zend-json/pull/38) provides a fix to
  `Json::prettyPrint()` to ensure that empty arrays and objects are printed
  without newlines.

- [#38](https://github.com/zendframework/zend-json/pull/38) provides a fix to
  `Json::prettyPrint()` to remove additional newlines preceding a closing
  bracket.

## 3.0.0 - 2016-03-31

### Added

- [#21](https://github.com/zendframework/zend-json/pull/21) adds documentation
  and publishes it to https://zendframework.github.io/zend-json/

### Deprecated

- Nothing.

### Removed

- [#20](https://github.com/zendframework/zend-json/pull/20) removes the
  `Zend\Json\Server` subcomponent, which has been extracted to
  [zend-json-server](https://zendframework.github.io/zend-json-server/).
  If you use that functionality, install the new component.
- [#21](https://github.com/zendframework/zend-json/pull/21) removes the
  `Zend\Json\Json::fromXml()` functionality, which has been extracted to
  [zend-xml2json](https://zendframework.github.io/zend-xml2json/). If you used
  this functionality, you will need to install the new package, and rewrite
  calls to `Zend\Json\Json::fromXml()` to `Zend\Xml2Json\Xml2Json::fromXml()`.
- [#20](https://github.com/zendframework/zend-json/pull/20) and
  [#21](https://github.com/zendframework/zend-json/pull/21) removes dependencies
  on zendframework/zendxml, zendframework/zend-stdlib,
  zendframework/zend-server, and zendframework-zend-http, due to the above
  listed component extractions.

### Fixed

- Nothing.

## 2.6.1 - 2016-02-04

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#18](https://github.com/zendframework/zend-json/pull/18) updates dependencies
  to allow usage on PHP 7, as well as with zend-stdlib v3.

## 2.6.0 - 2015-11-18

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- [#5](https://github.com/zendframework/zend-json/pull/5) removes
  zendframework/zend-stdlib as a required dependency, marking it instead
  optional, as it is only used for the `Server` subcomponent.

### Fixed

- Nothing.

## 2.5.2 - 2015-08-05

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#3](https://github.com/zendframework/zend-json/pull/3) fixes an array key
  name from `intent` to `indent` to  ensure indentation works correctly during
  pretty printing.
