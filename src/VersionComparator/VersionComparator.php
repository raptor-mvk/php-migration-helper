<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\VersionComparator;

use Composer\Semver\Comparator;

/**
 * Verifies package versions and provides compatibility report.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class VersionComparator implements VersionComparatorInterface
{
    /**
     * Returns compatibility report in a line-per-element array.
     *
     * @param array $installedVersions array of installedVersions (from installed.json)
     * @param array $requiredVersions  array of requiredVersions
     *
     * @return array
     */
    public function verifyVersions(array $installedVersions, array $requiredVersions): array
    {
        $result = ['Package compatibility report:'];
        foreach ($installedVersions as $installedVersion) {
            if (isset($installedVersion['name'], $installedVersion['version'])) {
                $package = $installedVersion['name'];
                $requiredVersion = $requiredVersions[$package] ?? '0.0';
                if (Comparator::greaterThan($requiredVersion, $installedVersion['version'])) {
                    $result[] = "Update $package at least to {$requiredVersions[$package]}";
                }
            }
        }

        return (1 === count($result)) ? [] : $result;
    }
}
