<?php namespace App\Site\Website\Service;

use App\Entity\User\User;
use App\ServiceManager;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Unirest\Request;

class MikUserApiService implements InjectDependencies {

	protected $userContainer;
	protected $api = 'http://api.mik-user.test';

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