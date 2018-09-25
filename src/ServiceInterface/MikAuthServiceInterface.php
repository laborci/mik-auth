<?php namespace MikAuth\ServiceInterface;


interface MikAuthServiceInterface{

	public function getLoginUrl();
	public function getResult($token): MikUserContainerInterface;
	public function logout();
	public function isWorker();
	public function isAuthenticated();
	public function getUser($create = true);

}