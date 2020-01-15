<?php

declare(strict_types=1);

namespace Constup\ComposerUtils\Tests;

use Constup\ComposerUtils\NamespaceUtil;
use Constup\ComposerUtils\NamespaceUtilInterface;
use Exception;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class NamespaceUtilTest
 *
 * @package Constup\ComposerUtils\Tests
 */
class NamespaceUtilTest extends TestCase
{
    use NamespaceUtilTestDataProvider, PHPMock;

    const TESTED_CLASS = NamespaceUtil::class;

    /** @var string */
    private $testedClassNamespace;

    protected function setUp(): void
    {
        parent::setUp();

        $reflectionClass = new ReflectionClass(self::TESTED_CLASS);
        $this->testedClassNamespace = $reflectionClass->getNamespaceName();
    }

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
     * @param bool $file_exists
     * @param bool $is_file
     * @param string $fqcn
     * @param bool $expectedResult
     *
     * @dataProvider testFileWithFqcnExistsDataProvider
     */
    public function testFileWithFqcnExists(string $generatePathFromFqcn, bool $file_exists, bool $is_file, string $fqcn, bool $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->onlyMethods(["generatePathFromFqcn"])
            ->getMock();

        $mock->method("generatePathFromFqcn")->willReturn($generatePathFromFqcn);

        $file_exists_mock = $this->getFunctionMock($this->testedClassNamespace, "file_exists");
        $file_exists_mock->expects($this->atMost(1))->willReturn($file_exists);
        $is_file_mock = $this->getFunctionMock($this->testedClassNamespace, "is_file");
        $is_file_mock->expects($this->atMost(1))->willReturn($is_file);

        /** @var NamespaceUtilInterface $mock */
        $result = $mock->fileWithFqcnExists($fqcn);
        $this->assertIsBool($result);
        $this->assertEquals($expectedResult, $result);
    }
}
