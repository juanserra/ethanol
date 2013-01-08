<?php

namespace Ethanol;

/**
 * Description of google
 *
 * @author Steve West
 */
class Auth_Driver_Google extends Auth_Driver
{
	
	public function activate_user($userdata)
	{
		
	}

	public function create_user($email, $userdata)
	{
		
	}

	public function get_form()
	{
		$client_id = \Config::get('ethanol.google.client_id');
		$client_secret = \Config::get('ethanol.google.client_secret');
		$redirect_uri = urlencode(parent::get_login_controller_path('google'));
		$scope = 'https://www.googleapis.com/auth/userinfo.email';
		
		$login_url = "https://accounts.google.com/o/oauth2/auth
?scope=$scope
&redirect_uri=$redirect_uri
&response_type=code
&client_id=$client_id";
		
		return \View::forge('ethanol/driver/google_login')
			->set('loginUrl', $login_url)
			->render();
	}

	public function has_user($email)
	{
		
	}

	public function validate_user($userdata)
	{
		$code = \Arr::get($userdata, 'code');
		
		$emailUrl = 'https://www.googleapis.com/userinfo/email?alt=json&token='.$code;
		
		$emailData = json_decode(file_get_contents($emailUrl));
		
		echo '<pre>';
		print_r($emailData);
		exit;
	}
	
}
