#Changelog

All notable changes to this project will be documented in this file.

## [1.0.6](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.5-dev...v1.0.6-dev) - 2019-09-21
### Added
- Add acceptable versions of many tested packages

### Changed

- Add warning messages for symfony/polyfill-phpXX packages instead of acceptable
  versions 

- Improve rule str_func for PHP 7.3

- Rule hash_functions for PHP 7.2 is divided into hash_functions and hash_init

## [1.0.5](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.4-dev...v1.0.5-dev) - 2019-09-18
### Added in 1.0.5
- Add some more acceptable versions of doctrine and symfony packages

## [1.0.4](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.3-dev...v1.0.4-dev) - 2019-09-18
### Added in 1.0.4
- Add acceptable versions of doctrine and symfony packages
- Add warning possibility for packages without acceptable versions

## [1.0.3](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.2-dev...v1.0.3-dev) - 2019-09-18
### Added in 1.0.3
- Add cloudinary/cloudinary_php package version
- Add `--no-vendor` option to command
- Add rules for migration to phpunit 8
### Changed in 1.0.3
- More specific str_func rule
### Removed in 1.0.3
- json_last_error rule from config73.yml

## [1.0.2](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.1-dev...v1.0.2-dev) - 2019-09-17
### Changed in 1.0.2
- Even more specific rules

## [1.0.1](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.0-dev...v1.0.1-dev) - 2019-09-17
### Changed in 1.0.1
- More specific rules
### Fixed in 1.0.1
- Error with v-prefixed versions of composer packages

## [1.0.0](https://github.com/raptor-mvk/php-migration-helper/releases/tag/v1.0.0-dev) - 2019-09-17
### Added in 1.0.0
- Command `migration-report` that checks
  - package versions (phpunit/phpunit and symfony/monolog-bundle)
  - potential code problems while migrating from PHP 7.1 to 7.2 and 7.3
