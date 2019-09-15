<?php

use Raptor\TestUtils\TestDataContainer\TestDataContainer;

/**
 * @method string getVersionFrom()
 * @method string getVersionTo()
 * @method array getExpectedResult()
 */
class LoadDataContainer extends TestDataContainer
{
}

/**
 * @method string getDirectory()
 * @method array getRules()
 * @method array getExpectedResult()
 */
class DirectoryProcessDataContainer extends TestDataContainer
{
}

/**
 * @method string getFilename()
 * @method array getRules()
 * @method mixed getExpectedResult()
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
