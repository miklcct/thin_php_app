# Changelog
## [0.6.2] - 2022-12-21
 - allow the use of ralouphie/getallheaders version 3

## [0.6.1] - 2021-10-05
 - PHP 8 compatibility
 
## [0.5.0] - 2020-02-24
### Changed
 - **BREAKING**: `json` now throws `JsonException` instead of `InvalidArgumentException`
 if the supplied argument cannot be properly represented as JSON.
 A polyfill has been added to support this pre PHP 7.3.
 - **BREAKING**: The constructors of `ServerRequest` and `MiddlewareApplication` are now final because other methods
 are using `new static` to call them.
 - `PhpTemplate` now closes its output buffering properly even when there is an exception when rendering the template.

## [0.4.0] - 2019-12-12
### Changed
 - **BREAKING**: `nullable` no longer accepts the third parameter - use `??` after
   the `nullable` call to specify the default value when the value is `NULL`
   such that it is evaluated only when it is `NULL`.

## [0.3.0] - 2018-11-21
### Added
 - `ServerRequest` class
### Changed
 - `nullable` now accepts a parameter which is used as the return value when the value is `NULL`
### Removed
 - Request helpers - use the new `ServerRequest` wrapper class instead

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
