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

	public function create_user($email, $userdata)
	{
		$password = \Arr::get($userdata, 'password');
		
		$user = Auth_Driver::get_core_user($email);

		$security = new Model_User_Security;

		//Generate a salt
		$security->salt = Hasher::instance()->hash(\Date::time(), Random::instance()->random());
		$security->password = Hasher::instance()->hash($password, $security->salt);

		unset($password);
		
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
		unset($user->security);

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
	
}
