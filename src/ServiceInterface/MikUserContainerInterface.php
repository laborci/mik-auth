<?php namespace MikAuth\ServiceInterface;

interface MikUserContainerInterface {

	public function isWorker():bool;
	public function isAuthenticated():bool;
	public function flush();
	public function forget();

}