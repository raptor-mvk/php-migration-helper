<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\ConfigLoader\ConfigLoader;
use Raptor\PHPMigrationHelper\ConfigLoader\RuleConfigInterface;
use Raptor\PHPMigrationHelper\VersionComparator\RequiredPackageVersionInterface;
use Raptor\TestUtils\ExtraAssertionsTrait;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;
use Raptor\TestUtils\WithVFSTrait;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class ConfigLoaderTests extends TestCase
{
    use WithVFSTrait, WithDataLoaderTrait, ExtraAssertionsTrait;

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ method is overridden */
    protected function setUp(): void
    {
        $this->setupVFS();
        $rulesJson = file_get_contents(__DIR__.'/../data/config_loader/rules.tst');
        $rulesDir = json_decode($rulesJson, true, 512, JSON_THROW_ON_ERROR);
        $packagesJson = file_get_contents(__DIR__.'/../data/config_loader/packages.tst');
        $packagesDir = json_decode($packagesJson, true, 512, JSON_THROW_ON_ERROR);
        $structure = ['rules' => $rulesDir, 'packages' => $packagesDir];
        $this->addStructureToVFS($structure);
    }

    /**
     * Checks that _load_ method loads rule configs from files with appropriate versions only.
     *
     * @param TestDataContainer $dataContainer container with test data
     *
     * @dataProvider loadRulesDataProvider
     */
    public function testLoadLoadsRuleConfigsWithAppropriateVersionsOnly(TestDataContainer $dataContainer): void
    {
        /** @var \LoadRuleConfigsDataContainer $dataContainer */
        $configLoader = new ConfigLoader();
        $versionFrom = $dataContainer->getVersionFrom();
        $versionTo = $dataContainer->getVersionTo();

        $config = $configLoader->load($this->getFullPath('/rules'), $versionFrom, $versionTo);

        $actual = array_map([$this, 'ruleConfigToArray'], $config->getRuleConfigs());
        static::assertSame($dataContainer->getExpectedResult(), $actual);
    }

    /**
     * Provides test data with rule configs to test _load_ method.
     *
     * @return array
     */
    public function loadRulesDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/config_loader/load_rule_configs.json');
    }

    /**
     * Checks that _load_ method loads packages from files with appropriate versions only.
     *
     * @param TestDataContainer $dataContainer container with test data
     *
     * @dataProvider loadPackagesDataProvider
     */
    public function testLoadLoadsPackagesWithAppropriateVersionsOnly(TestDataContainer $dataContainer): void
    {
        /** @var \LoadPackagesDataContainer $dataContainer */
        $configLoader = new ConfigLoader();
        $versionFrom = $dataContainer->getVersionFrom();
        $versionTo = $dataContainer->getVersionTo();
        $expectedResult = $dataContainer->getExpectedResult();
        $mapper = static function (RequiredPackageVersionInterface $arg) {
            return ['version' => $arg->getVersion(), 'message' => $arg->getMessage()];
        };

        $config = $configLoader->load($this->getFullPath('/packages'), $versionFrom, $versionTo);

        $actual = array_map($mapper, $config->getRequiredPackageVersions());
        static::assertArraysAreSameIgnoringOrder($expectedResult, $actual);
    }

    /**
     * Provides test data with packages to test _load_ method.
     *
     * @return array
     */
    public function loadPackagesDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/config_loader/load_packages.json');
    }

    /**
     * Returns array representation of rule config.
     *
     * @param RuleConfigInterface $ruleConfig
     *
     * @return array
     */
    private function ruleConfigToArray(RuleConfigInterface $ruleConfig): array
    {
        $result['rules'] = [];
        $rules = $ruleConfig->getRules();
        foreach ($rules as $rule) {
            $result['rules'][] = $rule->getRegExp();
        }
        $result['excluded'] = $ruleConfig->getExcludedDirs();

        return $result;
    }
}
