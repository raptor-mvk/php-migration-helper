<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Processor;

use Raptor\PHPMigrationHelper\Rule\RuleInterface;

/**
 * Interface for directory processor that processes all files in the given directory recursively with the given rules.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface DirectoryProcessorInterface
{
    /**
     * Processes all files in the given directory recursively with the given rules and returns compatibility report or
     * null if everything is fine.
     *
     * @param string          $path
     * @param RuleInterface[] $rules array of rules applied to each file
     *
     * @return string[]|null strings for compatibility report if needed, or null otherwise
     */
    public function process(string $path, array $rules): ?array;
}
