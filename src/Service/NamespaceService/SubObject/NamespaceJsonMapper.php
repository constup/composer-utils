<?php

declare(strict_types = 1);
/**
 * This file has been automatically generated by Constup Automatrix.
 * https://constup.com/automatrix
 */

namespace Constup\ComposerUtils\Service\NamespaceService\SubObject;

use Constup\Automatrix\LanguagePhp\Version0702\DesignPatternInterfaces\JsonMapperInterface;
use Constup\Automatrix\LanguagePhp\Version0702\JsonMapper\AbstractJsonMapper;
use stdClass;

class NamespaceJsonMapper extends AbstractJsonMapper implements JsonMapperInterface
{
    /**
     * @param object $json
     *
     * @return NamespaceImmutableObjectInterface|null
     */
    public function fromJson(object $json): ?NamespaceImmutableObjectInterface
    {
        $namespace = $json->namespace;
        $absoluteDirectory = $json->absoluteDirectory;

        return new NamespaceImmutableObject($namespace, $absoluteDirectory);
    }

    /**
     * @param NamespaceImmutableObjectInterface $object
     *
     * @return object|null
     */
    public function toJson(NamespaceImmutableObjectInterface $object): ?object
    {
        $namespace = $object->getNamespace();
        $absoluteDirectory = $object->getAbsoluteDirectory();

        $result = new stdClass();
        $result->automatrixDeserializer = get_class($object);
        $result->namespace = $namespace;
        $result->absoluteDirectory = $absoluteDirectory;

        return $result;
    }
}
