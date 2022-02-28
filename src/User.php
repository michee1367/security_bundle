<?php

namespace Mink67\Security;

use Mink67\Security\Contracts\User as ContractsUser;

/**
 * 
 */
class User implements ContractsUser {

    /**
     * 
     */
    public function getUserIdentifier()
    {
        return null;
    }
    /**
     * 
     */
    public function getRoles()
    {
        return null;
    }


    /**
     * 
     */
    public function getPassword()
    {
        return null;
    }
    /**
     * 
     */
    public function eraseCredentials()
    {
        return null;
    }
    /**
     * 
     */
    public function getUsername()
    {
        return null;        
    }
    /**
     * 
     */
    public function getSalt()
    {
        return null;
    }
}