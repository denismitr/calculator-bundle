<?php

declare(strict_types=1);


namespace Denismitr\CalculatorBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('denismitr_calculator');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('algorithm')
                    ->cannotBeEmpty()
                    ->defaultValue('denismitr_calculator.dijkstra_two_stack_algorithm')
                ->end()
            ->end();

        return $treeBuilder;
    }
}