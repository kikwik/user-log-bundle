<?php

namespace Kikwik\UserLogBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('kikwik_userlog');
        $rootNode = $treeBuilder->getRootNode();

//        $rootNode
//            ->children()
//            ->scalarNode('user_class')->defaultValue('App\Entity\User')->cannotBeEmpty()->end()
//            ->end()
//        ;

        return $treeBuilder;
    }

}