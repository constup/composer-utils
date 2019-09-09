<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

/**
 * Interface ComposerDirectoryUtil
 *
 * @package Constup\ComposerUtils
 */
interface ComposerDirectoryUtilInterface
{
    const PSR_4 = 'psr-4';
    const AUTOLOAD_DEV = 'autoload-dev';

    /**
     * @return string
     */
    public function getProjectRootDir(): string;

    /**
     * @return object
     */
    public function getComposerJsonObject(): object;

    /**
     * @return string[]
     */
    public function getSourceDirectories(): array;
}
