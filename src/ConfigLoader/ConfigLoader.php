<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

use Composer\Semver\Comparator;
use Raptor\PHPMigrationHelper\Rule\Rule;
use Raptor\PHPMigrationHelper\Rule\RuleInterface;
use Raptor\PHPMigrationHelper\VersionComparator\VersionComparatorInterface;
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
final class ConfigLoader
{
    /** @var array $currentPackages array of currently loaded required versions of packages */
    private $currentPackages;

    /** @var RuleConfigInterface[] $currentRuleConfigs array of currently loaded rule configs */
    private $currentRuleConfigs;

    /** @var VersionComparatorInterface $versionComparator */
    private $versionComparator;

    /**
     * @param VersionComparatorInterface $versionComparator
     */
    public function __construct(VersionComparatorInterface $versionComparator)
    {
        $this->versionComparator = $versionComparator;
    }

    /**
     * Loads config using given current and desired PHP versions
     *
     * @param string $directory   directory with rules
     * @param string $versionFrom current PHP version
     * @param string $versionTo   desired PHP version
     *
     * @return ConfigInterface loaded config
     */
    public function load(string $directory, string $versionFrom, string $versionTo): ConfigInterface
    {
        $this->init();
        $rulesData = $this->loadRuleFiles($directory);
        foreach ($rulesData as $rulesDatum) {
            if (Comparator::greaterThan($rulesDatum['version'], $versionFrom) &&
                Comparator::lessThanOrEqualTo($rulesDatum['version'], $versionTo)) {
                $rules = $this->parseRules($rulesDatum['rules'] ?? []);
                $ruleConfig = new RuleConfig($rules, $rulesDatum['excluded'] ?? []);
                $this->currentRuleConfigs[] = $ruleConfig;
                $this->updatePackages($rulesDatum['packages'] ?? []);
            }
        }

        return new Config($this->currentPackages, $this->currentRuleConfigs);
    }

    /**
     * Initializes empty loaded arrays.
     */
    private function init(): void
    {
        $this->currentPackages = [];
        $this->currentRuleConfigs = [];
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

    /**
     * Parses array of rule parameters and return array of RuleInterface instances.
     *
     * @param array $rulesData array of rule parameters in format [ rule => rule_params ]
     *
     * @return RuleInterface[]
     */
    private function parseRules(array $rulesData): array
    {
        $rules = [];
        foreach ($rulesData as $ruleName => $ruleParams) {
            $rules[] = Rule::fromArray($ruleName, $ruleParams);
        }

        return $rules;
    }

    /**
     * Updates current array of required versions of packages.
     *
     * @param array $packages array of required versions of packages in format [ package => required_version ]
     */
    private function updatePackages(array $packages): void
    {
        foreach ($packages as $package => $version) {
            if (!$this->versionComparator->isRealVersion($version)) {
                $this->currentPackages[$package] = $version;
                continue;
            }
            if (Comparator::greaterThan($version, $this->currentPackages[$package] ?? '0.0')) {
                $this->currentPackages[$package] = $version;
            }
        }
    }
}
