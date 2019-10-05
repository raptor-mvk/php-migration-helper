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
     * @param array                    $installedVersions array of installedVersions (from installed.json)
     * @param RequiredPackageVersion[] $requiredVersions  array of requiredVersions
     *
     * @return array
     */
    public function verifyVersions(array $installedVersions, array $requiredVersions): array
    {
        $result = ['Package compatibility report:'];
        foreach ($installedVersions as $installedVersion) {
            if (isset($installedVersion['name'], $installedVersion['version'])) {
                $package = $installedVersion['name'];
                $requiredPackageVersion = $requiredVersions[$package] ?? null;
                $reportLine = $this->getReportLine($package, $requiredPackageVersion, $installedVersion['version']);
                if ($reportLine !== null) {
                    $result[] = $reportLine;
                }
            }
        }

        return (count($result) === 1) ? [] : $result;
    }

    /**
     * Returns report line for package if necessary or null otherwise.
     *
     * @param string                               $package
     * @param RequiredPackageVersionInterface|null $requiredPackageVersion
     * @param string                               $installedVersion
     *
     * @return string|null
     */
    private function getReportLine(string $package, ?RequiredPackageVersionInterface $requiredPackageVersion, string $installedVersion): ?string
    {
        if ($requiredPackageVersion === null) {
            return "Unknown package $package version $installedVersion";
        }
        $installedVersion = $this->normalizeVersion($installedVersion);
        $requiredVersion = $requiredPackageVersion->getVersion();
        $versionLine = Comparator::greaterThan($requiredVersion, $installedVersion) ?
            "Update $package at least to {$requiredVersion}" : null;

        return $this->glueReportLine($versionLine, $requiredPackageVersion->getMessage());
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

    /**
     * Returns line that concatenates $versionLine with $message using \n and is aware of possible null in both of them.
     *
     * @param string|null $versionLine
     * @param string|null $message
     *
     * @return string|null
     */
    private function glueReportLine(?string $versionLine, ?string $message): ?string
    {
        if ($versionLine === null) {
            return $message;
        }

        return ($message === null) ? $versionLine : "$versionLine\n$message";
    }
}
