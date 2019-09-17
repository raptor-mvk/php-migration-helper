<?php

use Raptor\TestUtils\TestDataContainer\TestDataContainer;

/**
 * @method string getVersionFrom()
 * @method string getVersionTo()
 * @method array getExpectedResult()
 */
class CommandDataContainer extends TestDataContainer
{
}

/**
 * @method string getVersionFrom()
 * @method string getVersionTo()
 * @method array getExpectedResult()
 */
class LoadPackagesDataContainer extends TestDataContainer
{
}

/**
 * @method string getVersionFrom()
 * @method string getVersionTo()
 * @method array getExpectedResult()
 */
class LoadRuleConfigsDataContainer extends TestDataContainer
{
}

/**
 * @method string getDirectory()
 * @method array getRuleConfigs()
 * @method array getExpectedResult()
 */
class DirectoryProcessDataContainer extends TestDataContainer
{
}

/**
 * @method string getFilename()
 * @method array getRules()
 * @method mixed getExpectedResult()
 * @method string getReportFilename()
 */
class FileProcessDataContainer extends TestDataContainer
{
}

/**
 * @method string getRuleName()
 * @method array getRuleArray()
 * @method string getMessage()
 */
class FromArrayIncorrectDataContainer extends TestDataContainer
{
}

/**
 * @method string getRuleName()
 * @method array getRuleArray()
 * @method string getMethod()
 * @method mixed getValue()
 */
class GettersDataContainer extends TestDataContainer
{
}

/**
 * @method array getInstalledVersions()
 * @method array getRequiredVersions()
 * @method array getExpectedResult()
 */
class VersionComparatorDataContainer extends TestDataContainer
{
}
