<?php

namespace Mink67\Security\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBag;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class TokenManager {

    /**
     * @var ContainerBag
     */
    private $containerBag;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * 
     */
    public function __construct(
        HttpClientInterface $httpClient,
        ContainerBagInterface $containerBag
    ) {
        $this->httpClient = $httpClient;
        $this->containerBag = $containerBag;
    }

    /**
     * @return 
     */
    public function __invoke()
    {
        $host = $this->containerBag->get("mink67.security.host");
        $path = $this->containerBag->get("mink67.security.path_token");
        $keycloackAppUserName = $this->containerBag->get("mink67.security.keycloak.user_name");
        $keycloackAppPassword = $this->containerBag->get("mink67.security.keycloak.pw");
        $keycloackAppClientSecret = $this->containerBag->get("mink67.security.keycloak.client_secret");
        $keycloackAppClientId = $this->containerBag->get("mink67.security.keycloak.client_id");

        if (
            is_null($host) ||
            is_null($path)
        ) {
            return "";
        }


        $response = $this->httpClient->request(
            'POST', 
            $host . "/" . $path, [
                'body' => [
                    'username' => $keycloackAppUserName,
                    'password' => $keycloackAppPassword, 
                    'client_secret' => $keycloackAppClientSecret, 
                    'grant_type' => 'password', 
                    'client_id' => $keycloackAppClientId, 
                ],
        ]);

        $content = $response->getContent();
        $objContent = json_decode($content);

        return $objContent->access_token;

    }

}