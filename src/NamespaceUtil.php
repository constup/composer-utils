<?php

declare(strict_types = 1);

namespace Constup\ComposerUtils;

use Constup\Validator\Filesystem\DirectoryValidatorInterface;
use Exception;

/**
 * Class NamespaceUtil
 *
 * @package Constup\ComposerUtils
 */
class NamespaceUtil implements NamespaceUtilInterface
{
    /** @var ComposerJsonFileUtilInterface */
    private $composerJsonFileUtil;
    /** @var DirectoryValidatorInterface */
    private $directoryValidator;

    /**
     * NamespaceUtil constructor.
     *
     * @param ComposerJsonFileUtilInterface $composerJsonFileUtil
     * @param DirectoryValidatorInterface   $directoryValidator
     */
    public function __construct(ComposerJsonFileUtilInterface $composerJsonFileUtil, DirectoryValidatorInterface $directoryValidator)
    {
        $this->composerJsonFileUtil = $composerJsonFileUtil;
        $this->directoryValidator = $directoryValidator;
    }

    /**
     * @return ComposerJsonFileUtilInterface
     */
    public function getComposerJsonFileUtil(): ComposerJsonFileUtilInterface
    {
        return $this->composerJsonFileUtil;
    }

    /**
     * @return DirectoryValidatorInterface
     */
    public function getDirectoryValidator(): DirectoryValidatorInterface
    {
        return $this->directoryValidator;
    }

    /**
     * @param string $filePath
     * @param object $composerJsonObject
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateNamespaceFromPath(string $filePath, object $composerJsonObject): string
    {
        $_file_path = realpath($filePath);
        $directoryValidation = $this->getDirectoryValidator()->validateDirectory($_file_path);
        if ($directoryValidation !== DirectoryValidatorInterface::OK) {
            throw new Exception(__METHOD__ . ' : ' . $directoryValidation);
        }

        $project_root = dirname($this->getComposerJsonFileUtil()->findComposerJSON($_file_path));
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;

        foreach ($composerJsonObject->autoload->$psr_4 as $namespace_root => $namespace_base_dir) {
            $_absolute_namespace_dir = rtrim($project_root . DIRECTORY_SEPARATOR . $namespace_base_dir, '\\/');
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

        throw new Exception(__METHOD__ . ' : ' . 'File path does not belong to any namespace.');
    }

    /**
     * @param string $namespace
     * @param string $projectRootDirectory
     * @param object $composerJsonObject
     *
     * @return string
     */
    public function generatePathFromNamespace(string $namespace, string $projectRootDirectory, object $composerJsonObject): string
    {
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;

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
                // If previously found namespace root is a substring of the currently processed namespace root, the result is the new namespace root.
                if (strpos($namespace_root, $match) !== false) {
                    $result = $_result;
                }
            }
        }

        return $result;
    }
}
