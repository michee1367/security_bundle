<?php

namespace Mink67\Security\Security;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\KeycloakClient;
use Stevenmaguire\OAuth2\Client\Provider\Keycloak;
use KnpU\OAuth2ClientBundle\Security\User\OAuthUserProvider;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use \Mink67\Security\Converters\AccessTokenToUser;

class KeycloakAuthenticator extends AbstractAuthenticator {

    /**
     * @var AccessTokenToUser
     */
    private $userConverter;

    /**
     * @param AccessTokenToUser $userConverter
     */
    public function __construct(AccessTokenToUser $userConverter)
    {
        $this->userConverter = $userConverter;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    { 
        $data = [
            // you might translate this message
            'message' => "Not token emit"
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
    /**
     * 
     */
    public function authenticate(Request $request): Passport
    {
        $identifier = "" ;
        $bearerToken = $request->headers->get("Authorization");
        if (!is_null($bearerToken)) {
            
            $identifier = str_replace("Bearer ", "", $request->headers->get("Authorization"));
        }

        //dd($request->headers->get("Authorization"));

        $userConverter = $this->getUserConverter();

        return new SelfValidatingPassport(
            new UserBadge(
                $identifier,
                function (string $identifier) use($userConverter)
                {
                    if (empty($identifier)) {
                        return null;
                    }
                    $accessToken = new AccessToken(["access_token" => $identifier, "token_type" => "bearer"]);
                    return $userConverter($accessToken);
                }
            )
        );
    }
    /**
     * 
     */
    private function getUserConverter()
    {
        return $this->userConverter;
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            //'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
            'message'=>'Authentification échouée',
            'detail'=> $exception->getMessageData()
            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return null;
    }

    public function supportsRememberMe() : bool 
    {
        return false;
    }

}