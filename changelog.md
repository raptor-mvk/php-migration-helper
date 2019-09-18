#Changelog

All notable changes to this project will be documented in this file.

## [1.0.3](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.2...v1.0.3) - 2019-09-18
### Added
- Add cloudinary/cloudinary_php package version
- Add `--no-vendor` option to command
- Add rules for migration to phpunit 8
### Changed
- More specific str_func rule
### Removed
- json_last_error rule from config73.yml

## [1.0.2](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.1...v1.0.2) - 2019-09-17
### Changed
- Even more specific rules

## [1.0.1](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.0...v1.0.1) - 2019-09-17
### Changed
- More specific rules
### Fixed
- Error with v-prefixed versions of composer packages

## [1.0.0](https://github.com/raptor-mvk/php-migration-helper/releases/tag/v1.0.0) - 2019-09-17
### Added
- Command `migration-report` that checks
  - package versions (phpunit/phpunit and symfony/monolog-bundle)
  - potential code problems while migrating from PHP 7.1 to 7.2 and 7.3
