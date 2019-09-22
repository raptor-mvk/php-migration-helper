<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\VersionComparator;

/**
 * Interface for class that verifies package versions.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface VersionComparatorInterface
{
    /**
     * Returns compatibility report in a line-per-element array.
     *
     * @param array $installedVersions array of installedVersions (from installed.json)
     * @param array $requiredVersions  array of requiredVersions
     *
     * @return array
     */
    public function verifyVersions(array $installedVersions, array $requiredVersions): array;
}
