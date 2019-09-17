<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

use Raptor\PHPMigrationHelper\Rule\RuleInterface;

/**
 * Contains array of rules and array of excluded directories.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class RuleConfig implements RuleConfigInterface
{
    /** @var RuleInterface[] $rules */
    private $rules;

    /** @var string[] $excludedDirs */
    private $excludedDirs;

    /**
     * @param RuleInterface[] $rules
     * @param string[]        $excludedDirs
     */
    public function __construct(array $rules, array $excludedDirs)
    {
        $this->rules = $rules;
        $this->excludedDirs = $excludedDirs;
    }

    /**
     * Return array of rules.
     *
     * @return RuleInterface[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Return array of excluded directories.
     *
     * @return string[]
     */
    public function getExcludedDirs(): array
    {
        return $this->excludedDirs;
    }
}
