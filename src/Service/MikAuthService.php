<?php namespace MikAuth\Service;

use App\Env;
use MikAuth\ServiceInterface\MikAuthServiceInterface;
use MikAuth\ServiceInterface\MikUserApiServiceInterface;
use MikAuth\ServiceInterface\MikUserContainerInterface;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Unirest\Request;

class MikAuthService implements MikAuthServiceInterface, InjectDependencies {

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
		$this->userContainer->setup($result['login'], $result['name'], $result['email'], $result['type']);
		$this->userContainer->flush();
		return $this->userContainer;
	}

	public function logout() {
		$this->userContainer->forget();
		$this->userContainer->flush();
	}

	public function isWorker() { return $this->userContainer->isWorker(); }
	public function isAuthenticated() { return $this->userContainer->isAuthenticated(); }

	public function getUser($create = true) {
		$user = $this->apiService->seekUser($this->userContainer->getLogin());
		if ($user) {
			return $user;
		} else if ($create && $this->userContainer->getType() == 'worker') {
			$id = $this->apiService->createUser($this->userContainer->getData());
			return $this->apiService->getUser($id);
		}
		return null;
	}

}