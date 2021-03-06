<?php

namespace Antilop\Bundle\MailjetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mailjet');
        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('client')
                    ->children()
                        ->scalarNode('api_key')->end()
                        ->scalarNode('api_secret_key')->end()
                    ->end()
                ->end()
                ->arrayNode('from')
                    ->children()
                        ->scalarNode('email')->end()
                        ->scalarNode('name')->end()
                    ->end()
                ->end()
                ->arrayNode('templates')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('id')->end()
                            ->scalarNode('from_email')->end()
                            ->scalarNode('from_name')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
