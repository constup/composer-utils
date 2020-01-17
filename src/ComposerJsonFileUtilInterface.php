<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

use Exception;

/**
 * Class ComposerJsonFileUtil
 *
 * @package Constup\ComposerUtils
 */
interface ComposerJsonFileUtilInterface
{
    /**
     * @param string $startDirectory
     *
     * @return string|null
     */
    public function findComposerJson(string $startDirectory): ?string;

    /**
     * @param string $composerJsonFilePath
     *
     * @return object
     */
    public function fetchComposerJsonObject(string $composerJsonFilePath): object;

    /**
     * @param string $startDirectory
     *
     * @throws Exception
     *
     * @return object
     */
    public function findAndFetchComposerJson(string $startDirectory): object;
}
