<?php namespace App\Site\Website\Service;

use App\Env;
use Phlex\Sys\ServiceManager\InjectDependencies;
use Unirest\Request;

interface MikAuthInterface{

	protected function requestToken();
	public function getLoginUrl();
	public function getResult($token): MikUserContainerInerface;
	public function logout();
	public function isWorker();
	public function isAuthenticated();
	public function getUser($create = true);

}