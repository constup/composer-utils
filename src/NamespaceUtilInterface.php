<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

use Exception;

/**
 * Interface NamespaceUtil
 *
 * @package Constup\ComposerUtils
 */
interface NamespaceUtilInterface
{
    const PSR_4 = 'psr-4';
    const AUTOLOAD_DEV = 'autoload-dev';

    const TEST_NAMESPACE_MARKER_TEST = 'Test';
    const TEST_NAMESPACE_MARKER_TESTS = 'Tests';

    /**
     * @return array
     */
    public function getAllBaseComposerAutoloadNamespaces(): array;

    /**
     * @return array
     */
    public function getAllBaseComposerAutoloadDevNamespaces(): array;

    /**
     * @return array
     */
    public function getAllBaseComposerNamespaces(): array;

    /**
     * @return string
     */
    public function getProjectRootDirectory(): string;

    /**
     * @return object
     */
    public function getComposerJsonObject(): object;

    /**
     * @param string $filePath
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateNamespaceFromPath(string $filePath): string;

    /**
     * @param string $namespace
     *
     * @return string
     */
    public function generatePathFromNamespace(string $namespace): string;

    /**
     * @param string $fqcn
     *
     * @return string|null
     */
    public function generatePathFromFqcn(string $fqcn): ?string;

    /**
     * @param string $fqcn
     *
     * @return bool
     */
    public function fileWithFqcnExists(string $fqcn): bool;

    /**
     * @param string $namespaceOrFqcn
     *
     * @return string
     */
    public function getComposerBaseNamespace(string $namespaceOrFqcn): string;

    /**
     * @param string $componentFqcn
     * @param string $testNamespaceMarker
     *
     * @return string
     */
    public function generateTestNamespaceForComponent(string $componentFqcn, string $testNamespaceMarker = self::TEST_NAMESPACE_MARKER_TESTS): string;
}
