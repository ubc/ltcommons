<?php
namespace UBC\LtCommons;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration the configuration class to valid the library configuration yaml file
 * @package UBC\LtCommons
 */
class Configuration implements ConfigurationInterface {

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ltcommons');

        $rootNode
            ->children()
                ->append($this->addAuth2Node())
                ->append($this->addSISNode())
            ->end()
        ;

        return $treeBuilder;
    }

    public function addAuth2Node()
    {

        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('Auth2');

        $node
            ->children()
                ->scalarNode('username')
                    ->isRequired()
                ->end()
                ->scalarNode('password')
                    ->isRequired()
                ->end()
                ->scalarNode('service_application')
                    ->isRequired()
                ->end()
                ->scalarNode('service_url')
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $node;
    }

    public function addSISNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('SIS');

        $node
            ->children()
                ->scalarNode('base_url')
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $node;
    }
}