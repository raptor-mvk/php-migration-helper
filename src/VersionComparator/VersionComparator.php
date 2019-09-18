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
final class VersionComparator implements VersionComparatorInterface
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
                $reportLine = $this->getReportLine($package, $requiredVersion, $installedVersion['version']);
                if (null !== $reportLine) {
                    $result[] = $reportLine;
                }
            }
        }

        return (1 === count($result)) ? [] : $result;
    }

    /**
     * Returns _true_ if version is real version and not a warning message and _false_ otherwise.
     *
     * @param string $version
     *
     * @return bool
     */
    public function isRealVersion(string $version): bool
    {
        return 1 === preg_match('/^\d+(\.\d+(\.\d+)?)?$/', $version);
    }

    /**
     * Returns report line for package if necessary or null otherwise.
     *
     * @param string $package
     * @param string $requiredVersion
     * @param string $installedVersion
     *
     * @return string|null
     */
    private function getReportLine(string $package, string $requiredVersion, string $installedVersion): ?string
    {
        $installedVersion = $this->normalizeVersion($installedVersion);
        if (!$this->isRealVersion($requiredVersion)) {
            return $requiredVersion;
        }

        return Comparator::greaterThan($requiredVersion, $installedVersion) ?
            "Update $package at least to {$requiredVersion}" : null;
    }

    /**
     * Returns normalized version of package.
     *
     * @param string $version
     *
     * @return string
     */
    private function normalizeVersion(string $version): string
    {
        $version = preg_replace('/^v?\.?/', '', $version);

        return $version;
    }
}
