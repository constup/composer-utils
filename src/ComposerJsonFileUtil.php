<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

use Exception;

/**
 * Class ComposerJsonFileUtil
 *
 * Class for finding and fetching `composer.json` files.
 *
 * @package Constup\ComposerUtils
 */
class ComposerJsonFileUtil implements ComposerJsonFileUtilInterface
{
    /**
     * Absolute path of the directory containing a parent `composer.json` (relative to the `startDirectory`). If `composer.json` is not found, **`null`** is returned.
     *
     * @param string $startDirectory A directory where you want to start searching for `composer.json` from. The method will search the directory tree upwards up until the root.
     *
     * @throws Exception
     *
     * @return string|null
     */
    public function findComposerJSON(string $startDirectory): ?string
    {
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
     * Returns the contents of `composer.json` object in an object form. Sub-nodes aree then accessible as object's properties.
     * A special case are nodes which have `-` sign in them (ex.: `autoload-dev`), since you can't directly access an object's property with the sign in it. To access the property, store the name of the node in a constant and access by using the constant (ex. `self::$AUTOLOAD_DEV`).
     *
     * @param string $composerJsonFilePath Absolute file path of a `composer.json` file.
     *
     * @return object
     */
    public function fetchComposerJSONObject(string $composerJsonFilePath): object
    {
        return json_decode(file_get_contents($composerJsonFilePath));
    }

    /**
     * This method simply uses `fetchComposerJSON` after `findComposerJSON`.
     *
     * @param string $startDirectory A directory where you want to start searching for `composer.json` from. The method will search the directory tree upwards up until the root.
     *
     * @throws Exception
     *
     * @return object
     */
    public function findAndFetchComposerJson(string $startDirectory): object
    {
        $composerJsonFilePath = $this->findComposerJSON($startDirectory);
        if ($composerJsonFilePath == null) {
            throw new Exception(__METHOD__ . '->' . 'composer.json file not found.');
        }

        return $this->fetchComposerJSONObject($composerJsonFilePath);
    }
}
