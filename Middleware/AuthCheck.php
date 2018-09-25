<?php namespace App\Site\Website\Middleware;

use App\Site\Website\Action\AuthRedirect;
use App\Site\Website\Service\MikAuthService;
use Phlex\Chameleon\Middleware;
use Phlex\Sys\ServiceManager\InjectDependencies;

class AuthCheck extends Middleware implements InjectDependencies {

	protected $authService;

	public function __construct(MikAuthService $authService) {
		parent::__construct();
		$this->authService = $authService;
	}

	protected function run() {
		if(!$this->authService->isAuthenticated()) {
			$this->respond(AuthRedirect::class, ['method'=>'login']);
		}
		$this->next();
	}

}
