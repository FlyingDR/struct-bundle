<?php

namespace Flying\Bundle\StructBundle;

use Flying\Struct\Configuration;
use Flying\Struct\ConfigurationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlyingStructBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();
        $configuration = $this->container->get('flying_struct.configuration');
        $nsMap = $this->container->getParameter('flying_struct.nsmap');
        $configuration->getAnnotationNamespacesMap()->add($nsMap['annotation']);
        $configuration->getPropertyNamespacesMap()->add($nsMap['property']);
        $configuration->getStructNamespacesMap()->add($nsMap['struct']);
        ConfigurationManager::setConfiguration($configuration);
    }

}
