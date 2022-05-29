<?php


namespace Kikwik\UserLogBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Yaml\Yaml;

class KikwikUserLogExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $enableAdmin = isset($configs[0]['enable_admin'])
            ? $configs[0]['enable_admin']
            : true;

        if($enableAdmin)
        {
            $bundles = $container->getParameter('kernel.bundles');
            if (isset($bundles['KikwikAdminBundle']))
            {
                $configForAdmin = Yaml::parseFile(__DIR__.'/../Resources/config/kikwik_admin.yaml');
                $container->prependExtensionConfig('kikwik_admin', $configForAdmin);
            }
        }
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $userLogSubscriber = $container->getDefinition('kikwik_user_log.event_subscriber.user_log_subscriber');
        $userLogSubscriber->setArgument('$enableLog', $config['enable_log']);
    }

}