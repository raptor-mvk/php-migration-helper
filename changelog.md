#Changelog

All notable changes to this project will be documented in this file.

## [1.0.6](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.5...v1.0.6) - 2019-09-19
### Added

- Add acceptable versions of firebase/php-jwt, friendsofphp/php-cs-fixer,
  friendsofsymfony/rest-bundle

- Add acceptable versions of giggsey, google and guzzlehttp packages

### Changed

- Add warning messages for symfony/polyfill-phpXX packages instead of acceptable
  versions 

- Improve rule str_func for PHP 7.3

- Rule hash_functions for PHP 7.2 is divided into hash_functions and hash_init

## [1.0.5](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.4...v1.0.5) - 2019-09-18
### Added in 1.0.5
- Add some more acceptable versions of doctrine and symfony packages

## [1.0.4](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.3...v1.0.4) - 2019-09-18
### Added in 1.0.4
- Add acceptable versions of doctrine and symfony packages
- Add warning possibility for packages without acceptable versions

## [1.0.3](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.2...v1.0.3) - 2019-09-18
### Added in 1.0.3
- Add cloudinary/cloudinary_php package version
- Add `--no-vendor` option to command
- Add rules for migration to phpunit 8
### Changed in 1.0.3
- More specific str_func rule
### Removed in 1.0.3
- json_last_error rule from config73.yml

## [1.0.2](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.1...v1.0.2) - 2019-09-17
### Changed in 1.0.2
- Even more specific rules

## [1.0.1](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.0...v1.0.1) - 2019-09-17
### Changed in 1.0.1
- More specific rules
### Fixed in 1.0.1
- Error with v-prefixed versions of composer packages

## [1.0.0](https://github.com/raptor-mvk/php-migration-helper/releases/tag/v1.0.0) - 2019-09-17
### Added in 1.0.0
- Command `migration-report` that checks
  - package versions (phpunit/phpunit and symfony/monolog-bundle)
  - potential code problems while migrating from PHP 7.1 to 7.2 and 7.3
