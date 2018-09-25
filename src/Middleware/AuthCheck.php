<?php namespace MikAuth\Middleware;

use App\ServiceManager;
use MikAuth\ServiceInterface\MikAuthServiceInterface;
use Phlex\Chameleon\Middleware;
use Phlex\Sys\ServiceManager\InjectDependencies;

class AuthCheck extends Middleware implements InjectDependencies {

	protected $authService;
	protected $authRedirectClass;

	public function __construct(MikAuthServiceInterface $authService) {
		parent::__construct();
		$this->authService = $authService;
		$this->authRedirectClass = ServiceManager::get('AuthRedirectClass');
	}

	protected function run() {
		if(!$this->authService->isAuthenticated()) {
			$this->respond($this->authRedirectClass, ['method'=>'login']);
		}
		$this->next();
	}

}
