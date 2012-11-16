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

	//Log in
	public function log_in($username, $password)
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
	 * @throws EmailSendingFailedException If there was aproblem sending the email. Check the email package for more info
	 * @throws EmailValidationFailedException If there was an email validation problem. Check the email package for more info
	 * @throws Ethanol\NoSuchActivationKey
	 */
	public function create_user($email, $password, $username=null)
	{
		$user = new Model_User;
		$user->username = ($username == null)? $email : $username ;
		$user->email = $email;

		$security = new Model_User_Security;

		//Generate a salt
		$security->salt = Hasher::instance()->hash(\Date::time(), Random::instance()->random());
		$security->password = Hasher::instance()->hash($password, $security->salt);

		if (\Config::get('ethanol.activate_emails', false))
		{
			$keyLength = \Config::get('ethanol.activation_key_length');
			$security->activation_hash = Random::instance()->random($keyLength);
			$user->activated = 0;

			//Send email
			\Package::load('email');

			//Build an array of data that can be passed to the email template
			$emailData = array(
				'username' => $user->username,
				'email' => $user->email,
				'activation_path' => \Str::tr(
					\Config::get('ethanol.activation_path'), array('key' => $security->activation_hash)
				),
			);

			$email = \Email::forge()
				->from(\Config::get('ethanol.activation_email_from'))
				->to($user->email, $user->username)
				->subject(\Config::get('ethanol.activation_email_subject'))
				->html_body(\View::forge('ethanol/activation_email', $emailData))
				->send();
		}
		else
		{
			$user->activated = 1;
		}

		$user->security = $security;
		$user->save();
		unset($user->security);

		return $user;
	}

	/**
	 * Activates a user when they need to confirm their email address
	 * 
	 * @param string $key The key to try to activate
	 * @return boolean True if the user was activated
	 * @throws NoSuchActivationKey If the key given is invalid
	 * @throws UserAlreadyActivated If the user has already been activated
	 */
	public function activate($key)
	{
		$security = Model_User_Security::find('first', array(
				'related' => array(
					'user'
				),
				'where' => array(
					array('activation_hash', $key),
				),
			));

		//Check if an entry actually exists
		if ($security == null)
		{
			//User does not exist so thow exception
			throw new NoSuchActivationKey(\Lang::get('ethanol.errors.noSuchKey'));
		}
		//Check that the user has not already been activated
		if ($security->user->activated != Model_User::$USER_INACTIVE)
		{
			throw new UserAlreadyActivated(\Lang::get('ethanol.errors.userAlreadyActive'));
		}

		$security->user->activated = Model_User::$USER_ACTIVATED;
		$security->activation_hash = '';
		$security->save();

		return true;
	}

	//get user info
	//set user groups
	//set group permissions
	//check permissions for user
}

class NoSuchActivationKey extends \Exception
{
	
}

class UserAlreadyActivated extends \Exception
{
	
}
