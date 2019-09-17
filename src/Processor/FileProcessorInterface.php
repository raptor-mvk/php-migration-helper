<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Processor;

use Raptor\PHPMigrationHelper\Rule\RuleInterface;

/**
 * Interface for file processor that processes files with the given rules.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface FileProcessorInterface
{
    /**
     * Processes the given file with the given rules and returns compatibility report or null if everything is fine.
     *
     * @param string          $fileName full path to the file to be processed
     * @param RuleInterface[] $rules    array of rules applied to file
     *
     * @return string[]|null strings for compatibility report if needed, or null otherwise
     */
    public function process(string $fileName, array $rules): ?array;
}
