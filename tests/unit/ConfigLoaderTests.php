<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\ConfigLoader\ConfigLoader;
use Raptor\PHPMigrationHelper\Rule\RuleInterface;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;
use Raptor\TestUtils\WithVFSTrait;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class ConfigLoaderTests extends TestCase
{
    use WithVFSTrait, WithDataLoaderTrait;

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ method is overridden */
    protected function setUp()
    {
        $this->setupVFS();
        $structure = [
            'rules11.yml' => "version: 1.1\n\nrules:\n  rule1:\n    regexp: 'regexp11'\n    recommendation: 'string11'",
            'rules22.yml' => "version: 2.2\n\nrules:\n  rule2:\n    regexp: 'regexp22'\n    recommendation: 'string22'",
            'rules33.yml' => "version: 3.3\n\nrules:\n  rule3:\n    regexp: 'regexp33'\n    recommendation: 'string33'",
        ];
        $this->addStructureToVFS($structure);
    }

    /**
     * Checks that _load_ method loads rules from files with appropriate versions only.
     *
     * @param TestDataContainer $dataContainer container with test data
     *
     * @dataProvider loadDataProvider
     */
    public function testLoadLoadsRulesWithAppropriateVersionsOnly(TestDataContainer $dataContainer): void
    {
        /** @var \LoadDataContainer $dataContainer */
        $configLoader = new ConfigLoader();
        $versionFrom = $dataContainer->getVersionFrom();
        $versionTo = $dataContainer->getVersionTo();
        $mapper = static function (RuleInterface $arg) {
            return $arg->getRegExp();
        };

        $rules = $configLoader->load($this->getFullPath('/'), $versionFrom, $versionTo);

        static::assertSame($dataContainer->getExpectedResult(), array_map($mapper, $rules));
    }

    /**
     * Provides test data to test _load_ method.
     *
     * @return array
     */
    public function loadDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/config_loader/load.json');
    }
}
