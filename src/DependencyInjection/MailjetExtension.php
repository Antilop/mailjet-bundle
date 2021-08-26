<?php

namespace Antilop\Bundle\MailjetBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MailjetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!empty($config)) {
            $container->setParameter('mailjet.api_key', $config['client']['api_key']);
            $container->setParameter('mailjet.secret_key', $config['client']['api_secret_key']);
            $container->setParameter('mailjet.templates', $config['templates']);
        }

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');
    }
}