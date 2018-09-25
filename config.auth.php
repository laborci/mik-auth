<?php return [
	'auth-result-url' => '',
	'auth-token-url' => '',
	'auth-return-url' => '',
	'auth-page-title' => '',
	'auth-login-page' => '',
	'user-api-url' => '',
];

// copy this file into your configs, and add it to index.php
// putenv('PXCONFIG=config.php,config.auth.php');
// do not forget to add AuthRedirectClass value to your ServiceManager in Evn ( ServiceManager::bind('AuthRedirectClass')->value(\MikAuth\Action\AuthRedirect::class); )