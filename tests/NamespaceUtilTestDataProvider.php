<?php

declare(strict_types=1);

namespace Constup\ComposerUtils\Tests;

use Constup\ComposerUtils\NamespaceUtilInterface;
use Faker\Factory;
use stdClass;

/**
 * Trait NamespaceUtilTestDataProvider
 *
 * @package Constup\ComposerUtils\Tests
 */
trait NamespaceUtilTestDataProvider
{
    public function testGenerateNamespaceFromPathDataProvider()
    {
        $result = [];

        return $result;
    }

    public function testGeneratePathFromNamespaceDataProvider()
    {
        $result = [];

        return $result;
    }

    public function testGeneratePathFromFqcnDataProvider()
    {
        $result = [];

        return $result;
    }

    public function testFileWithFqcnExistsDataProvider()
    {
        /**
         * @var string $generatePathFromFqcn
         * @var bool $file_exists
         * @var bool $is_file
         * @var string $fqcn
         * @var bool $expectedResult
         */

        $faker = Factory::create();

        $result = [];

        $result[] = [$faker->word(), true, true, $faker->word(), true];
        $result[] = [$faker->word(), true, false, $faker->word(), false];
        $result[] = [$faker->word(), false, true, $faker->word(), false];
        $result[] = [$faker->word(), false, false, $faker->word(), false];

        return $result;
    }
}
