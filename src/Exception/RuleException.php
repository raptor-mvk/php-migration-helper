<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\Exception;

use RuntimeException;

/**
 * Exceptions that is thrown if an error occurred while constructing rule.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class RuleException extends RuntimeException
{
    /**
     * @param string|null $name    rule name
     * @param string|null $message exception message.
     */
    public function __construct(?string $name = null, ?string $message = null)
    {
        $name = $name ?? '';
        $message .= " '$name'";
        parent::__construct($message);
    }
}
