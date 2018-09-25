<?php namespace MikAuth\Service;

use MikAuth\ServiceInterface\MikUserContainerInterface;
use Phlex\Session\Container;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Phlex\Sys\ServiceManager\SharedService;

class MikUserContainer extends Container implements MikUserContainerInterface, InjectDependencies, SharedService {

	public $login;
	public $name;
	public $type;
	public $email;

	private $apiService;

	public function __construct(MikUserApiService $apiService) {
		parent::__construct();
		$this->apiService = $apiService;
	}

	public function isWorker(): bool {
		return $this->type == 'worker';
	}

	public function isAuthenticated(): bool {
		return (bool)strlen($this->login);
	}

}