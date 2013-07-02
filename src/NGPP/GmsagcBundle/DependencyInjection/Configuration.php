<?php

namespace NGPP\GmsagcBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Defines the configuration tree for the bundle
     * 
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ngpp_gmsagc');

        $rootNode
            ->children()
                ->integerNode('results_per_page')
                ->min(10)
                ->max(100)
                ->defaultValue(10)
                ->end()
            ->end();
        $rootNode
            ->children()
                ->arrayNode('types')->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('owner')->defaultValue(1)->end()
                    ->integerNode('customer')->defaultValue(2)->end()
            ->end();
        $rootNode
            ->children()
                ->arrayNode('actions')->addDefaultsIfNotSet()
                ->children()
                    ->integerNode('creation')->defaultValue(1)->end()
                    ->integerNode('modification')->defaultValue(2)->end()
            ->end();
        $rootNode
            ->children()
                ->arrayNode('users')->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('admin')->defaultValue('password')->end()
            ->end();
        $rootNode
            ->children()
                ->arrayNode('groups')->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('ROLE_ADMIN')->defaultValue('Admistrators')->end()
                    ->scalarNode('ROLE_USER')->defaultValue('Users')->end()
            ->end();

        return $treeBuilder;
    }
}
