<?php namespace MikAuth\Action;

use MikAuth\ServiceInterface\MikAuthServiceInterface;
use Phlex\Chameleon\RedirectResponder;
use Phlex\Sys\ServiceManager\InjectDependencies;

class AuthRedirect extends RedirectResponder implements InjectDependencies {

	protected $authService;

	public function __construct(MikAuthServiceInterface $authService) {
		parent::__construct();
		$this->authService = $authService;
	}

	protected function redirect(): string {
		switch ($this->getAttributesBag()->get('method')) {
			case 'login':
				return $this->login();
				break;
			case 'success':
				return $this->success();
				break;
			case 'logout':
				return $this->logout();
				break;
		}
		return '/';
	}

	protected function login() {
		if ($this->authService->isAuthenticated()) return '/';
		return $this->authService->getLoginUrl();
	}

	protected function logout(){
		$this->authService->logout();
		return '/';
	}

	protected function success(){
		$token = $this->getPathBag()->get('token');
		$this->authService->getResult($token);
		return '/';
	}

}