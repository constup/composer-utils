<?php

declare(strict_types=1);

namespace Constup\ComposerUtils;

use Constup\Validator\Filesystem\DirectoryValidatorInterface;
use Exception;

/**
 * Class ComposerJsonFileUtil
 *
 * @package Constup\ComposerUtils
 */
class ComposerJsonFileUtil implements ComposerJsonFileUtilInterface
{
    /** @var DirectoryValidatorInterface */
    private $directoryValidator;

    /**
     * ComposerJsonFileUtil constructor.
     * @param DirectoryValidatorInterface $directoryValidator
     */
    public function __construct(DirectoryValidatorInterface $directoryValidator)
    {
        $this->directoryValidator = $directoryValidator;
    }

    /**
     * @return DirectoryValidatorInterface
     */
    public function getDirectoryValidator(): DirectoryValidatorInterface
    {
        return $this->directoryValidator;
    }

    /**
     * @param string $startDirectory
     *
     * @throws Exception
     *
     * @return string|null
     */
    public function findComposerJSON(string $startDirectory): ?string
    {
        $directoryValidation = $this->getDirectoryValidator()->validateDirectory($startDirectory);
        if ($directoryValidation !== DirectoryValidatorInterface::OK) {
            throw new Exception(__METHOD__ . ' : ' . $directoryValidation);
        }

        $_start_directory = rtrim($startDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $composerJSON = $_start_directory . 'composer.json';
        if (!file_exists($composerJSON)) {
            if ($_start_directory == '/' || (preg_match('/^[a-zA-Z](\:\\\\)$/', $_start_directory))) {
                return null;
            }

            return self::findComposerJSON(dirname($_start_directory));
        }

        return realpath($composerJSON);
    }

    /**
     * @param string $composerJsonFilePath
     *
     * @return object
     */
    public function fetchComposerJSONObject(string $composerJsonFilePath): object
    {
        return json_decode(file_get_contents($composerJsonFilePath));
    }

    /**
     * @param string $startDirectory
     *
     * @throws Exception
     *
     * @return object
     */
    public function findAndFetchComposerJson(string $startDirectory): object
    {
        $directoryValidation = $this->getDirectoryValidator()->validateDirectory($startDirectory);
        if ($directoryValidation !== DirectoryValidatorInterface::OK) {
            throw new Exception(__METHOD__ . ' : ' . $directoryValidation);
        }

        $composerJsonFilePath = $this->findComposerJSON($startDirectory);
        if ($composerJsonFilePath == null) {
            throw new Exception(__METHOD__ . '->' . 'composer.json file not found.');
        }

        return $this->fetchComposerJSONObject($composerJsonFilePath);
    }

}
