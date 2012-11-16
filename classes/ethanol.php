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

	private static $instances = array();
	private $driver;

	public static function instance($driver_name = null)
	{
		if($driver_name == null)
			$driver_name = \Config::get('ethanol.default_auth_driver');
		
		if (!$instance = \Arr::get(static::$instances, $driver_name, false))
		{
			$instance = static::$instances[$driver_name] = new static($driver_name);
		}

		return $instance;
	}

	public static function _init()
	{
		\Config::load('ethanol', true);
		\Lang::load('ethanol', 'ethanol');
	}
	
	private function __construct($driver_name)
	{
		$this->driver = $driver_name;
	}

	/**
	 * Attempts to log a user in
	 * 
	 * @param string $email
	 * @param string|null $password
	 */
	public function log_in($email, $password = null)
	{
		//Check that the user exists.
		
		//Check that the information is correct.
		
		//Log the log in attempt if enabled.
		
		//return the user object and update the session.
	}
	
	private function log_log_in_attempt($status)
	{
		
	}
	
	/**
	 * Creates a new user. If you wish to use emails as usernames then just pass
	 * the email address as the username as well.
	 * 
	 * @param string $email
	 * @param string $userdata
	 * 
	 * @return Ethanol\Model_User The newly created user
	 * 
	 */
	public function create_user($email, $userdata)
	{
		return Auth::instance()->create_user($this->driver, $email, $userdata);
	}

	/**
	 * Activates a user when they need to confirm their email address
	 * 
	 * @param string $userdata The information to pass to the driver
	 * @return boolean True if the user was activated
	 */
	public function activate($userdata)
	{
		return Auth::instance()->activate_user($this->driver, $userdata);
	}

	//get user info
	//set user groups
	//set group permissions
	//check permissions for user
}
