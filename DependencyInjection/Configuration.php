<?php

namespace Flying\Bundle\StructBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $tb = new TreeBuilder();
        // @formatter:off
        /** @noinspection PhpUndefinedMethodInspection */
        $tb
            ->root('flying_struct')
                ->children()
                    ->arrayNode('nsmap')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('property')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('struct')
                                ->requiresAtLeastOneElement()
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                    ->scalarNode('metadata_manager')
                        ->defaultValue('flying_struct.metadata_manager')
                    ->end()
                    ->scalarNode('metadata_parser')
                        ->defaultValue('flying_struct.metadata_parser')
                    ->end()
                    ->scalarNode('cache')
                        ->defaultNull()
                    ->end()
                    ->scalarNode('storage')
                        ->defaultValue('flying_struct.storage')
                    ->end()
                    ->scalarNode('storage_backend')
                        ->defaultValue('flying_struct.storage_backend.array')
                    ->end()
                ->end()
            ->end()
        ;
        // @formatter:on

        return $tb;
    }

}
