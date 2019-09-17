<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\ConfigLoader\Config;
use Raptor\PHPMigrationHelper\ConfigLoader\RuleConfig;
use Raptor\PHPMigrationHelper\ConfigLoader\RuleConfigInterface;
use Raptor\PHPMigrationHelper\Processor\DirectoryProcessor;
use Raptor\PHPMigrationHelper\Rule\Rule;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;
use Raptor\TestUtils\WithVFSTrait;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class DirectoryProcessorTests extends TestCase
{
    use WithVFSTrait, WithDataLoaderTrait;

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ method is overridden */
    protected function setUp(): void
    {
        $this->setupVFS();
        $content = "regexp0\nregexp1\nregexp2\nregexp3\nregexp4\nregexp5\nregexp6\nregexp7\nregexp8\nregexp9";
        $structure = [
            'one' => ['file.php' => $content],
            'directory' => [
                'other.php' => $content,
                'bad.php' => $content,
                'good.php' => '',
                'text.txt' => $content,
            ],
            'folder' => ['one.txt' => $content, 'data.dat' => $content],
        ];
        $this->addStructureToVFS($structure);
    }

    /**
     * Checks that _process_ method returns correct compatibility report.
     *
     * @param TestDataContainer $dataContainer container with test data
     *
     * @dataProvider processDataProvider
     */
    public function testLoadLoadsRulesWithAppropriateVersionsOnly(TestDataContainer $dataContainer): void
    {
        /** @var \DirectoryProcessDataContainer $dataContainer */
        $rulConfigs = array_map([$this, 'parseRuleConfig'], $dataContainer->getRuleConfigs());
        $config = new Config([], $rulConfigs);
        $directoryProcessor = DirectoryProcessor::fromConfig($config);
        $path = $this->getFullPath($dataContainer->getDirectory());

        $actual = $directoryProcessor->process($path);

        static::assertSame($dataContainer->getExpectedResult(), $actual);
    }

    /**
     * Provides test data to test _process_ method.
     *
     * @return array
     */
    public function processDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/processor/directory_process.json');
    }

    /**
     * Returns RuleConfigInterface instance prepared from array in format
     * [ rules => [[ regexp => ... , recommendation => ... ], ... ], excluded => [ dir1, ... ] ], ... ]
     *
     * @param array $ruleConfigParams
     *
     * @return RuleConfigInterface
     */
    private function parseRuleConfig(array $ruleConfigParams): RuleConfigInterface
    {
        $rules = [];
        /** @var array $rules */
        $ruleParamsList = $ruleConfigParams['rules'] ?? [];
        foreach ($ruleParamsList as $ruleParams) {
            $rules[] = Rule::fromArray('some_rule', $ruleParams);
        }

        return new RuleConfig($rules, $ruleConfigParams['excluded'] ?? []);
    }
}
