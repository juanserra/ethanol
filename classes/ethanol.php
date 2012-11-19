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
	private static $session_key = 'ethanol.user';
	private static $guest_user_id = 0;
	private $driver;

	public static function instance($driver_name = null)
	{
		if ($driver_name == null)
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
	 * @param string|array $userdata
	 */
	public function log_in($email, $userdata)
	{
		//Check that the user exists.
		if (!$foundDrivers = $this->user_exists($email))
		{
			$this->log_log_in_attempt(Model_Log_In_Attempt::$ATTEMPT_NO_SUCH_USER, $email);
			throw new LogInFailed(\Lang::get('ethanol.errors.loginInvalid'));
		}

		//Check that the information is correct.
		if (!$user = Auth::instance()->validate_user($email, $userdata, $foundDrivers))
		{
			$this->log_log_in_attempt(Model_Log_In_Attempt::$ATTEMPT_BAD_CRIDENTIALS, $email);
			throw new LogInFailed(\Lang::get('ethanol.errors.loginInvalid'));
		}

		$this->log_log_in_attempt(Model_Log_In_Attempt::$ATTEMPT_GOOD, $email);

		//return the user object and update the session.
		\Session::set(static::$session_key, $user);

		return $user;
	}

	/**
	 * Logs an attempt to log in in the database so things like the numner of
	 * log in attempts can be recorded.
	 * 
	 * @param int $status One of $ATTEMPT_GOOD, $ATTEMPT_NO_SUCH_USER or $ATTEMPT_BAD_CRIDENTIALS from Model_Log_In_Attempt
	 * @param string $email The email that's trying to log in.
	 */
	private function log_log_in_attempt($status, $email)
	{
		$logEntry = new Model_Log_In_Attempt;
		$logEntry->email = $email;
		$logEntry->status = $status;
		
		$logEntry->save();
	}

	/**
	 * Returns an array of driver names that reconise the given email address. 
	 * The array will be empty if the user is not reconised by any drivers.
	 * 
	 * @param string $email
	 * @return array
	 */
	public function user_exists($email)
	{
		return Auth::instance()->user_exists($email);
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

	/**
	 * Gets the currently logged in user. Guests will be represented by a dummy
	 * user object with 0 as the id.
	 * 
	 * @return Ethanol\Model_User
	 */
	public function current_user()
	{
		$user = \Session::get(static::$session_key, false);

		if (!$user)
		{
			$user = $this->construct_guest_user();
		}

		return $user;
	}

	/**
	 * Constructs a dummy guest user.
	 * 
	 * @return \Ethanol\Model_User
	 */
	private function construct_guest_user()
	{
		//TODO: Cache this.

		$user = new Model_User;
		$user->id = static::$guest_user_id;
		$user->meta = new Model_User_Meta;

		//TODO: Add guest groups + permissions

		return $user;
	}

	/**
	 * Returns true if a user is logged in
	 * 
	 * @return boolean
	 */
	public function logged_in()
	{
		return ($this->current_user()->id != static::$guest_user_id);
	}

	//get user info
	//set user groups
	//set group permissions
	//check permissions for user
}

class LogInFailed extends \Exception
{
	
}