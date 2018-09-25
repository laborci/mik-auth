
copy the config file into your configs, and add it to index.php

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