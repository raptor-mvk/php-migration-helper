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
use Raptor\PHPMigrationHelper\VersionComparator\VersionComparator;
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
        $rulesDir = [
            'config1.yml' => "version: '1.1'\n\nexcluded:\n  - package1\n  - package2\n  - package3\n\n".
                "rules:\n  rule1:\n    regexp: 'regexp11'\n    recommendation: 'str11'",
            'config2.yml' => "version: '2.2'\n\nexcluded:\n  - package1\n  - package3\n  - package4\n\n".
                "rules:\n  rule2:\n    regexp: 'regexp22'\n    recommendation: 'str22'",
            'config3.yml' => "version: '3.3'\n\nexcluded:\n  - package2\n  - package1\n  - package5\n\n".
                "rules:\n  rule3:\n    regexp: 'regexp33'\n    recommendation: 'str33'",
        ];
        $packagesDir = [
            'config1.yml' => "version: '1.1'\n\npackages:\n  package1: '1.1'\n  package2: 'use'\n  package3: '1.1'",
            'config2.yml' => "version: '2.2'\n\npackages:\n  package1: '1.2'\n  package3: 'err'\n  package4: '2.2'",
            'config3.yml' => "version: '3.3'\n\npackages:\n  package2: '1.3'\n  package1: '1.0'\n  package5: '3.3'",
        ];
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
        $configLoader = new ConfigLoader(new VersionComparator());
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
        $configLoader = new ConfigLoader(new VersionComparator());
        $versionFrom = $dataContainer->getVersionFrom();
        $versionTo = $dataContainer->getVersionTo();
        $expectedResult = $dataContainer->getExpectedResult();

        $config = $configLoader->load($this->getFullPath('/packages'), $versionFrom, $versionTo);

        static::assertArraysAreSameIgnoringOrder($expectedResult, $config->getRequiredPackageVersions());
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
