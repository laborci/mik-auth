<?php namespace MikAuth\ServiceInterface;

interface MikUserContainerInterface {

	public function isWorker(): bool;
	public function isAuthenticated(): bool;
	public function flush();
	public function forget();
	public function setup($login, $name, $email, $type);
	public function getLogin();
	public function getName();
	public function getType();
	public function getEmail();
	public function getData();
}