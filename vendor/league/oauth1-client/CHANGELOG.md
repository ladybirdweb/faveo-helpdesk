# Changelog

## v1.8.2

- Fixes an issue where the base string used to generate signatures did not account for non-standard ports.

## v1.8.1

- Reverts the public API changes introduced in v1.8.0 where language level type declarations and return types that were introduced caused inheritence to break.
- Fixes a Composer warning with relation to autoloading test files.

## v1.8.0

- We allow installation with Guzzle 6 **or** Guzzle 7.
- The minimum PHP version has been bumped from PHP 5.6 to 7.1.
