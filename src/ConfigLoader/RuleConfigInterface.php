<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

use Raptor\PHPMigrationHelper\Rule\RuleInterface;

/**
 * Interface for rule config that contains array of rules and array of excluded directories.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface RuleConfigInterface
{
    /**
     * Return array of rules.
     *
     * @return RuleInterface[]
     */
    public function getRules(): array;

    /**
     * Return array of excluded directories.
     *
     * @return string[]
     */
    public function getExcludedDirs(): array;
}
