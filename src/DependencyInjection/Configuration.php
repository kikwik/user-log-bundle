<?php

namespace Kikwik\UserLogBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('kikwik_user_log');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('enable_log')->defaultTrue()->end()
                ->booleanNode('enable_admin')->defaultTrue()->end()
                //TODO: user entity class should be a parameter: https://symfony.com/doc/current/doctrine/resolve_target_entity.html
                //->scalarNode('user_class')->defaultValue('App\Entity\User')->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }

}