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
				if($this->authService->isAuthenticated()) return '/';
				return $this->authService->getLoginUrl();
				break;
			case 'success':
				$token = $this->getPathBag()->get('token');
				$this->authService->getResult($token);
				return '/';
				break;
			case 'logout':
				$this->authService->logout();
				return '/';
				break;
		}
	}
}