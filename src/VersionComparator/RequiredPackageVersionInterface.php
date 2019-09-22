<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\VersionComparator;

/**
 * Interface for required package version.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface RequiredPackageVersionInterface
{
    /**
     * Returns required package version.
     *
     * @return string
     */
    public function getVersion(): string;

    /**
     * Returns additional message that should be added to the report.
     *
     * @return string|null
     */
    public function getMessage(): ?string;
}
