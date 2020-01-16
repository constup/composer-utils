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
         * @param string $getProjectRootDirectory
         * @param object $getComposerJsonObject
         * @param string $filePath
         * @param string $expectedResult
         */

        $result = [];

        return $result;
    }

    public function testGeneratePathFromNamespaceDataProvider()
    {
        /**
         * @param string $getProjectRotDirectory
         * @param object $getComposerJsonObject
         * @param string $namespace
         * @param string $expectedResult
         */

        $result = [];

        return $result;
    }

    public function testGeneratePathFromFqcnDataProvider()
    {
        /**
         * @param string $generatePathFromNamespace
         * @param string $fqcn
         * @param string $expectedResult
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
         * @param object $getComposerJsonObject
         * @param string $namespaceOrFqcn
         * @param string $expectedResult
         */

        $result = [];

        return $result;
    }

    public function testGenerateTestNamespaceForComponentDataProvider()
    {
        /**
         * @param string $getComposerBaseNamespace
         * @param string $componentFqcn
         * @param string $testNamespaceMarker
         * @param string $expectedResult
        */

        $result = [];

        return $result;
    }
}
