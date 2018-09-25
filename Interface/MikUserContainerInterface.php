<?php namespace App\Site\Website\Service;

use Phlex\Session\Container;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Phlex\Sys\ServiceManager\SharedService;

class MikUserContainer extends Container implements InjectDependencies, SharedService {

	public $login;
	public $name;
	public $type;
	public $email;

	private $apiService;

	public function __construct(MikUserApiService $apiService) {
		parent::__construct();
		$this->apiService = $apiService;
	}

	public function isWorker() {
		return $this->type == 'worker';
	}

}