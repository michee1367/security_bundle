# Documentation 

## Add the config file

- Create file `mink67_security.yaml` in `config/packages` directory

- Add the following content in the file :

    ```
        mink67_security:
            jwk_url: "http://localhost:8081/auth/realms/RNA/protocol/openid-connect/certs"
    
    ```

## Add package 

```    
    $ composer require mink67/security_bundle
```

## Add new provider and new firewalls in file `security.yaml` in `config/packages` directory

    ```
        mink67_security:
            jwk_url: "http://localhost:8081/auth/realms/RNA/protocol/openid-connect/certs"
    
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


    