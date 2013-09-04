<?php

namespace Flying\Bundle\StructBundle\DependencyInjection;

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
        $nsMap = $container->getParameter('flying_struct.nsmap');
        foreach ($nsMap as $type => $map) {
            if ((array_key_exists($type, $config['nsmap'])) &&
                (is_array($config['nsmap'][$type])) &&
                (sizeof($config['nsmap'][$type]))
            ) {
                $nsMap[$type] = $map;
            }
        }
        $container->setParameter('flying_struct.nsmap', $nsMap);
    }

}
