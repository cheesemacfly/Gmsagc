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
                        ->arrayNode('owner')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(1)->end()
                                ->scalarNode('name')->defaultValue('Propriétaire')->end()
                            ->end()
                        ->end()
                        ->arrayNode('customer')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(2)->end()
                                ->scalarNode('name')->defaultValue('Client')->end()
                            ->end()
                        ->end();
        $rootNode
            ->children()
                ->arrayNode('actions')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('molding')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(1)->end()
                                ->scalarNode('name')->defaultValue('MOULAGE')->end()
                            ->end()
                        ->end()
                        ->arrayNode('prototype')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(2)->end()
                                ->scalarNode('name')->defaultValue('MOULE PROTOTYPE')->end()
                            ->end()
                        ->end()
                        ->arrayNode('reparation')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(3)->end()
                                ->scalarNode('name')->defaultValue('REPARATION')->end()
                            ->end()
                        ->end()
                        ->arrayNode('mold')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(4)->end()
                                ->scalarNode('name')->defaultValue('MOULE')->end()
                            ->end()
                        ->end()
                        ->arrayNode('modification')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(5)->end()
                                ->scalarNode('name')->defaultValue('MODIFICATION')->end()
                            ->end()
                        ->end()
                        ->arrayNode('miscellaneous')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(6)->end()
                                ->scalarNode('name')->defaultValue('DIVERS')->end()
                            ->end()
                        ->end()
                        ->arrayNode('piece')->addDefaultsIfNotSet()
                            ->children()
                                ->integerNode('id')->defaultValue(7)->end()
                                ->scalarNode('name')->defaultValue('PIECE USINEE')->end()
                            ->end()
                        ->end()
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
                    ->scalarNode('ROLE_ADMIN')->defaultValue('Administrateurs')->end()
                    ->scalarNode('ROLE_USER')->defaultValue('Utilisateurs')->end()
            ->end();

        return $treeBuilder;
    }
}
