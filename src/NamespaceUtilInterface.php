<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

use Constup\Validator\Filesystem\DirectoryValidatorInterface;
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
     * @return ComposerJsonFileUtilInterface
     */
    public function getComposerJsonFileUtil(): ComposerJsonFileUtilInterface;

    /**
     * @return DirectoryValidatorInterface
     */
    public function getDirectoryValidator(): DirectoryValidatorInterface;

    /**
     * @param string $filePath
     * @param object $composerJsonObject
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateNamespaceFromPath(string $filePath, object $composerJsonObject): string;

    /**
     * @param string $namespace
     * @param string $projectRootDirectory
     * @param object $composerJsonObject
     *
     * @return string
     */
    public function generatePathFromNamespace(string $namespace, string $projectRootDirectory, object $composerJsonObject): string;
}
