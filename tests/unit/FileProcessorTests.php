<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\Processor\FileProcessor;
use Raptor\PHPMigrationHelper\Rule\Rule;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;
use Raptor\TestUtils\WithVFSTrait;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class FileProcessorTests extends TestCase
{
    use WithVFSTrait, WithDataLoaderTrait;

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ method is overridden */
    protected function setUp()
    {
        $this->setupVFS();
        $content = "regexp0\nregexp1\nregexp2\nregexp3\nregexp4\nregexp5\nregexp6\nregexp7\nregexp8\nregexp9";
        $this->addFileToVFS('file.php', null, $content);
        $this->addFileToVFS('other.php', null, $content);
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
        /** @var \FileProcessDataContainer $dataContainer */
        $fileProcessor = new FileProcessor();
        $ruleMapper = static function (array $ruleParams) {
            return Rule::fromArray('some rule', $ruleParams);
        };
        $rules = array_map($ruleMapper, $dataContainer->getRules());
        $fileName = $this->getFullPath($dataContainer->getFilename());

        $actual = $fileProcessor->process($fileName, $rules, $dataContainer->getReportFilename());

        static::assertSame($dataContainer->getExpectedResult(), $actual);
    }

    /**
     * Provides test data to test _process_ method.
     *
     * @return array
     */
    public function processDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/processor/file_process.json');
    }
}
