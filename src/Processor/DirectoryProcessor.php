<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Processor;

use Iterator;
use Raptor\PHPMigrationHelper\Rule\RuleInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

/**
 * Processes all files in the given directory recursively with the given rules.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class DirectoryProcessor implements DirectoryProcessorInterface
{
    /** @var FileProcessorInterface $fileProcessor */
    private $fileProcessor;

    /**
     * @param FileProcessorInterface $fileProcessor
     */
    public function __construct(FileProcessorInterface $fileProcessor)
    {
        $this->fileProcessor = $fileProcessor;
    }

    /**
     * Processes all files in the given directory recursively with the given rules and returns compatibility report or
     * null if everything is fine.
     *
     * @param string $path
     * @param RuleInterface[] $rules array of rules applied to each file
     *
     * @return string[]|null strings for compatibility report if needed, or null otherwise
     */
    public function process(string $path, array $rules): ?array
    {
        $iterator = $this->prepareIterator($path);
        // add placeholder for processing results
        $result = [''];
        $processedFilesCount = 0;
        $problemFilesCount = 0;
        foreach ($iterator as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            $unixPath = str_replace('\\', '/', $fileInfo->getPath());
            $filePath = "$unixPath/{$fileInfo->getFilename()}";
            $fileResult = $this->fileProcessor->process($filePath, $rules);
            if (null !== $fileResult) {
                $result[] = $fileResult;
                $result[] = ["\n"];
                $problemFilesCount++;
            }
            $processedFilesCount++;
        }
        array_pop($result);
        $result[0] = [$this->getSummary($processedFilesCount, $problemFilesCount)];

        return array_merge(...$result);
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
     * Returns summary for report based on number of processed files and number of files with potential problems.
     *
     * @param int $processedFilesCount
     * @param int $problemFilesCount
     *
     * @return string
     */
    private function getSummary(int $processedFilesCount, int $problemFilesCount): string
    {
        $processedSuffix = (1 === $processedFilesCount) ? '' : 's';
        $problemSuffix = (1 === $problemFilesCount) ? '' : 's';
        return "Processed $processedFilesCount file{$processedSuffix}, ".
            "found $problemFilesCount file{$problemSuffix} with potential problems";
    }
}