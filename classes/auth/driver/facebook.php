<?php

namespace Ethanol;

/**
 * 
 *
 * @author Steve "uru" West <uruwolf@gmail.com>
 */
class Auth_Driver_Facebook extends Auth_Driver
{
	
	public function activate_user($userdata)
	{
		
	}

	public function create_user($email, $userdata)
	{
		
	}

	/**
	 * Generates a facebook login page using the facebook template
	 * 
	 * @return string
	 */
	public function get_form()
	{
		$csrf_key = Random::instance()->random();
		\Session::set('ethanol.driver.facebook.csrf', $csrf_key);
		
		$redirect_url = urlencode(parent::get_login_controller_path('facebook'));
		$app_id = \Config::get('ethanol.facebook.app_id');
		
		$login_url = "https://www.facebook.com/dialog/oauth?client_id=$app_id&redirect_uri=$redirect_url&state=$csrf_key&scope=email";
		
		return \View::forge('ethanol/driver/facebook_login')
			->set('login_url', $login_url)
			->render();
	}

	public function has_user($email)
	{
		
	}

	/**
	 * Logs a user in and makes sure there's an assocated Ethanol user as well
	 */
	public function validate_user($userdata)
	{
		//User wants to log in so make sure there's an Ethanol user as well
		
		//TODO: check the CSRF token
		//TODO: Check if there is a active token already? (not sure this is really needed except for reduing number of requests)
		
		$app_id = \Config::get('ethanol.facebook.app_id');
		$app_secret = \Config::get('ethanol.facebook.app_secret');
		$code = \Arr::get($userdata, 'code');
		$redirect_url = urlencode(parent::get_login_controller_path('facebook'));
		
		//Get an access token from FB
		$token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . $app_id . "&redirect_uri=" . $redirect_url
        . "&client_secret=" . $app_secret . "&code=" . $code;
		
		//Warning suppressed to handle bad token data without everything exploding
		$response = @file_get_contents($token_url);
		$params = array();
		parse_str($response, $params);
		
		if(count($params) == 0)
		{
			throw new LogInFailed('Unable to authenticate with facebook.');
		}
		
		//Now we have an access token lets get the email and finally create/check
		//the ethanol user.
		$graph_url = "https://graph.facebook.com/me?access_token=" . $params['access_token'];
		$facebookUser = json_decode(file_get_contents($graph_url));
		
		//Check if a user exists yet.
		
		//if not create
		
		//Got a user so log in now
		
		echo 'Facebook <pre>';
		print_r($facebookUser);
		exit;
	}	
}
