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
     * @param string $namespace
     *
     * @return bool
     */
    public function fileWithFqcnExists(string $namespace): bool;
}
