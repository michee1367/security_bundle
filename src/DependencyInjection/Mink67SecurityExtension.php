<?php

namespace Mink67\Security\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use function Symfony\Component\String\u;
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
        $container->setParameter("mink67.security.host", isset($config["host"]) ? $config["host"]:null);
        $container->setParameter("mink67.security.path_token", isset($config["path_token"]) ? $config["path_token"]:null);
        $container->setParameter(
            "mink67.security.keycloak.user_name", 
            isset($config["keycloak_user_name"]) ? $config["keycloak_user_name"]:null
        );
        $container->setParameter(
            "mink67.security.keycloak.pw", 
            isset($config["keycloak_pw"]) ? $config["keycloak_pw"]:null
        );
        $container->setParameter(
            "mink67.security.keycloak.client_secret",
            isset($config["keycloak_client_secret"]) ? $config["keycloak_client_secret"]:null
        );
        $container->setParameter(
            "mink67.security.keycloak.client_id", 
            isset($config["keycloak_client_id"]) ? $config["keycloak_client_id"]:null
        );
        $container->setParameter(
            "mink67.security.keycloak.realm", 
            isset($config["keycloak_realm"]) ? $config["keycloak_realm"]:null
        );
        //
        
        /*$container->setParameter("oauth.client.oauth_login_url", $config["oauth_login_url"]);
        $container->setParameter("oauth.client.oauth_home_url", $config["oauth_home_url"]);
        $container->setParameter("oauth.client.data_convert", $config["data_convert"]);*/

        //dd((string) u("For-oo_iir")->camel());
        

        //dd($this->data_convert);
        

    }

}
