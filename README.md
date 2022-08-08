# Documentation 

## Add the config file

- Create file `mink67_security.yaml` in `config/packages` directory

- Add the following content in the file :

    ```
        mink67_security:
            jwk_url: "http://localhost:8081/auth/realms/RNA/protocol/openid-connect/certs"
            host: "http://localhost:8081"
            keycloak_realm: "realm"
            path_token: "auth/realms/master/protocol/openid-connect/token"
            keycloak_user_name: "admin"
            keycloak_pw: "admin"
            keycloak_client_secret: "xxx-xxx-xxx"
            keycloak_client_id: "admin-cli"
    
    ```

## Add package 

```    
    $ composer require mink67/security_bundle
```

## Add new provider and new firewalls in file `security.yaml` in `config/packages` directory

    ```
    
        http://localhost:8081/auth/realms/pao/protocol/openid-connect/certs
        security:
            ...

            providers:
                ...
                oauth:
                    id: Mink67\Security\User\OAuthUserProvider
                ...
            ...
        ...
        firewalls:
            ...
            api:
                pattern:   ^/api/
                provider: oauth
                stateless: true

            ...
        ...
            
    ```


    