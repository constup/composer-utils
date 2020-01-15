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
     * @return array
     */
    public function getAllBaseComposerAutoloadNamespaces(): array
    {
        $psr_4 = self::PSR_4;
        $composerJsonObject = $this->getComposerJsonObject();
        $result = [];

        foreach ($composerJsonObject->autoload->$psr_4 as $namespace_root => $namespace_base_dir) {
            $result[$namespace_root] = $namespace_base_dir;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAllBaseComposerAutoloadDevNamespaces(): array
    {
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;
        $composerJsonObject = $this->getComposerJsonObject();
        $result = [];

        foreach ($composerJsonObject->$autoload_dev->$psr_4 as $namespace_root => $namespace_base_dir) {
            $result[$namespace_root] = $namespace_base_dir;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getAllBaseComposerNamespaces(): array
    {
        return array_merge($this->getAllBaseComposerAutoloadNamespaces(), $this->getAllBaseComposerAutoloadDevNamespaces());
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
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;
        $_file_path = realpath($filePath);

        $projectRootDirectory = $this->getProjectRootDirectory();
        $allBaseComposerAutoloadNamespaces = $this->getComposerJsonObject()->autoload->$psr_4;
        $allBaseComposerAutoloadDevNamespaces = $this->getComposerJsonObject()->$autoload_dev->$psr_4;

        foreach ($allBaseComposerAutoloadNamespaces as $namespace_root => $namespace_base_dir) {
            $_absolute_namespace_dir = realpath(rtrim($projectRootDirectory . DIRECTORY_SEPARATOR . $namespace_base_dir, '\\/'));
            if (strpos($_file_path, $_absolute_namespace_dir) === 0) {
                return rtrim(str_replace('\\\\', '\\', $namespace_root . substr($_file_path, strlen($_absolute_namespace_dir))), '\\');
            }
        }
        foreach ($allBaseComposerAutoloadDevNamespaces as $namespace_root => $namespace_base_dir) {
            $_absolute_namespace_dir = rtrim($projectRootDirectory . DIRECTORY_SEPARATOR . $namespace_base_dir, '\\/');
            if (strpos($_file_path, $_absolute_namespace_dir) === 0) {
                return rtrim(str_replace('\\\\', '\\', $namespace_root . substr($_file_path, strlen($_absolute_namespace_dir))), '\\');
            }
        }

        throw new Exception(__METHOD__ . ' : ' . 'File path "' . $_file_path . '" does not belong to any namespace.');
    }

    /**
     * Use this method to generate a directory path based on a namespace.
     * To generate PHP file path instead, @see NamespaceUtilInterface::generatePathFromFqcn() instead.
     *
     * @param string $namespace
     *
     * @return string
     */
    public function generatePathFromNamespace(string $namespace): string
    {
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;

        $projectRootDirectory = $this->getProjectRootDirectory();
        $allBaseComposerAutoloadNamespaces = $this->getComposerJsonObject()->autoload->$psr_4;
        $allBaseComposerAutoloadDevNamespaces = $this->getComposerJsonObject()->$autoload_dev->$psr_4;

        $result = '';
        $match = '';
        foreach ($allBaseComposerAutoloadNamespaces as $namespace_root => $namespace_base_dir) {
            if (strpos($namespace, $namespace_root) === 0) {
                $_namespace_base_dir = str_replace('/', DIRECTORY_SEPARATOR, $namespace_base_dir);
                $_namespace = substr_replace($namespace, $_namespace_base_dir, 0, strlen($namespace_root));
                $match = $namespace_root;
                $result = rtrim($projectRootDirectory, '\\/') . DIRECTORY_SEPARATOR . $_namespace;
            }
        }

        foreach ($allBaseComposerAutoloadDevNamespaces as $namespace_root => $namespace_base_dir) {
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

        return $result;
    }

    /**
     * Use this method to generate a PHP file path based on its FQCN.
     * To determine a directory path based on namespace, @see NamespaceUtilInterface::generatePathFromNamespace() instead.
     *
     * @param string $fqcn
     *
     * @return string|null
     */
    public function generatePathFromFqcn(string $fqcn): ?string
    {
        return (empty($this->generatePathFromNamespace($fqcn))) ? null : $this->generatePathFromNamespace($fqcn) . '.php';
    }

    /**
     * @param string $fqcn
     *
     * @return bool
     */
    public function fileWithFqcnExists(string $fqcn): bool
    {
        $filename = $this->generatePathFromFqcn($fqcn);

        return file_exists($filename) && is_file($filename);
    }

    /**
     * @param string $namespaceOrFqcn
     *
     * @return string
     */
    public function getComposerBaseNamespace(string $namespaceOrFqcn): string
    {
        $psr_4 = self::PSR_4;
        $autoload_dev = self::AUTOLOAD_DEV;

        $autoloadNamespaces = $this->getComposerJsonObject()->autoload->$psr_4;
        $autoloadDevNamespaces = $this->getComposerJsonObject()->$autoload_dev->$psr_4;
        $allBaseComposerNamespaces = array_merge($autoloadNamespaces, $autoloadDevNamespaces);
        $result = '';

        foreach ($allBaseComposerNamespaces as $namespaceRoot => $namespaceBaseDir) {
            if ((strpos($namespaceOrFqcn, $namespaceRoot) === 0) && (strlen($result) < strlen($namespaceRoot))) {
                $result = $namespaceRoot;
            }
        }

        return $result;
    }

    /**
     * @param string $componentFqcn
     * @param string $testNamespaceMarker
     *
     * @return string
     */
    public function generateTestNamespaceForComponent(string $componentFqcn, string $testNamespaceMarker = self::TEST_NAMESPACE_MARKER_TESTS): string
    {
        $baseComponentNamespace = $this->getComposerBaseNamespace($componentFqcn);
        $baseComponentTestNamespace = $baseComponentNamespace . $testNamespaceMarker . '\\';

        return str_replace($baseComponentNamespace, $baseComponentTestNamespace, $componentFqcn);
    }
}
