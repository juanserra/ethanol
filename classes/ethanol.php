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
		if (static::$instance == null)
		{
			static::$instance = new static;
		}

		return static::$instance;
	}

	private function __construct()
	{
		\Config::load('ethanol', true);
		\Lang::load('ethanol', 'ethanol');
	}

	/**
	 * Attempts to log a user in
	 * 
	 * @param string $username
	 * @param string $password
	 */
	public function log_in($username, $password = null)
	{
		
	}

	//log out
	//user exists

	/**
	 * Creates a new user. If you wish to use emails as usernames then just pass
	 * the email address as the username as well.
	 * 
	 * @param string $email
	 * @param string $password
	 * @param string $username Null if you want usernames to be the same as emails
	 * 
	 * @return Ethanol\Model_User The newly created user
	 * 
	 */
	public function create_user($email, $userdata, $driver = null)
	{
		$driver = ($driver == null) ? \Config::get('ethanol.default_auth_driver') : $driver;
		return Auth::instance()->create_user($driver, $email, $userdata);
	}

	/**
	 * Activates a user when they need to confirm their email address
	 * 
	 * @param string $userdata The information to pass to the driver
	 * @param string $driver The auth driver to use. Null to use the default.
	 * @return boolean True if the user was activated
	 */
	public function activate($userdata, $driver=null)
	{
		$driver = ($driver == null) ? \Config::get('ethanol.default_auth_driver') : $driver;
		return Auth::instance()->activate_user($driver, $userdata);
	}

	//get user info
	//set user groups
	//set group permissions
	//check permissions for user
}
