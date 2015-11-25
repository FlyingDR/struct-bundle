<?php

namespace Flying\Bundle\StructBundle;

use Flying\Bundle\StructBundle\DependencyInjection\Compiler\ConfigurationSetupPass;
use Flying\Struct\Configuration;
use Flying\Struct\ConfigurationManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlyingStructBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConfigurationSetupPass());
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();
        // Structures configuration should be stored into ConfigurationManager
        // at the very beginning of application launch process
        // because structures themselves have no idea about Symfony container
        /** @var Configuration $configuration */
        $configuration = $this->container->get('flying_struct.configuration');
        ConfigurationManager::setConfiguration($configuration);
    }
}
