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

    