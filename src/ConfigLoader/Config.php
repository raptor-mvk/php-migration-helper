<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\ConfigLoader;

use Raptor\PHPMigrationHelper\Rule\RuleInterface;

/**
 * Stores config.
 *
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class Config implements ConfigInterface
{
    /** @var RuleConfigInterface[] $ruleConfigs */
    private $ruleConfigs;

    /** @var array $requiredPackageVersions */
    private $requiredPackageVersions;

    /**
     * @param array        $requiredVersions required package versions in format [ package => required_version, ... ]
     * @param RuleConfig[] $ruleConfigs      array of rule configs
     */
    public function __construct(array $requiredVersions, array $ruleConfigs)
    {
        $this->requiredPackageVersions = $requiredVersions;
        $this->ruleConfigs = $ruleConfigs;
    }

    /**
     * Return array of rules.
     *
     * @return RuleInterface[]
     */
    public function getRuleConfigs(): array
    {
        return $this->ruleConfigs;
    }

    /**
     * Return array of required package versions in format [ package => required_version, ... ].
     *
     * @return array
     */
    public function getRequiredPackageVersions(): array
    {
        return $this->requiredPackageVersions;
    }
}
