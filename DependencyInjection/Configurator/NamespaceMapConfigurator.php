<?php

namespace Flying\Bundle\StructBundle\DependencyInjection\Configurator;

use Flying\Struct\Configuration;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Configurator of namespaces map for structures configuration
 */
class NamespaceMapConfigurator
{
    /**
     * @var array
     */
    protected $nsMap;

    /**
     * @param array $nsMap
     */
    public function __construct(array $nsMap)
    {
        $this->nsMap = $nsMap;
    }

    /**
     * Apply namespaces map configuration to given structures configuration object
     *
     * @param Configuration $configuration
     * @throws InvalidArgumentException
     * @return void
     */
    public function configure(Configuration $configuration)
    {
        foreach ($this->nsMap as $type => $map) {
            if (!sizeof($map)) {
                continue;
            }
            $method = 'get' . ucfirst($type) . 'NamespacesMap';
            if (!method_exists($configuration, $method)) {
                throw new InvalidArgumentException('Invalid type of structure namespaces map: ' . $type);
            }
            /** @var $nsMap Configuration\NamespacesMap */
            $nsMap = $configuration->$method();
            $nsMap->add($map);
        }
    }
}
