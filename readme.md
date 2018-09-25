### Phlex module for handling MIK-AUTH

copy the config file into your configs, fill it, and add a reference to index.php

```
putenv('PXCONFIG=config.php,config.auth.php');
```

do not forget to add MikAuth to the service manager

```
ServiceManager::bind('AuthRedirectClass')->value(\MikAuth\Action\AuthRedirect::class);
ServiceManager::bind(MikAuthServiceInterface::class)->sharedService(MikAuthService::class);
ServiceManager::bind(MikUserApiServiceInterface::class)->sharedService(MikUserApiService::class);
ServiceManager::bind(MikUserContainerInterface::class)->sharedService(MikUserContainer::class);
```

finally add auth to your router
```
$router->get('/auth/login', AuthRedirect::class, ['method' => 'login']);
$router->get('/auth/success/{token}', AuthRedirect::class, ['method' => 'success']);
$router->addMiddleware(AuthCheck::class);
$router->get('/auth/logout', AuthRedirect::class, ['method' => 'logout']);
$router->get('/', Page\Index::class);
```