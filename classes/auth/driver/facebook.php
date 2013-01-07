<?php

namespace Ethanol;

/**
 * 
 *
 * @author Steve "Uru" West <uruwolf@gmail.com>
 */
class Auth_Driver_Facebook extends Auth_Driver
{
	
	public function activate_user($userdata)
	{
		
	}

	public function create_user($email, $userdata)
	{
		
	}

	public function get_form()
	{
		$csrf_key = Random::instance()->random();
		
		$login_url = 'https://www.facebook.com/dialog/oauth?
client_id='.\Config::get('ethanol.facebook.app_id').'
&redirect_uri='.urlencode('http://localhost/ethanol/public/').'
&state='.$csrf_key;
		
		return \View::forge('ethanol/driver/facebook_login')
			->set('login_url', $login_url)
			->render();
	}

	public function has_user($email)
	{
		
	}

	public function validate_user($email, $userdata)
	{
		
	}	
}
