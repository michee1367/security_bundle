<?php

/**
 * 
 */

namespace Mink67\Security\User;

use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Mink67\OpenidConnect\Contracts\User\OAuthUser as IUserOAuth;

class OAuthUser implements UserInterface, IUserOAuth
{
    /**
     * @var AccessToken
     */
    private $accessToken;
    private $roles;
    private $id;
    private $username;
    private $clientId;
    private $realmsUrl;
    private $scope;

    public function __construct(
        AccessToken $accessToken, 
        array $roles,
        string $id,
        string $username,
        string $clientId,
        string $realmsUrl,//scope
        string $scope,//scope
    )
    {
        $this->accessToken = $accessToken;
        $this->roles = $roles;
        $this->id = $id;
        $this->username = $username;
        $this->clientId = $clientId;
        $this->realmsUrl = $realmsUrl;
        $this->scope = $scope;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
    /**
     * Get the value of accesss_token
     */ 
    public function getAccessToken(): AccessToken {
        return $this->accessToken;
    }

    public function getPassword(): ?string
    {
        return '';
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->accessToken->getToken();
    }

    /**
     * @deprecated use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->accessToken->getToken();
    }

    public function eraseCredentials()
    {
        // Do nothing.
    }

    /**
     * Get the value of id
     */ 
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of username
     */ 
    public function getNormalUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setNormalUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of clientId
     */ 
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Set the value of clientId
     *
     * @return  self
     */ 
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get the value of realmsUrl
     */ 
    public function getRealmsUrl(): string
    {
        return $this->realmsUrl;
    }

    /**
     * Set the value of realmsUrl
     *
     * @return  self
     */ 
    public function setRealmsUrl($realmsUrl)
    {
        $this->realmsUrl = $realmsUrl;

        return $this;
    }

    /**
     * Get the value of scope
     */ 
    public function getScope(): string
    {
        return $this->scope;
    }

    /**
     * Set the value of scope
     *
     * @return  self
     */ 
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }
}
