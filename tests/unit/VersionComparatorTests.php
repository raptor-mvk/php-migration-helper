<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\VersionComparator\RequiredPackageVersion;
use Raptor\PHPMigrationHelper\VersionComparator\VersionComparator;
use Raptor\TestUtils\ExtraAssertionsTrait;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;
use VersionComparatorDataContainer;
use function is_string;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class VersionComparatorTests extends TestCase
{
    use WithDataLoaderTrait, ExtraAssertionsTrait;

    /**
     * Checks that _verifyVersions_ method returns correct compatibility report.
     *
     * @dataProvider verifyVersionsDataProvider container with test data
     *
     * @param TestDataContainer $dataContainer
     */
    public function testFromArrayThrowsRuleExceptionWhenArrayIsIncorrect(TestDataContainer $dataContainer): void
    {
        /** @var VersionComparatorDataContainer $dataContainer */
        $versionComparator = new VersionComparator();
        $installedVersions = $dataContainer->getInstalledVersions();
        $mapper = static function ($arg) {
            if (is_string($arg)) {
                return new RequiredPackageVersion($arg);
            }

            return new RequiredPackageVersion($arg['version'] ?? '0.0', $arg['message'] ?? null);
        };
        $requiredVersions = array_map($mapper, $dataContainer->getRequiredVersions());

        $actual = $versionComparator->verifyVersions($installedVersions, $requiredVersions);

        static::assertArraysAreSame($dataContainer->getExpectedResult(), $actual);
    }

    /**
     * Provides data to test _verifyVersions_ method.
     *
     * @return array
     */
    public function verifyVersionsDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/version_comparator/version_comparator.json');
    }
}
