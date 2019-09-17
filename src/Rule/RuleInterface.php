<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Rule;

/**
 * Interface for PHP migration helper rule.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface RuleInterface
{
    /**
     * Returns count of lines before problem string that should be presented in the report.
     *
     * @return int
     */
    public function getLinesBeforeCount(): int;

    /**
     * Returns count of lines after problem string that should be presented in the report.
     *
     * @return int
     */
    public function getLinesAfterCount(): int;

    /**
     * Returns regexp that should be checked.
     *
     * @return string
     */
    public function getRegExp(): string;

    /**
     * Returns recommendation that should be presented in the report.
     *
     * @return string
     */
    public function getRecommendation(): string;
}
