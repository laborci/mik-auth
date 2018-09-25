<?php namespace MikAuth\Service;

use App\Env;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Phlex\Sys\ServiceManager\SharedService;
use Unirest\Request;

class MikUserApiService implements InjectDependencies, SharedService {

	protected $userContainer;
	protected $api;

	public function __construct() {
		$this->api = Env::get('user-api-url');
	}

	public function getUser(int $id){
		$response = Request::get($this->api.'/user/'.$id);
		return json_decode($response->raw_body, true);
	}

	public function seekUser($login){
		$response = Request::get($this->api.'/user/seek/'.$login);
		return json_decode($response->raw_body, true);
	}


	public function searchUser($search){
		$response = Request::get($this->api.'/user/search/'.$search);
		return json_decode($response->raw_body, true);
	}

	public function createUser($data){
		$response = Request::post($this->api.'/user/create', ['Accept' => 'application/json'], Request\Body::form($data));
		return json_decode($response->raw_body, true);
	}

}