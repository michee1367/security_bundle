<?php

namespace Mink67\Security\Converters;

use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Mink67\OpenidConnect\AccessTokenToUser as BaseConverter;
use Psr\Log\LoggerInterface;

class AccessTokenToUser {

    /**
     * @var string
     */
    private $jwks_url;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var BaseConverter
     */
    private $baseConverter;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * 
     */
    public function __construct(
        string $jwk_url, 
        HttpClientInterface $httpClient,
        BaseConverter $baseConverter,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->jwks_url = $jwk_url;
        $this->httpClient = $httpClient;
        $this->baseConverter = $baseConverter;
    }

    /**
     * @return 
     * @param AccessToken $accessToken
     */
    public function __invoke(AccessToken $accessToken): ?UserInterface
    {
        $baseConverter = $this->baseConverter;

        try {
            $user = $baseConverter->convert($accessToken, $this->getJwksBrute());

            return $user; 
        }
        catch (\Throwable $th) {
            //dd($th);
            $this->logger->error($th->getMessage());
            return null;
        }


    }

    private function getJwksBrute()
    {
        $response = $this->httpClient->request(
            'GET',
            $this->jwks_url
        );

        $jwks = $response->getContent();
        //$arrJwks = json_decode($jwks, true);
        //dd($arrJwks);
        //$jwks = json_decode('{"keys":[{"kid":"03_XXHkCXEzMBafFGTNX_ay6bWTHVrNduQ_eNI61eUc","kty":"RSA","alg":"RS256","use":"sig","n":"noM0RPuT6fzbAoUcHu14DXtl9o5rMJfrMj5EGdWdzGt0CXRN93ICgtEsuxXZN2uquUS1mp3lw-tDda3C0SAITcLO07H8eCgj0UKOOYfBLsgnZY2VAeEpwxQhvzMls1inY18ph_m4S9wVlkca3L7SSPH3pQ2NY6IduF9Bo587Rn1GdrjVmCdhUOLqdOLOzduvPS_bp454yZWIxkny1rEXBztwvUN4F8XtbwuROGfMrIe9U-GpxsLW8neTUX8GZSbpVkgiZJ48oE3L7ntdijdZkUfZhXXiIptUa12RAtlJD9CLKQ7Wm2xOZ8PpmBbiAnuwloIXBfyl9pjL0EHGtzO3sQ","e":"AQAB","x5c":["MIIClTCCAX0CBgF/BxfenjANBgkqhkiG9w0BAQsFADAOMQwwCgYDVQQDDANSTkEwHhcNMjIwMjE3MDk0OTM5WhcNMzIwMjE3MDk1MTE5WjAOMQwwCgYDVQQDDANSTkEwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCegzRE+5Pp/NsChRwe7XgNe2X2jmswl+syPkQZ1Z3Ma3QJdE33cgKC0Sy7Fdk3a6q5RLWaneXD60N1rcLRIAhNws7Tsfx4KCPRQo45h8EuyCdljZUB4SnDFCG/MyWzWKdjXymH+bhL3BWWRxrcvtJI8felDY1joh24X0GjnztGfUZ2uNWYJ2FQ4up04s7N2689L9unjnjJlYjGSfLWsRcHO3C9Q3gXxe1vC5E4Z8ysh71T4anGwtbyd5NRfwZlJulWSCJknjygTcvue12KN1mRR9mFdeIim1RrXZEC2UkP0IspDtabbE5nw+mYFuICe7CWghcF/KX2mMvQQca3M7exAgMBAAEwDQYJKoZIhvcNAQELBQADggEBABdO3pDCr1OMQEQjJ6vf1RpYYcZYmkCSLJMX9ixG8EOPG6ybz05P4wnMbphbsP+uS++lnvG3Nao8PuoyjGaeP2/KoJoA/+dPT8BbI87w1L2P75KwcOCPjsaDvtpYGtQWjDmrBp5fWmMeVD7/NIIx7pYYHSZHH19bqPrBITXNZoguzvnSnr7JTGOUlPKI+7Kh7CpTajseDt804lgU7nOYA5Nv2ShA4y7AxzjvknOvQD4WJIhtCXQAMH+JEWdKqA7YEaVSN9VYdfC4Uf4ghWXVOqUkhVEAClUqckuau2Orw4rGPBjLNewsbgzFb/tjgw4EapCppw0liRv7MiqcYeazK44="],"x5t":"n8cE91HRUcwQ2fTpD-jDvRe_nYk","x5t#S256":"iM5pjVNGb7pnpDeQ2VIavM6wIohDYnxD8SToGXFJtDg"},{"kid":"h1Oe1-ssSM-UIl4-VyUB3Ocv6bYu-4NuSWunWBjD5yU","kty":"RSA","alg":"RSA-OAEP","use":"enc","n":"mwW7c4MmdDbs8FbvSpDq5IKHTw93KZCy_Z9Kw6nV63kDxujwWbaf81B8ff9kMNjvQ-pLaqlL5zVcQSFOXc43oAhpn3ERnpIlP0xmV5BSQ0MB6ffrROrps6LL2BSw71s7ppv096ngLxVKgQZzPT2-PHUu1CQXVxoDW-VWI6LR9wXoFS6_B4E_dLep1gFoR9cXrDAr2uy9pH4cPL9j_pYxmgw1aZfEGM9AMlOgoH1ONmfurs21h3VN1qKWXOpzecSFQ4vyuUQPUb5_p--wZQPqYLS2rXXK8JEGQzkOQ95FnfFXhx9m1L_0XwHyfN88twCjlhrqklQ6NJMOKF8amQqx5w","e":"AQAB","x5c":["MIIClTCCAX0CBgF/Bxfe5TANBgkqhkiG9w0BAQsFADAOMQwwCgYDVQQDDANSTkEwHhcNMjIwMjE3MDk0OTM5WhcNMzIwMjE3MDk1MTE5WjAOMQwwCgYDVQQDDANSTkEwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCbBbtzgyZ0NuzwVu9KkOrkgodPD3cpkLL9n0rDqdXreQPG6PBZtp/zUHx9/2Qw2O9D6ktqqUvnNVxBIU5dzjegCGmfcRGekiU/TGZXkFJDQwHp9+tE6umzosvYFLDvWzumm/T3qeAvFUqBBnM9Pb48dS7UJBdXGgNb5VYjotH3BegVLr8HgT90t6nWAWhH1xesMCva7L2kfhw8v2P+ljGaDDVpl8QYz0AyU6CgfU42Z+6uzbWHdU3WopZc6nN5xIVDi/K5RA9Rvn+n77BlA+pgtLatdcrwkQZDOQ5D3kWd8VeHH2bUv/RfAfJ83zy3AKOWGuqSVDo0kw4oXxqZCrHnAgMBAAEwDQYJKoZIhvcNAQELBQADggEBAJmXeW1WFQfS9CaEYOBHYw2Zz0K/rTIoS2nstzZSrwbtibCQJZdla51LV4Vjhd2Qy/dGcgiJfTf6TeuKKfcO2joIw45f/wxIpUCLJL4oCBwFUMQeeHC6Vo6ZFsStAB2uEsdOCv8lMTPZvajTXNdz70QKwYipeTkbP++JCOUaEVfh6Ge8bczwuL7H1NdifLu+pYmj1KpqXZBcxTdm1DWlnA7H2iTC8/NszHh65jVxmBWra2JfU9XGoBTLWDiZ7zJwj0rfmr4m5YnXB7lMmBBDjxKcmNC6dc5+hAkHMlxuvRHzdOybmsokTRA3z88OWD6vRMaXj58Vq9nKqeNqv3v49os="],"x5t":"v5ikmvUcOxGdTrVsuzq5CcaHAcU","x5t#S256":"jbGoeBL6_WvYgI08fGFKBVTChrI3x11PmBDa6ytXvwc"}]}', true);
        return $jwks;
    }
}