<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Processor;

use Iterator;
use Raptor\PHPMigrationHelper\ConfigLoader\ConfigInterface;
use Raptor\PHPMigrationHelper\ConfigLoader\RuleConfigInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;
use function strlen;

/**
 * Processes all files in the given directory recursively with the given rules.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class DirectoryProcessor implements DirectoryProcessorInterface
{
    /** @var FileProcessorInterface $fileProcessor */
    private $fileProcessor;

    /** @var ConfigInterface $config */
    private $config;

    /** @var int $processedFilesCount number of processed files */
    private $processedFilesCount;

    /** @var int $processedFilesCount number of processed files */
    private $problemFilesCount;

    /** @var string[] $currentReport report that has been collected while processing */
    private $currentReport;

    /** @var string[] $currentFileWasProcessed _true_ if current file under process was processed at least once */
    private $currentFileWasProcessed;

    /**
     * @param FileProcessorInterface $fileProcessor
     * @param ConfigInterface        $config
     */
    public function __construct(FileProcessorInterface $fileProcessor, ConfigInterface $config)
    {
        $this->fileProcessor = $fileProcessor;
        $this->config = $config;
    }

    /**
     * Creates directory processor from config.
     *
     * @param ConfigInterface $config
     *
     * @return DirectoryProcessorInterface
     */
    public static function fromConfig(ConfigInterface $config): DirectoryProcessorInterface
    {
        return new self(new FileProcessor(), $config);
    }

    /**
     * Processes all files in the given directory recursively and returns compatibility report or null if everything is
     * fine.
     *
     * @param string $path
     *
     * @return string[] strings for compatibility report
     */
    public function process(string $path): ?array
    {
        $this->init();
        $iterator = $this->prepareIterator($path);
        $pathLength = strlen($path) + (('/' === substr($path, -1)) ? 0 : 1);
        $ruleConfigs = $this->config->getRuleConfigs();
        foreach ($iterator as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            $unixPath = str_replace('\\', '/', $fileInfo->getPath());
            $filePath = "$unixPath/{$fileInfo->getFilename()}";
            $fileNameForReport = substr($filePath, $pathLength);
            $this->processFile($filePath, $ruleConfigs, $fileNameForReport);
        }

        return $this->getSummaryReport();
    }

    /**
     * Initializes temporary fields before processing.
     */
    private function init(): void
    {
        $this->processedFilesCount = 0;
        $this->problemFilesCount = 0;
        // add placeholder for processing results
        $this->currentReport = [''];
    }

    /**
     * Returns recursive directory iterator by the given path.
     *
     * @param string $path
     *
     * @return Iterator
     */
    private function prepareIterator(string $path): Iterator
    {
        $directoryIteratorFlags = RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::FOLLOW_SYMLINKS;
        $directoryIterator = new RecursiveDirectoryIterator($path, $directoryIteratorFlags);
        $mode = RecursiveIteratorIterator::LEAVES_ONLY;
        $recursiveIteratorFlags = RecursiveIteratorIterator::CATCH_GET_CHILD;
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, $mode, $recursiveIteratorFlags);

        return new RegexIterator($recursiveIterator, '/.*\.php/');
    }

    /**
     * Processes file, updates counters and add lines to the current report.
     *
     * @param string                $fileName          name of the file to be processed
     * @param RuleConfigInterface[] $ruleConfigs       rules and excluded directories
     * @param string                $fileNameForReport filename for the report
     */
    private function processFile(string $fileName, array $ruleConfigs, string $fileNameForReport): void
    {
        $this->currentFileWasProcessed = false;
        $report = [];
        foreach ($ruleConfigs as $ruleConfig) {
            if (!$this->shouldBeProcessed($ruleConfig, $fileNameForReport)) {
                continue;
            }
            $this->currentFileWasProcessed = true;
            $fileResult = $this->fileProcessor->process($fileName, $ruleConfig->getRules());
            if (null !== $fileResult) {
                $report[] = $fileResult;
                $report[] = ['--------------------------------------------------------------------------------'];
            }
        }
        $this->updateReportAndCounters($report, $fileNameForReport);
    }

    /**
     * Returns _true_ if file is not inside one of excluded directories and _false_ otherwise.
     *
     * @param RuleConfigInterface $ruleConfig
     * @param string              $fileName
     *
     * @return bool
     */
    private function shouldBeProcessed(RuleConfigInterface $ruleConfig, string $fileName): bool
    {
        foreach ($ruleConfig->getExcludedDirs() as $excludedDir) {
            if (0 === strcmp(substr($fileName, 0, strlen($excludedDir)), $excludedDir)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Updates counters, adds empty string into report if file has problems.
     *
     * @param array  $report   current file report
     * @param string $fileName
     */
    private function updateReportAndCounters(array $report, string $fileName): void
    {
        if (count($report) > 0) {
            array_pop($report);
            $this->currentReport[] =
                [$fileName, '================================================================================'];
            $this->currentReport[] = array_merge(...$report);
            $this->currentReport[] = ["\n"];
            $this->problemFilesCount++;
        }
        $this->processedFilesCount += (int) $this->currentFileWasProcessed;
    }

    /**
     * Returns summary report.
     *
     * @return string[]|null
     */
    private function getSummaryReport(): ?array
    {
        $processedSuffix = (1 === $this->processedFilesCount) ? '' : 's';
        $problemSuffix = (1 === $this->problemFilesCount) ? '' : 's';

        array_pop($this->currentReport);
        $this->currentReport[0] = ["Processed {$this->processedFilesCount} file{$processedSuffix}, ".
            "found {$this->problemFilesCount} file{$problemSuffix} with potential problems", ];

        return array_merge(...$this->currentReport);
    }
}
