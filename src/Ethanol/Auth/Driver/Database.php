<?php

namespace Ethanol;

/**
 * Allows users to be stored in the databse.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Auth_Driver_Database extends Auth_Driver
{

	public function create_user($userdata)
	{
		$password = \Arr::get($userdata, 'password', null);
		$email = \Arr::get($userdata, 'email', null);
	
		if(is_null($password) || is_null($email))
		{
			Logger::instance()->log_log_in_attempt(Model_Log_In_Attempt::$ATTEMPT_BAD_CRIDENTIALS, $email);
			throw new LogInFailed(\Lang::get('ethanol.errors.loginInvalid'));
		}
		
		$user = Auth_Driver::get_core_user($email);

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
			$security->activation_hash = '';
		}

		$user->security = $security;
		$user->save();
		$user->clean_security();

		return $user;
	}

	public function activate_user($key)
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

	public function has_user($email)
	{
		$users = Model_User::find_by_email($email);

		return (count($users) > 0);
	}

	public function validate_user($userdata)
	{	
		$email = \Arr::get($userdata, 'email');
		
		if(!$this->has_user($email))
		{
			Logger::instance()->log_log_in_attempt(Model_Log_In_Attempt::$ATTEMPT_NO_SUCH_USER, $email);
			throw new LogInFailed(\Lang::get('ethanol.errors.loginInvalid'));
		}
		
		$user = Model_User::find('first', array(
			'related' => array(
				'security',
				'meta',
				'groups',
			),
			'where' => array(
				array('email', $email),
			),
		));

		$password = \Arr::get($userdata, 'password');

		//Hash the given password and check that against the user
		$hashedPassword = Hasher::instance()->hash($password, $user->security->salt);

		if ($hashedPassword == $user->security->password)
		{
			$user->clean_security();
			return $user;
		}

		return false;
	}

	public function get_form()
	{
		$submitUri = \Uri::create(null, array(), array('driver' => 'database'));
		
		return \View::forge('ethanol/driver/database_login')
			->set('submitUri', $submitUri)
			->render();
	}

}
