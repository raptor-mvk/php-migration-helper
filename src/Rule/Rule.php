<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Rule;

use Raptor\PHPMigrationHelper\Exception\RuleException;
use function is_int;

/**
 * PHP migration helper rule.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class Rule implements RuleInterface
{
    /** @var int $linesBefore */
    private $linesBefore;

    /** @var int $linesAfter */
    private $linesAfter;

    /** @var string $recommendation */
    private $recommendation;

    /** @var string $regExp */
    private $regExp;

    /**
     * Creates new rule from given array with rule parameters.
     *
     * @param string $ruleName  name of the rule (used for error messages)
     * @param array  $ruleArray array with rule parameters
     *
     * @return RuleInterface
     *
     * @throws RuleException
     */
    public static function fromArray(string $ruleName, array $ruleArray): RuleInterface
    {
        static::validateRuleArray($ruleName, $ruleArray);
        $result = new static();
        $result->regExp = $ruleArray['regexp'];
        $result->recommendation = $ruleArray['recommendation'];
        $result->linesBefore = $ruleArray['lines_before'] ?? 0;
        $result->linesAfter = $ruleArray['lines_after'] ?? 0;

        return $result;
    }

    /**
     * Returns count of lines before problem string that should be presented in the report.
     *
     * @return int
     */
    public function getLinesBeforeCount(): int
    {
        return $this->linesBefore;
    }

    /**
     * Returns count of lines after problem string that should be presented in the report.
     *
     * @return int
     */
    public function getLinesAfterCount(): int
    {
        return $this->linesAfter;
    }

    /**
     * Returns regexp that should be checked.
     *
     * @return string
     */
    public function getRegExp(): string
    {
        return $this->regExp;
    }

    /**
     * Returns recommendation that should be presented in the report.
     *
     * @return string
     */
    public function getRecommendation(): string
    {
        return $this->recommendation;
    }

    /**
     * Returns true if array with rule parameters is correct.
     *
     * @param string $ruleName  name of the rule (used for error messages)
     * @param array  $ruleArray array with rule parameters
     *
     * @return bool
     *
     * @throws RuleException
     */
    private static function validateRuleArray(string $ruleName, array $ruleArray): bool
    {
        if (!isset($ruleArray['recommendation'])) {
            throw new RuleException($ruleName, 'No recommendation was found in rule');
        }
        if (!isset($ruleArray['regexp'])) {
            throw new RuleException($ruleName, 'No regexp was found in rule');
        }
        static::validateLinesCount($ruleName, $ruleArray);

        return true;
    }

    /**
     * Returns true if lines_before and line_after parameters in array with rule parameters are correct.
     *
     * @param string $ruleName  name of the rule (used for error messages)
     * @param array  $ruleArray array with rule parameters
     *
     * @return bool
     *
     * @throws RuleException
     */
    private static function validateLinesCount(string $ruleName, array $ruleArray): bool
    {
        $linesBefore = $ruleArray['lines_before'] ?? 0;
        $linesAfter = $ruleArray['lines_after'] ?? 0;
        if (!is_int($linesBefore) || ($linesBefore < 0)) {
            throw new RuleException($ruleName, 'lines_before should be non-negative integer in rule');
        }
        if (!is_int($linesAfter) || ($linesAfter < 0)) {
            throw new RuleException($ruleName, 'lines_after should be non-negative integer in rule');
        }

        return true;
    }
}
