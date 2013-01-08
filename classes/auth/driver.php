<?php

namespace Ethanol;

/**
 * Defines a common interface for authentication drivers.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
abstract class Auth_Driver
{

	/**
	 * Asks the driver to create a new user.
	 * 
	 * @param string $email The email address of this user. This is required by all drivers.
	 * @param array $userdata An array containing various information about the user to create.
	 * @return Ethanol\Model_User The user object that was created.
	 */
	public abstract function create_user($email, $userdata);

	/**
	 * Allows a user to be activated if user activation is required
	 * 
	 * @param array|string $userdata The data that is required for activation.
	 * Check individual driver documentaion for what to pass.
	 */
	public abstract function activate_user($userdata);
	
	/**
	 * Checks if the given user is reconised by this driver
	 * 
	 * @param string $email The email of the user to search for
	 * @return boolean True if the user exists
	 */
	public abstract function has_user($email);
	
	/**
	 * Attempts to validate a user's cradentials
	 * 
	 * @param string|array $userdata Any extra data that might be needed
	 * @return false|Ethanol\Model_User
	 */
	public abstract function validate_user($userdata);
	
	/**
	 * This should retun a block of HTML that can be used to login with the
	 * driver.
	 */
	public abstract function get_form();
	
	/**
	 * Attempts to find a user by email address or returns a new (unsaved) user
	 * object if not.
	 * 
	 * @param string $email
	 * @return \Ethanol\Model_User
	 */
	public static final function get_core_user($email)
	{
		$user = Model_User::find_by_email($email);
		
		if($user == null)
		{
			$user = new Model_User;
			$user->meta = new Model_User_Meta;
			$user->email = $email;
		}
		return $user;
	}
	
	public final function get_login_controller_path($driver)
	{
		return \Uri::create(null, array(), array('driver' => $driver));
	}

	/**
	 * Makes a request to an oAuth service for an access token
	 * 
	 * @param type $url
	 * @param type $driver
	 * @return array
	 * @throws LogInFailed
	 */
	protected final function get_access_token($url, $driver)
	{
		//Warning suppressed to handle bad token data without everything exploding
		$response = @file_get_contents($url);
		$params = array();
		parse_str($response, $params);
		
		if(count($params) == 0)
		{
			throw new LogInFailed('Unable to authenticate with '.$driver);
		}
		
		return $params;
	}
	
	protected function perform_login($email, $driver)
	{
		//Check if a user exists yet.
		$oauth = Model_User_Oauth::find('first', array(
			'related' => array(
				'user'
			),
			'where' => array(
				array('driver', $driver),
				array('email', $email)
			),
		));
		
		//if not create
		if(is_null($oauth))
		{	
			//Check if we have a guest user or not.
			if(Ethanol::instance()->is_guest())
			{
				$user = new Model_User;
				$user->activated = Model_User::$USER_ACTIVATED;
				$user->email = $email;
			}
			else
			{
				//Not a guest user so get the current user.
				$user = Ethanol::instance()->current_user();
			}
			
			//And assocate the new oauth with it.
			$oauth = new Model_User_Oauth;
			$oauth->driver = $driver;
			$oauth->email = $email;
			
			$user->oauth[] = $oauth;
			
			$user->save();
		}
		else
		{
			$user = $oauth->user;
		}
		
		return $user;
	}
}

class NoSuchActivationKey extends \Exception {}

class UserAlreadyActivated extends \Exception {}
