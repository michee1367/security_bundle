<?php

namespace Mink67\Security\Services\User;

use Mink67\Security\Services\TokenManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class GetAll {


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
    public function __invoke(int $first=0, int $max=20, string $search=null)
    {
        $tokenManager = $this->tokenManager;
        $token = $tokenManager();

        $host = $this->containerBag->get("mink67.security.host");
        $realm = $this->containerBag->get("mink67.security.keycloak.realm");
        $path = $this->containerBag->get("mink67.security.path_token");
        $path = "auth/admin/realms/".$realm."/users";
        $query = [
            'first' => $first,
            'max' => $max,
            //'search' => $search,
            'briefRepresentation' => false,
        ];

        if (is_null($search)) {

            $query["search"] = $search;

        }

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