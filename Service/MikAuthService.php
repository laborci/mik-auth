<?php namespace MikAuth\Service;

use App\Env;
use MikAuth\ServiceInterface\MikUserApiServiceInterface;
use MikAuth\ServiceInterface\MikUserContainerInterface;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Unirest\Request;

class MikAuthService implements InjectDependencies {

	protected $userContainer;
	protected $apiService;

	public function __construct(MikUserContainerInterface $userContainer, MikUserApiServiceInterface $apiService) {
		$this->userContainer = $userContainer;
		$this->apiService = $apiService;
	}

	protected function requestToken() {
		$response = Request::post(Env::get('auth-token-url'), ['Accept' => 'application/json'], Request\Body::form(['url' => Env::get('auth-return-url'), 'title' => Env::get('auth-page-title')]));
		return json_decode($response->raw_body, true);
	}

	public function getLoginUrl() {
		$token = $this->requestToken();
		return Env::get('auth-login-page') . $token;
	}

	public function getResult($token): MikUserContainerInterface {
		$response = Request::post(Env::get('auth-result-url'), ['Accept' => 'application/json'], Request\Body::form(['token' => $token]));
		$result = json_decode($response->raw_body, true);
		$this->userContainer->login = $result['login'];
		$this->userContainer->name = $result['name'];
		$this->userContainer->email = $result['email'];
		$this->userContainer->type = $result['type'];
		$this->userContainer->flush();

		return $this->userContainer;
	}

	public function logout(){
		$this->userContainer->forget();
		$this->userContainer->flush();
	}
	public function isWorker() { return $this->userContainer->isWorker(); }
	public function isAuthenticated() { return $this->userContainer->isAuthenticated(); }

	public function getUser($create = true) {
		$user = $this->apiService->seekUser($this->userContainer->login);
		if ($user) {
			return $user;
		} else if ($create) {
			$id = $this->apiService->createUser([
				'login' => $this->userContainer->login,
				'name' => $this->userContainer->name,
				'email' => $this->userContainer->email,
				'type' => $this->userContainer->type,
			]);
			return $this->apiService->getUser($id);
		}
		return null;
	}

}