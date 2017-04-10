# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.8.1 - 2016-06-23

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#92](https://github.com/zendframework/zend-validator/pull/92) adds message
  templates to the `ExcludeMimeType` validator, to allow differentiating
  validation error messages from the `MimeType` validator.

## 2.8.0 - 2016-05-16

### Added

- [#58](https://github.com/zendframework/zend-validator/pull/58) adds a new
  `Uuid` validator, capable of validating if Versions 1-5 UUIDs are well-formed.
- [#64](https://github.com/zendframework/zend-validator/pull/64) ports
  `Zend\ModuleManager\Feature\ValidatorProviderInterface` to
  `Zend\Validator\ValidatorProviderInterface`, and updates the `Module::init()`
  to typehint against the new interface instead of the one from
  zend-modulemanager. Applications targeting zend-mvc v3 can start updating
  their code to implement the new interface, or simply duck-type against it.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.7.3 - 2016-05-16

### Added

- [#67](https://github.com/zendframework/zend-validator/pull/67) adds support
  for Punycoded top-level domains in the `Hostname` validator.
- [#79](https://github.com/zendframework/zend-validator/pull/79) adds and
  publishes the documentation to https://zendframework.github.io/zend-validator/

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.7.2 - 2016-04-18

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#65](https://github.com/zendframework/zend-validator/pull/65) fixes the
  `Module::init()` method to properly receive a `ModuleManager` instance, and
  not expect a `ModuleEvent`.

## 2.7.1 - 2016-04-06

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- This release updates the TLD list to the latest version from the IANA.

## 2.7.0 - 2016-04-06

### Added

- [#63](https://github.com/zendframework/zend-validator/pull/63) exposes the
  package as a ZF component and/or generic configuration provider, by adding the
  following:
  - `ValidatorPluginManagerFactory`, which can be consumed by container-interop /
    zend-servicemanager to create and return a `ValidatorPluginManager` instance.
  - `ConfigProvider`, which maps the service `ValidatorManager` to the above
    factory.
  - `Module`, which does the same as `ConfigProvider`, but specifically for
    zend-mvc applications. It also provices a specification to
    `Zend\ModuleManager\Listener\ServiceListener` to allow modules to provide
    validator configuration.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 2.6.0 - 2016-02-17

### Added

- [#18](https://github.com/zendframework/zend-validator/pull/18) adds a `GpsPoint`
  validator for validating GPS coordinates.
- [#47](https://github.com/zendframework/zend-validator/pull/47) adds two new
  classes, `Zend\Validator\Isbn\Isbn10` and `Isbn13`; these classes are the
  result of an extract class refactoring, and contain the logic specific to
  calcualting the checksum for each ISBN style. `Zend\Validator\Isbn` now
  instantiates the appropriate one and invokes it.
- [#46](https://github.com/zendframework/zend-validator/pull/46) updates
  `Zend\Validator\Db\AbstractDb` to implement `Zend\Db\Adapter\AdapterAwareInterface`,
  by composing `Zend\Db\Adapter\AdapterAwareTrait`.

### Deprecated

- Nothing.

### Removed

- [#55](https://github.com/zendframework/zend-validator/pull/55) removes some
  checks for `safe_mode` within the `MimeType` validator, as `safe_mode` became
  obsolete starting with PHP 5.4.

### Fixed

- [#45](https://github.com/zendframework/zend-validator/pull/45) fixes aliases
  mapping the deprecated `Float` and `Int` validators to their `Is*` counterparts.
- [#49](https://github.com/zendframework/zend-validator/pull/49)
  [#50](https://github.com/zendframework/zend-validator/pull/50), and
  [#51](https://github.com/zendframework/zend-validator/pull/51) update the
  code to be forwards-compatible with zend-servicemanager and zend-stdlib v3.
- [#56](https://github.com/zendframework/zend-validator/pull/56) fixes the regex
  in the `Ip` validator to escape `.` characters used as IP delimiters.

## 2.5.4 - 2016-02-17

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#44](https://github.com/zendframework/zend-validator/pull/44) corrects the
  grammar on the `NOT_GREATER_INCLUSIVE` validation error message.
- [#45](https://github.com/zendframework/zend-validator/pull/45) adds normalized
  aliases for the i18n isfloat/isint validators.
- Updates the hostname validator regexes per the canonical service on which they
  are based.
- [#52](https://github.com/zendframework/zend-validator/pull/52) updates the
  `Barcode` validator to cast empty options passed to the constructor to an
  empty array, fixing type mismatch errors.
- [#54](https://github.com/zendframework/zend-validator/pull/54) fixes the IP
  address detection in the `Hostname` validator to ensure that IPv6 is detected
  correctly.
- [#56](https://github.com/zendframework/zend-validator/pull/56) updates the
  regexes used by the `IP` validator when comparing ipv4 addresses to ensure a
  literal `.` is tested between network segments.

## 2.5.3 - 2015-09-03

### Added

- [#30](https://github.com/zendframework/zend-validator/pull/30) adds tooling to
  ensure that the Hostname TLD list stays up-to-date as changes are pushed for
  the repository.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#17](https://github.com/zendframework/zend-validator/pull/17) and
  [#29](https://github.com/zendframework/zend-validator/pull/29) provide more
  test coverage, and fix a number of edge cases, primarily in validator option
  verifications.
- [#26](https://github.com/zendframework/zend-validator/pull/26) fixes tests for
  `StaticValidator` such that they make correct assertions now. In doing so, we
  determined that it was possible to pass an indexed array of options, which
  could lead to unexpected results, often leading to false positives when
  validating. To correct this situation, `StaticValidator::execute()` now raises
  an `InvalidArgumentException` when an indexed array is detected for the
  `$options` argument.
- [#35](https://github.com/zendframework/zend-validator/pull/35) modifies the
  `NotEmpty` validator to no longer treat the float `0.0` as an empty value for
  purposes of validation.
- [#25](https://github.com/zendframework/zend-validator/pull/25) fixes the
  `Date` validator to check against `DateTimeImmutable` and not
  `DateTimeInterface` (as PHP has restrictions currently on how the latter can
  be used).

## 2.5.2 - 2015-07-16

### Added

- [#8](https://github.com/zendframework/zend-validator/pull/8) adds a "strict"
  configuration option; when enabled (the default), the length of the address is
  checked to ensure it follows the specification.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#8](https://github.com/zendframework/zend-validator/pull/8) fixes bad
  behavior on the part of the `idn_to_utf8()` function, returning the original
  address in the case that the function fails.
- [#11](https://github.com/zendframework/zend-validator/pull/11) fixes
  `ValidatorChain::prependValidator()` so that it works on HHVM.
- [#12](https://github.com/zendframework/zend-validator/pull/12) adds "6772" to
  the Maestro range of the `CreditCard` validator.
