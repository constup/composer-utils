<?php

namespace Constup\ComposerUtils;


use Constup\Validator\Filesystem\DirectoryValidatorInterface;
use Exception;

/**
 * Class ComposerJsonFileUtil
 *
 * @package Constup\ComposerUtils
 */
interface ComposerJsonFileUtilInterface
{
    /**
     * @return DirectoryValidatorInterface
     */
    public function getDirectoryValidator(): DirectoryValidatorInterface;

    /**
     * @param string $startDirectory
     *
     * @return string|null
     * @throws Exception
     *
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
     * @return object
     * @throws Exception
     *
     */
    public function findAndFetchComposerJson(string $startDirectory): object;
}