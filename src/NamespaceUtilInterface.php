<?php

namespace Constup\ComposerUtils;


use Constup\Validator\Filesystem\FileValidatorInterface;
use Exception;

/**
 * Class NamespaceUtil
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
     * @return FileValidatorInterface
     */
    public function getFileValidator(): FileValidatorInterface;

    /**
     * @param string $filePath
     * @param object $composerJsonObject
     *
     * @return string
     * @throws Exception
     *
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