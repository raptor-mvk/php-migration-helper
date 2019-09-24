<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\Command\MigrationReportCommand;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;
use Raptor\TestUtils\WithVFSTrait;
use Symfony\Component\Console\Tester\CommandTester;
use function is_array;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class MigrationReportCommandTests extends TestCase
{
    use WithVFSTrait, WithDataLoaderTrait;

    /** @noinspection PhpMissingParentCallCommonInspection __approved__ method is overridden */
    protected function setUp(): void
    {
        $this->setupVFS();
        $testFileContent = file_get_contents(__DIR__.'/../data/command/php.tst');
        $installedFileContent = file_get_contents(__DIR__.'/../data/command/installed.tst');
        $structureJson = file_get_contents(__DIR__.'/../data/command/structure.tst');
        $structure = json_decode($structureJson, true, 512, JSON_THROW_ON_ERROR);
        $contents = ['test.php' => $testFileContent, 'installed.json' => $installedFileContent];
        $structureWithContents = $this->addContentToStructure($structure, $contents);
        $this->addStructureToVFS($structureWithContents);
    }

    /**
     * Checks that _process_ method returns correct compatibility report.
     *
     * @param TestDataContainer $dataContainer container with test data
     *
     * @dataProvider commandDataProvider
     */
    public function testCommandCreatesCorrectReport(TestDataContainer $dataContainer): void
    {
        /** @var \CommandDataContainer $dataContainer */
        $command = new MigrationReportCommand($this->getFullPath(''));
        $commandTester = new CommandTester($command);
        $outputPath = $this->getFullPath('report.txt');
        $params = ['from' => $dataContainer->getVersionFrom(), 'to' => $dataContainer->getVersionTo()] +
            ['report' => $outputPath] + ($dataContainer->getOptions() ?? []);

        $commandTester->execute($params);

        static::assertSame(implode("\n", $dataContainer->getExpectedResult()), file_get_contents($outputPath));
    }

    /**
     * Provides test data to test the command.
     *
     * @return array
     */
    public function commandDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/command/command.json');
    }

    /**
     * Recursively parse structure and put content to files. Returns updated structure.
     *
     * @param array|null $structure
     * @param array      $contents
     *
     * @return array|null
     */
    private function addContentToStructure(?array $structure, array $contents): ?array
    {
        if (!is_array($structure)) {
            return $structure;
        }
        $result = [];
        foreach ($structure as $folder => $file) {
            $result[$folder] = $contents[$folder] ?? $this->addContentToStructure($file, $contents);
        }

        return $result;
    }
}
