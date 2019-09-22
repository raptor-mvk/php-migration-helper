<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\VersionComparator;

/**
 * Stores required package version.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
class RequiredPackageVersion implements RequiredPackageVersionInterface
{
    /** @var string $version */
    private $version;

    /** @var string $message */
    private $message;

    /**
     * RequiredPackageVersion constructor.
     * @param string      $version
     * @param string|null $message
     */
    public function __construct(string $version, ?string $message = null)
    {
        $this->version = $version;
        $this->message = $message;
    }

    /**
     * Returns required package version.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Returns additional message that should be added to the report.
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
