<?php

namespace Ethanol;

/**
 * Will contain a common interface to be able to easily access Ethanol features
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Ethanol
{
	
	private static $instance = null;
	
	public static function instance()
	{
		if(static::$instance == null)
		{
			static::$instance = new static;
		}
		
		return static::$instance;
	}
	
	private function __construct()
	{
		\Config::load('ethanol', true);
	}
	
	//Log in
	
	//log out
	
	//user exists
	
	/**
	 * Creates a new user
	 * 
	 * @param type $email
	 * @param type $password
	 * @return Ethanol\Model_User The newly created user
	 */
	public function create_user($username, $email, $password)
	{
		$user = new Model_User;
		$user->username = $username;
		$user->email = $email;
		
		$security = new Model_User_Security;
		$user->security = $security;
		
		//Generate a salt
		$security->salt = Hasher::instance()->hash(\Date::time(), Random::instance()->random());
		$security->password = Hasher::instance()->hash($password, $security->salt);
		
		if(\Config::get('ethanol.activate_emails', false))
		{
			$keyLength = \Config::get('ethanol.activation_key_length');
			$security->activation_hash = Random::instance()->random($keyLength);
			$user->activated = 0;
		}
		
		$user->save();
		unset($user->security);
		return $user;
	}
	
	//get user info
	
	//set user groups
	
	//set group permissions
	
	//check permissions for user
}
