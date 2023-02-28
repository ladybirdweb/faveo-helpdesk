# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

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
