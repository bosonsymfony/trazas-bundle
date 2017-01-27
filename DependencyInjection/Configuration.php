<?php

namespace UCI\Boson\TrazasBundle\DependencyInjection;

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
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('trazas');

        $rootNode
            ->children()
                ->arrayNode("types")
                    ->children()
                        ->booleanNode('data')->isRequired()->end()
                        ->booleanNode('action')->isRequired()->end()
                        ->booleanNode('exception')->isRequired()->end()
                        ->booleanNode('performance')->isRequired()->end()
                    ->end()
                ->end()
                ->scalarNode("doctrine_manager")->defaultValue("doctrine")->end()
            ->end();
        return $treeBuilder;
    }

}
