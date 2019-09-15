<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

use Raptor\PHPMigrationHelper\Rule\Rule;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Yaml;

/**
 * Loads rules config using given current and desired PHP versions.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class ConfigLoader
{
    /**
     * Loads rules config using given current and desired PHP versions
     *
     * @param string $directory   directory with rules
     * @param string $versionFrom current PHP version
     * @param string $versionTo   desired PHP version
     *
     * @return array loaded rules
     */
    public function load(string $directory, string $versionFrom, string $versionTo): array
    {
        $result = [];
        $rulesData = $this->loadRuleFiles($directory);
        foreach ($rulesData as $rulesDatum) {
            if (($rulesDatum['version'] > $versionFrom) && ($rulesDatum['version'] <= $versionTo)) {
                /** @var array $rules */
                $rules = $rulesDatum['rules'];
                foreach ($rules as $ruleName => $ruleParams) {
                    $result[] = Rule::fromArray($ruleName, $ruleParams);
                }
            }
        }

        return $result;
    }

    /**
     * Iterates over YAML files in specified directory and return array with loaded rules.
     *
     * @param string $directory
     *
     * @return array loaded rules
     */
    private function loadRuleFiles(string $directory): array
    {
        $directoryIteratorFlags = RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::FOLLOW_SYMLINKS;
        $directoryIterator = new RecursiveDirectoryIterator($directory, $directoryIteratorFlags);
        $mode = RecursiveIteratorIterator::LEAVES_ONLY;
        $recursiveIteratorFlags = RecursiveIteratorIterator::CATCH_GET_CHILD;
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, $mode, $recursiveIteratorFlags);
        $iterator = new RegexIterator($recursiveIterator, '/.*\.yml/');
        $result = [];
        foreach ($iterator as $fileInfo) {
            /** @var SplFileInfo $fileInfo */
            $unixPath = str_replace('\\', '/', $fileInfo->getPath());
            $filePath = "$unixPath/{$fileInfo->getFilename()}";
            $result[] = Yaml::parseFile($filePath);
        }

        return $result;
    }
}
