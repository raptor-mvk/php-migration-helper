<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Processor;

use Raptor\PHPMigrationHelper\Rule\RuleInterface;

/**
 * Processes the given file with array of rules and produces the compatibility report.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class FileProcessor implements FileProcessorInterface
{
    /**
     * Processes the given file with the given rules and returns compatibility report or null if everything is fine.
     *
     * @param string          $fileName
     * @param RuleInterface[] $rules             array of rules applied to file
     * @param string|null     $fileNameForReport filename that should be used in report
     *
     * @return string[]|null strings for compatibility report if needed, or null otherwise
     */
    public function process(string $fileName, array $rules, ?string $fileNameForReport = null): ?array
    {
        $result = [];
        $divider = '--------------------------------------------------------------------------------';
        $content = explode("\n", file_get_contents($fileName));
        foreach ($rules as $rule) {
            /** @var RuleInterface[] $rules */
            foreach ($content as $lineNumber => $line) {
                if (preg_match($rule->getRegExp(), $line) > 0) {
                    $result[] = $this->prepareResult($content, $lineNumber, $rule);
                    $result[] = [$divider];
                }
            }
        }
        array_pop($result);

        return empty($result) ? null : array_merge(...$result);
    }

    /**
     * Returns strings for compatibility report.
     *
     * @param string[]      $content    contents of the file
     * @param int           $lineNumber line number of the coincidence
     * @param RuleInterface $rule       rule that produces coincidence
     *
     * @return string[] strings for compatibility report
     */
    private function prepareResult(array $content, int $lineNumber, RuleInterface $rule): array
    {
        $startLine = max($lineNumber - $rule->getLinesBeforeCount(), 0);
        $finishLine = min($lineNumber + $rule->getLinesAfterCount(), count($content) - 1);
        $recommendation = $rule->getRecommendation();
        $result = [$recommendation];
        for ($i = $startLine; $i <= $finishLine; $i++) {
            $lineNumber = $i + 1;
            $result[] = "\t$lineNumber\t{$content[$i]}";
        }

        return $result;
    }
}
