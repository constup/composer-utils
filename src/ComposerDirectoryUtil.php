<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

/**
 * Class ComposerDirectoryUtil
 *
 * Utilities for working with directories related to Composer or directories defined in `composer.json` file.
 *
 * @package Constup\ComposerUtils
 */
class ComposerDirectoryUtil implements ComposerDirectoryUtilInterface
{
    /** @var string Destination project's root directory. Note that a root directory is considered a directory where `composer.json` file is located. */
    private $projectRootDir;
    /** @var object An example of an object like this is a result of `json_decode(file_get_contents($composerJsonFilePath));` */
    private $composerJsonObject;

    /**
     * ComposerDirectoryUtil constructor.
     *
     * @param string $projectRootDir
     * @param object $composerJsonObject
     */
    public function __construct(string $projectRootDir, object $composerJsonObject)
    {
        $this->projectRootDir = $projectRootDir;
        $this->composerJsonObject = $composerJsonObject;
    }

    /**
     * @return string
     */
    public function getProjectRootDir(): string
    {
        return $this->projectRootDir;
    }

    /**
     * @return object
     */
    public function getComposerJsonObject(): object
    {
        return $this->composerJsonObject;
    }

    /**
     * Return an array of all absolute directory paths listed in `autoload > psr-4` and `autoload-dev > psr-4` sections of `composer.json`.
     * For a PHP project, these should be all directories where source code written by a developer can be.
     *
     * @return string[]
     */
    public function getSourceDirectories(): array
    {
        $result = [];

        $composerJsonObject = $this->getComposerJsonObject();
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;

        foreach ($composerJsonObject->autoload->$psr_4 as $namespace_root => $namespace_base_dir) {
            $result[] = $this->getProjectRootDir() . DIRECTORY_SEPARATOR . $namespace_base_dir;
        }
        foreach ($composerJsonObject->$autoload_dev->$psr_4 as $namespace_root => $namespace_base_dir) {
            $result[] = $this->getProjectRootDir() . DIRECTORY_SEPARATOR . $namespace_base_dir;
        }

        return $result;
    }
}
