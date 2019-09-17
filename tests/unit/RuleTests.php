<?php
declare(strict_types=1);

/**
 * @license MIT
 * @license https://github.com/raptor-mvk/php-migration-helper/blob/master/license.md
 */

namespace Raptor\PHPMigrationHelper\UnitTests;

use PHPUnit\Framework\TestCase;
use Raptor\PHPMigrationHelper\Exception\RuleException;
use Raptor\PHPMigrationHelper\Rule\Rule;
use Raptor\TestUtils\ExtraUtilsTrait;
use Raptor\TestUtils\TestDataContainer\TestDataContainer;
use Raptor\TestUtils\WithDataLoaderTrait;

/**
 * @author Mikhail Kamorin aka raptor_MVK
 *
 * @copyright 2019, raptor_MVK
 */
final class RuleTests extends TestCase
{
    use ExtraUtilsTrait, WithDataLoaderTrait;

    /**
     * Checks that _fromArray_ method throws RuleException when incorrect array is provided.
     *
     * @dataProvider fromArrayIncorrectDataProvider container with test data
     *
     * @param TestDataContainer $dataContainer
     */
    public function testFromArrayThrowsRuleExceptionWhenArrayIsIncorrect(TestDataContainer $dataContainer): void
    {
        /** @var \FromArrayIncorrectDataContainer $dataContainer */
        $this->expectException(RuleException::class);
        $this->expectExceptionExactMessage($dataContainer->getMessage());

        Rule::fromArray($dataContainer->getRuleName(), $dataContainer->getRuleArray());
    }

    /**
     * Provides incorrect arrays to test _fromArray_ method.
     *
     * @return array
     */
    public function fromArrayIncorrectDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/rule/from_array_incorrect.json');
    }

    /**
     * Checks that getters returns correct values for successfully created rule.
     *
     * @param TestDataContainer $dataContainer container with test data
     *
     * @dataProvider gettersDataProvider
     */
    public function testGettersReturnsCorrectValue(TestDataContainer $dataContainer): void
    {
        /** @var \GettersDataContainer $dataContainer */
        $rule = Rule::fromArray($dataContainer->getRuleName(), $dataContainer->getRuleArray());

        $method = $dataContainer->getMethod();

        static::assertSame($dataContainer->getValue(), $rule->$method());
    }

    /**
     * Provides test data to test getters.
     *
     * @return array
     */
    public function gettersDataProvider(): array
    {
        return $this->loadDataFromFile(__DIR__.'/../data/rule/getters.json');
    }
}
