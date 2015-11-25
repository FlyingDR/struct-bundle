<?php

namespace Flying\Bundle\StructBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Prepare container definition for structures configuration object
 */
class ConfigurationSetupPass implements CompilerPassInterface
{
    /**
     * List of configuration parameters that should be mapped to Configuration object
     *
     * @var array
     */
    protected static $paramsList = array(
        'metadata_manager',
        'metadata_parser',
        'cache',
        'storage',
        'storage_backend',
    );

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('flying_struct.configuration')) {
            return;
        }
        $definition = $container->getDefinition('flying_struct.configuration');
        $config = $container->getParameter('flying_struct.configuration');
        foreach (self::$paramsList as $name) {
            if (!array_key_exists($name, $config)) {
                continue;
            }
            $param = $config[$name];
            if (!$param) {
                continue;
            }
            $value = null;
            if ($container->hasDefinition($param)) {
                $value = new Reference($param);
            } elseif (class_exists($param)) {
                $value = new Definition($param);
                $value->setPublic(false);
            } else {
                throw new InvalidArgumentException('Invalid value is defined for structures configuration parameter: ' . $name);
            }
            $method = explode(' ', str_replace('_', ' ', $name));
            array_walk($method, function (&$v) {
                $v = ucfirst($v);
            });
            $method = 'set' . implode('', $method);
            $definition->addMethodCall($method, array($value));
        }
        // Configure namespaces maps if we have them
        $nsMap = $config['nsmap'];
        $count = 0;
        foreach ($nsMap as $map) {
            $count += count($map);
        }
        if ($count > 0) {
            $configurator = new Definition('Flying\Bundle\StructBundle\DependencyInjection\Configurator\NamespaceMapConfigurator');
            $configurator
                ->addArgument($nsMap)
                ->setPublic(false);
            $id = 'flying_struct.nsmap.configurator';
            $container->setDefinition($id, $configurator);
            $definition->setConfigurator(array(new Reference($id), 'configure'));
        }
    }
}
