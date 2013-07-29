<?php

namespace Flying\Bundle\StructBundle\DependencyInjection;

use Flying\Struct\Configuration as StructConfiguration;
use Flying\Struct\Configuration\NamespacesMap;
use Flying\Struct\ConfigurationManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FlyingStructExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $config = $this->processConfiguration(new Configuration(), $configs);
        /** @var $configuration StructConfiguration */
        $configuration = $container->get('flying_struct.configuration');
        $this->registerNsMap($configuration->getAnnotationNamespacesMap(), $config['nsmap']['annotation']);
        $this->registerNsMap($configuration->getPropertyNamespacesMap(), $config['nsmap']['property']);
        $this->registerNsMap($configuration->getStructNamespacesMap(), $config['nsmap']['struct']);
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
