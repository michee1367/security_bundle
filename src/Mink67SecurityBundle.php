<?php

namespace Mink67\Security;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Perment de créer un un kafka connect
 */
class Mink67SecurityBundle extends Bundle
{

    /**
     * 
     */
    public function __construct() 
    {
        //$this->name = "mink67.security.bundle";
    }

    /**
     * 
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

    }
}