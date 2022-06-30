<?php

namespace Mink67\Security\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * 
 */
class Configuration implements ConfigurationInterface {


    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder(){
        $treepBuilder = new TreeBuilder("mink67_security");

        
        $root = $treepBuilder->getRootNode();

        if($root instanceof ArrayNodeDefinition){
            $root
                ->children()
                        ->scalarNode("jwk_url")
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode("host")
                        ->end()
                        ->scalarNode("path_token")
                        ->end()
                        ->scalarNode("keycloak_user_name")
                        ->end()
                        ->scalarNode("keycloak_pw")
                        ->end()
                        ->scalarNode("keycloak_client_secret")
                        ->end()
                        ->scalarNode("keycloak_client_id")
                        ->end()
                        ->scalarNode("keycloak_realm")
                        ->end()
                      /*  ->arrayNode("data_convert")
                        ->isRequired()
                        //->cannotBeEmpty()
                        ->children()
                            ->scalarNode("phone")
                            ->isRequired()
                        ->end()
                            ->scalarNode("name")
                            ->isRequired()
                        ->end()
                            ->scalarNode("first_name")
                            ->isRequired()
                        ->end()
                            ->scalarNode("last_name")
                            ->isRequired()
                        ->end()
                            ->scalarNode("sexe")
                            ->isRequired()
                        ->end()
                            ->scalarNode("email")
                            ->isRequired()
                        ->end()
                    ->end()*/
                ->end()
            ;

        }else{

            throw new InvalidConfigurationException("Root must be an instance to ArrayNodeDefinition");
        }

        return $treepBuilder;

        
    }

}