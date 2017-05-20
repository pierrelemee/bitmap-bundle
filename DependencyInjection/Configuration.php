<?php

namespace Bitmap\Bundle\BitmapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getAlias()
    {
        return 'bitmap';
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('bitmap');
        $root

            ->children()
            ->arrayNode('connections')
                ->prototype('array')
                    ->children()
                    ->scalarNode('scheme')->isRequired()->end()
                    ->scalarNode('host')->isRequired()->end()
                    ->scalarNode('user')->end()
                    ->scalarNode('password')->end()
                    ->scalarNode('name')->end()
                    ->integerNode('port')->end()
                    ->arrayNode('extra')
                        ->requiresAtLeastOneElement()
                        ->useAttributeAsKey('whatever')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}