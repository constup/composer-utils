<?php

declare(strict_types=1);

namespace Constup\ComposerUtils\Tests;

use Faker\Factory;

/**
 * Trait NamespaceUtilTestDataProvider
 *
 * @package Constup\ComposerUtils\Tests
 */
trait NamespaceUtilTestDataProvider
{
    public function testGenerateNamespaceFromPathDataProvider()
    {
        /**
         * @var string $getProjectRootDirectory
         * @var object $getComposerJsonObject
         * @var string $filePath
         * @var string $expectedResult
         */

        $result = [];

        return $result;
    }

    public function testGeneratePathFromNamespaceDataProvider()
    {
        /**
         * @var string $getProjectRotDirectory
         * @var object $getComposerJsonObject
         * @var string $namespace
         * @var string $expectedResult
         */

        $result = [];

        return $result;
    }

    public function testGeneratePathFromFqcnDataProvider()
    {
        /**
         * @var string $generatePathFromNamespace
         * @var string $fqcn
         * @var string $expectedResult
         */

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

    public function testGetComposerBaseNamespaceDataProvider()
    {
        /**
         * @var object $getComposerJsonObject
         * @var string $namespaceOrFqcn
         * @var string $expectedResult
         */

        $result = [];

        return $result;
    }

    public function testGenerateTestNamespaceForComponentDataProvider()
    {
        /**
         * @var string $getComposerBaseNamespace
         * @var string $componentFqcn
         * @var string $testNamespaceMarker
         * @var string $expectedResult
        */

        $result = [];

        return $result;
    }
}
