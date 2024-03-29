# Raptor PHP migration helper

[![Build Status](https://travis-ci.org/raptor-mvk/php-migration-helper.svg?branch=master)](https://travis-ci.org/raptor-mvk/php-migration-helper)
[![Code Coverage](https://codecov.io/gh/raptor-mvk/php-migration-helper/branch/master/graph/badge.svg)](https://codecov.io/gh/raptor-mvk/php-migration-helper)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/989ea4b1eb4a4d7a806b3a2b973dd950)](https://www.codacy.com/app/raptor-mvk/php-migration-helper)
[![Latest Stable Version](https://img.shields.io/github/release/raptor-mvk/php-migration-helper.svg)](https://github.com/raptor-mvk/php-migration-helper/releases/latest)
[![License](https://img.shields.io/github/license/raptor-mvk/php-migration-helper.svg)](https://github.com/raptor-mvk/php-migration-helper)

(c) Mikhail Kamorin aka raptor_MVK

## Overview

Helper contains command `php-migration-helper` that checks your project for
changes in PHP 7.2 and 7.3 that break backward compatibility. The report is
provided as result of command execution.

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require --dev raptor/php-migration-helper:^1.0 --prefer-dist
```

## Usage

1. Install package.

1. Run command (`VERSION_FROM` is current PHP version, `VERSION_TO` is desired
   PHP version and `REPORT_FILE` is path to the file with compatibility record):

   ```sh
   php vendor/raptor/php-migration-helper/migration-report VERSION_FROM VERSION_TO REPORT_FILE
   ```

1. If you do not want to process vendor folder, you can use `--no-vendor`
   option.

1. View compatibility report. If it contains records from vendor path that need
   correction, please, make PR into [this repository](https://github.com/raptor-mvk/php-migration-helper)
   (fix `src/Resources/configs/configXX.yml` with appropriate version) with
   correct minimal version of the package under consideration.

1. Fix mentions that are really problems

1. Remove package.

## Authors
- Mikhail Kamorin aka raptor_MVK
