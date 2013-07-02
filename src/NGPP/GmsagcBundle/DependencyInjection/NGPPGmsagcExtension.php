<?php

namespace NGPP\GmsagcBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NGPPGmsagcExtension extends Extension
{
    /**
     * Load the configuration for the bundle
     * 
     * @param array $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        foreach($config as $key => $value)
        {
            $container->setParameter('ngpp_gmsagc.'.$key, $value);
        }
    }
}
