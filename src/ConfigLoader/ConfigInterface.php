<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

/**
 * Interface for config class.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
interface ConfigInterface
{
    /**
     * Return array of rule configs.
     *
     * @return RuleConfigInterface[]
     */
    public function getRuleConfigs(): array;

    /**
     * Return array of required package versions in format [ package => required_version, ... ].
     *
     * @return array
     */
    public function getRequiredPackageVersions(): array;
}
