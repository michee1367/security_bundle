<?php

namespace Mink67\Security\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * 
 */
class Mink67SecurityExtension extends Extension {


    /**
     * Loads a specific configuration.
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container){

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__. "/../Resources/config")
        );

        $loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        //dd($config);

        $container->setParameter("mink67.security.jwk_url", $config["jwk_url"]);
        /*$container->setParameter("oauth.client.secret", $config["secret"]);
        $container->setParameter("oauth.client.server_host_name", $config["server_host_name"]);
        $container->setParameter("oauth.client.oauth_login_url", $config["oauth_login_url"]);
        $container->setParameter("oauth.client.oauth_home_url", $config["oauth_home_url"]);
        $container->setParameter("oauth.client.data_convert", $config["data_convert"]);*/

        //dd((string) u("For-oo_iir")->camel());
        

        //dd($this->data_convert);
        

    }

}
