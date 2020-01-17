<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils\Tests;

use Constup\ComposerUtils\ComposerJsonFileUtil;
use Constup\ComposerUtils\ComposerJsonFileUtilInterface;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Class ComposerJsonFileUtilTest
 *
 * @package Constup\ComposerUtils\Tests
 */
class ComposerJsonFileUtilTest extends TestCase
{
    use ComposerJsonFileUtilTestDataProvider, PHPMock;

    const TESTED_CLASS = ComposerJsonFileUtil::class;

    /** @var string */
    private $testedClassNamespace;

    protected function setUp(): void
    {
        parent::setUp();

        $reflectionClass = new ReflectionClass(self::TESTED_CLASS);
        $this->testedClassNamespace = $reflectionClass->getNamespaceName();
    }

    /**
     * @param bool        $file_exists
     * @param string      $startDirectory
     * @param string|null $expectedResult
     *
     * @dataProvider testFindComposerJsonDataProvider
     */
    public function testFindComposerJson(bool $file_exists, string $startDirectory, ?string $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->getMock();

        $file_exists_mock = $this->getFunctionMock($this->testedClassNamespace, 'file_exists');
        $file_exists_mock->expects($this->atMost(1))->willReturn($file_exists);

        /** @var ComposerJsonFileUtilInterface $mock */
        $result = $mock->findComposerJson($startDirectory);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string $file_get_contents
     * @param string $composerJsonFilePath
     * @param object $expectedResult
     *
     * @dataProvider testFetchComposerJsonObjectDataProvider
     */
    public function testFetchComposerJsonObject(string $file_get_contents, string $composerJsonFilePath, object $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->getMock();

        $file_get_contents_mock = $this->getFunctionMock($this->testedClassNamespace, 'file_get_contents');
        $file_get_contents_mock->expects($this->once())->willReturn($file_get_contents);

        /** @var ComposerJsonFileUtilInterface $mock */
        $result = $mock->fetchComposerJsonObject($composerJsonFilePath);
        $this->assertIsObject($result);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @param string|null $findComposerJson
     * @param object      $fetchComposerJsonObject
     * @param string      $startDirectory
     * @param object      $expectedResult
     *
     * @throws \Exception
     *
     * @dataProvider testFindAndFetchComposerJsonDataProvider
     */
    public function testFindAndFetchComposerJson(?string $findComposerJson, object $fetchComposerJsonObject, string $startDirectory, object $expectedResult)
    {
        $mock = $this->getMockBuilder(self::TESTED_CLASS)
            ->disableOriginalConstructor()
            ->onlyMethods(['findComposerJson', 'fetchComposerJsonObject'])
            ->getMock();

        $mock->method('findComposerJson')->willReturn($findComposerJson);
        $mock->method('fetchComposerJsonObject')->willReturn($fetchComposerJsonObject);

        /** @var ComposerJsonFileUtilInterface $mock */
        $result = $mock->findAndFetchComposerJson($startDirectory);
        $this->assertEquals($expectedResult, $result);
    }
}
