# Changelog

## [0.3.0] - ????-??-??
### Added
 - `Request` class
### Removed
 - Request helpers - use the new `Request` wrapper class instead

## [0.2.0] - 2018-11-16
### Added
 - `ResponseSenderInterface` interface
 - `ResponseSender` class
 - Unit tests

### Changed
 - **BREAKING**: `psr/http-factory` is now used instead of the deprecated `http-interop/http-factory`.
 - **BREAKING**: `ResponseFactoryExceptionHandler` now needs an `ResponseSenderInterface` to work. 

## [0.1.0] - 2018-04-25
 - Initial release