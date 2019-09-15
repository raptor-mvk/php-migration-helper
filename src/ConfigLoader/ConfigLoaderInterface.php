<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

/**
 * Interface for config loader that loads rules config using given current and desired PHP versions.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface ConfigLoaderInterface
{
    /**
     * Loads rules config using given current and desired PHP versions
     *
     * @param string $versionFrom current PHP version
     * @param string $versionTo   desired PHP version
     *
     * @return array list of rules
     */
    public function load(string $versionFrom, string $versionTo): array;
}
