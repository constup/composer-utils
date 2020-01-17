<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils\Tests;

/**
 * Trait ComposerJsonFileUtilTestDataProvider
 *
 * @package Constup\ComposerUtils\Tests
 */
trait ComposerJsonFileUtilTestDataProvider
{
    public function testFindComposerJsonDataProvider()
    {
        /**
         * @var bool
         * @var string      $startDirectory
         * @var string|null $expectedResult
         */
        $result = [];

        return $result;
    }

    public function testFetchComposerJsonObjectDataProvider()
    {
        /**
         * @var string
         * @var string $composerJsonFilePath
         * @var object $expectedResult
         */
        $result = [];

        return $result;
    }

    public function testFindAndFetchComposerJsonDataProvider()
    {
        /**
         * @var string|null
         * @var object      $fetchComposerJsonObject
         * @var string      $startDirectory
         * @var object      $expectedResult
         */
        $result = [];

        return $result;
    }
}
