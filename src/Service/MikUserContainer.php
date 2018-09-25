<?php namespace MikAuth\Service;

use MikAuth\ServiceInterface\MikUserContainerInterface;
use Phlex\Session\Container;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Phlex\Sys\ServiceManager\SharedService;

class MikUserContainer extends Container implements MikUserContainerInterface, InjectDependencies, SharedService {

	protected $login;
	protected $name;
	protected $type;
	protected $email;

	public function getLogin() { return $this->login; }
	public function getName() { return $this->name; }
	public function getType() { return $this->type; }
	public function getEmail() { return $this->email; }

	public function getData() {
		return [
			'login' => $this->login,
			'name' => $this->name,
			'email' => $this->email,
			'type' => $this->type
		];
	}

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

	public function setup($login, $name, $email, $type) {
		$this->login = $login;
		$this->name = $name;
		$this->email = $email;
		$this->type = $type;
	}

}