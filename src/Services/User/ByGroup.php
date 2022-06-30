<?php

namespace Mink67\Security\Services\User;

use Mink67\Security\Services\TokenManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class ByGroup {


    /**
     * @var ContainerBag
     */
    private $containerBag;
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var TokenManager
     */
    private $tokenManager;

    /**
     * 
     */
    public function __construct(
        HttpClientInterface $httpClient,
        TokenManager $tokenManager,
        ContainerBagInterface $containerBag
    ) {
        $this->httpClient = $httpClient;
        $this->tokenManager = $tokenManager;
        $this->containerBag = $containerBag;
    }

    /**
     * @return 
     */
    public function __invoke(string $id, int $first=0, int $max=20)
    {
        $tokenManager = $this->tokenManager;
        $token = $tokenManager();

        $host = $this->containerBag->get("mink67.security.host");
        $path = $this->containerBag->get("mink67.security.path_token");
        $realm = $this->containerBag->get("mink67.security.keycloak.realm");
        //mink67.security.keycloak.realm
        $path = "auth/admin/realms/".$realm."/"."groups/".$id."/members";

        $query = [
            'first' => $first,
            'max' => $max,
            //'search' => $search,
            'briefRepresentation' => false,
        ];

        $response = $this->httpClient->request(
            'GET', 
            $host . "/" . $path, [
                "headers" => [
                    "Authorization"=> "Bearer $token",
                    "Content-Type"=> "application/json",
                ],
                'query' => $query,
        ]);

        $content = $response->getContent();
        $objContent = json_decode($content);

        return $objContent;
    }

}