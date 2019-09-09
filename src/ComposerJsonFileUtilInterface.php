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
     * @throws Exception
     *
     * @return string|null
     */
    public function findComposerJSON(string $startDirectory): ?string;

    /**
     * @param string $composerJsonFilePath
     *
     * @return object
     */
    public function fetchComposerJSONObject(string $composerJsonFilePath): object;

    /**
     * @param string $startDirectory
     *
     * @throws Exception
     *
     * @return object
     */
    public function findAndFetchComposerJson(string $startDirectory): object;
}
