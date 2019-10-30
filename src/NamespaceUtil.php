<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

use Exception;

/**
 * Class NamespaceUtil
 *
 * @package Constup\ComposerUtils
 */
class NamespaceUtil implements NamespaceUtilInterface
{
    /** @var string */
    private $projectRootDirectory;
    /** @var object */
    private $composerJsonObject;

    /**
     * NamespaceUtil constructor.
     *
     * @param string $projectRootDirectory
     * @param object $composerJsonObject
     */
    public function __construct(string $projectRootDirectory, object $composerJsonObject)
    {
        $this->projectRootDirectory = $projectRootDirectory;
        $this->composerJsonObject = $composerJsonObject;
    }

    /**
     * @return string
     */
    public function getProjectRootDirectory(): string
    {
        return $this->projectRootDirectory;
    }

    /**
     * @return object
     */
    public function getComposerJsonObject(): object
    {
        return $this->composerJsonObject;
    }

    /**
     * @param string $filePath
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateNamespaceFromPath(string $filePath): string
    {
        $_file_path = realpath($filePath);

        $project_root = $this->getProjectRootDirectory();
        $composerJsonObject = $this->getComposerJsonObject();
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;

        foreach ($composerJsonObject->autoload->$psr_4 as $namespace_root => $namespace_base_dir) {
            $_absolute_namespace_dir = realpath(rtrim($project_root . DIRECTORY_SEPARATOR . $namespace_base_dir, '\\/'));
            if (strpos($_file_path, $_absolute_namespace_dir) === 0) {
                return rtrim(str_replace('\\\\', '\\', $namespace_root . substr($_file_path, strlen($_absolute_namespace_dir))), '\\');
            }
        }
        foreach ($composerJsonObject->$autoload_dev->$psr_4 as $namespace_root => $namespace_base_dir) {
            $_absolute_namespace_dir = rtrim($project_root . DIRECTORY_SEPARATOR . $namespace_base_dir, '\\/');
            if (strpos($_file_path, $_absolute_namespace_dir) === 0) {
                return rtrim(str_replace('\\\\', '\\', $namespace_root . substr($_file_path, strlen($_absolute_namespace_dir))), '\\');
            }
        }

        throw new Exception(__METHOD__ . ' : ' . 'File path "' . $_file_path . '" does not belong to any namespace.');
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    public function generatePathFromNamespace(string $namespace): string
    {
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;
        $projectRootDirectory = $this->getProjectRootDirectory();
        $composerJsonObject = $this->getComposerJsonObject();

        $result = '';
        $match = '';
        foreach ($composerJsonObject->autoload->$psr_4 as $namespace_root => $namespace_base_dir) {
            if (strpos($namespace, $namespace_root) === 0) {
                $_namespace_base_dir = str_replace('/', DIRECTORY_SEPARATOR, $namespace_base_dir);
                $_namespace = substr_replace($namespace, $_namespace_base_dir, 0, strlen($namespace_root));
                $match = $namespace_root;
                $result = rtrim($projectRootDirectory, '\\/') . DIRECTORY_SEPARATOR . $_namespace;
            }
        }

        foreach ($composerJsonObject->$autoload_dev->$psr_4 as $namespace_root => $namespace_base_dir) {
            if (strpos($namespace, $namespace_root) === 0) {
                $_namespace_base_dir = str_replace('/', DIRECTORY_SEPARATOR, $namespace_base_dir);
                $_namespace = substr_replace($namespace, $_namespace_base_dir, 0, strlen($namespace_root));
                $_result = rtrim($projectRootDirectory, '\\/') . DIRECTORY_SEPARATOR . $_namespace;
                // This covers the case when the namespace defined in autoload-dev is not a subset of any namespace defined in autoload.
                if (empty($match)) {
                    $result = $_result;
                } else {
                    // If previously found namespace root is a substring of the currently processed namespace root, the result is the new namespace root.
                    if (strpos($namespace_root, $match) !== false) {
                        $result = $_result;
                    }
                }
            }
        }

        if (!empty($result)) {
            $result .= '.php';
        }

        return $result;
    }

    /**
     * @param string $namespace
     *
     * @return bool
     */
    public function fileWithFqcnExists(string $namespace): bool
    {
        $filename = $this->generatePathFromNamespace($namespace);

        return file_exists($filename) && is_file($filename);
    }
}
