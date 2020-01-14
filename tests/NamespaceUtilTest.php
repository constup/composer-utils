<?php

declare(strict_types=1);

namespace Constup\ComposerUtils\Tests;

use Constup\ComposerUtils\NamespaceUtil;
use Constup\ComposerUtils\NamespaceUtilInterface;
use Exception;
use PHPUnit\Framework\TestCase;

function file_exists(): bool
{

}

/**
 * Class NamespaceUtilTest
 *
 * @package Constup\ComposerUtils\Tests
 */
class NamespaceUtilTest extends TestCase
{
    const TESTED_CLASS = NamespaceUtil::class;

    use NamespaceUtilTestDataProvider;

    /**
     * @param string $getProjectRootDirectory
     * @param object $getComposerJsonObject
     * @param string $filePath
     * @param string $expectedResult
     * @throws Exception
     *
     * @dataProvider testGenerateNamespaceFromPathDataProvider
     */
    public function testGenerateNamespaceFromPath(string $getProjectRootDirectory, object $getComposerJsonObject, string $filePath, string $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->onlyMethods(["getProjectRootDirectory", "getComposerJsonObject"])
            ->getMock();

        $mock->method("getProjectRootDirectory")->willReturn($getProjectRootDirectory);
        $mock->method("getComposerJsonObject")->willReturn($getComposerJsonObject);

        /** @var NamespaceUtilInterface $mock */
        $result = $mock->generateNamespaceFromPath($filePath);
        $this->assertIsString($result);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string $getProjectRotDirectory
     * @param object $getComposerJsonObject
     * @param string $namespace
     * @param string $expectedResult
     *
     * @dataProvider testGeneratePathFromNamespaceDataProvider
     */
    public function testGeneratePathFromNamespace(string $getProjectRotDirectory, object $getComposerJsonObject, string $namespace, string $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->onlyMethods(["getProjectRootDirectory", "getComposerJsonObject"])
            ->getMock();

        $mock->method("getProjectRootDirectory")->willReturn($getProjectRotDirectory);
        $mock->method("getComposerJsonObject")->willReturn($getComposerJsonObject);

        /** @var NamespaceUtilInterface $mock */
        $result = $mock->generatePathFromNamespace($namespace);
        $this->assertIsString($result);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string $generatePathFromNamespace
     * @param string $fqcn
     * @param string $expectedResult
     *
     * @dataProvider testGeneratePathFromFqcnDataProvider
     */
    public function testGeneratePathFromFqcn(string $generatePathFromNamespace, string $fqcn, string $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->onlyMethods(["generatePathFromNamespace"])
            ->getMock();

        $mock->method("generatePathFromNamespace")->willReturn($generatePathFromNamespace);

        /** @var NamespaceUtilInterface $mock */
        $result = $mock->generatePathFromFqcn($fqcn);
        $this->assertIsString($result);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string $generatePathFromFqcn
     * @param string $fqcn
     * @param string $expectedResult
     */
    public function testFileWithFqcnExists(string $generatePathFromFqcn, string $fqcn, string $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->onlyMethods(["generatePathFromFqcn", "getDirectWrapperFunctions"])
            ->getMock();

        $mock->method("generatePathFromFqcn")->willReturn($generatePathFromFqcn);

        /** @var NamespaceUtilInterface $mock */
        $result = $mock->fileWithFqcnExists($fqcn);
        $this->assertIsBool($result);
        $this->assertEquals($expectedResult, $result);
    }
}
