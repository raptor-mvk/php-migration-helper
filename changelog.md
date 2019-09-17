#Changelog

All notable changes to this project will be documented in this file.

## [1.1.0](https://github.com/raptor-mvk/php-migration-helper/compare/v1.0.0...v1.1.0) - 2019-09-17
### Changed
- Change symfony/console version to ^3.0|^4.0 for better compatibility

## [1.0.0](https://github.com/raptor-mvk/php-migration-helper/releases/tag/v1.0.0) - 2019-09-17
### Added
- Command `migration-report` that checks
  - package versions (phpunit/phpunit and symfony/monolog-bundle)
  - potential code problems while migrating from PHP 7.1 to 7.2 and 7.3
