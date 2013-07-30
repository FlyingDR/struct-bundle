<?php

namespace Flying\Bundle\StructBundle;

use Flying\Struct\Configuration\NamespacesMap;
use Flying\Struct\ConfigurationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Flying\Struct\Configuration;

class FlyingStructBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();
        /** @var $configuration Configuration */
        $configuration = $this->container->get('flying_struct.configuration');
        $nsMap = $this->container->getParameter('flying_struct.nsmap');
        $this->registerNsMap($configuration->getAnnotationNamespacesMap(), $nsMap['annotation']);
        $this->registerNsMap($configuration->getPropertyNamespacesMap(), $nsMap['property']);
        $this->registerNsMap($configuration->getStructNamespacesMap(), $nsMap['struct']);
        ConfigurationManager::setConfiguration($configuration);
    }

    /**
     * Register given namespaces into given namespaces map
     *
     * @param NamespacesMap $nsMap
     * @param array $namespaces
     * @return void
     */
    protected function registerNsMap(NamespacesMap $nsMap, array $namespaces)
    {
        foreach ($namespaces as $alias => $ns) {
            if (!is_string($alias)) {
                $alias = strtolower(str_replace('\\', '_', $ns));
            }
            $nsMap->add($alias, $ns);
        }
    }

}
