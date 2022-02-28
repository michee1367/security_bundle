<?php

/*
 * 
 */

namespace Mink67\Security\User\OpenidConnect;

use League\OAuth2\Client\Token\AccessToken;
use Mink67\OpenidConnect\Contracts\User\OAuthUser as IUserOAuth;
use Mink67\Security\User\OAuthUser;
use Mink67\OpenidConnect\Contracts\User\OAuthUserProvider as IOAuthUserProvider;

class OAuthUserProvider implements IOAuthUserProvider
{


    /**
     * Return the OAuthUser
     * @return OAuthUser
     * 
     */
    public function getOAuthUser(
        AccessToken $accessToken, 
        array $roles,
        string $id,
        string $username,
        string $clientId,
        string $realmsUrl,
        string $scope
    ) : IUserOAuth {

        return new OAuthUser(
            $accessToken,
            $roles,
            $id,
            $username,
            $clientId,
            $realmsUrl,
            $scope
        );   
    }
}
