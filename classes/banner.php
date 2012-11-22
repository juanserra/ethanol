<?php

namespace Ethanol;

/**
 * Defines common functions to do with banning users and checking if they are
 * banned.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Banner
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
		;
	}

	/**
	 * Returns true if the email or IP is banned
	 * 
	 * @param string $email
	 * @return boolean
	 */
	public function is_banned($email = null)
	{
		$bans = Model_Ban::query()
			->where('expires', '>', time())
			->and_where_open();
		
		if ($email != null)
		{
			$bans->where('email', $email);
		}
		
		$bans->or_where('ip', \Input::ip())
			->and_where_close();

		return ($bans->count() > 0);
	}

	/**
	 * Bans the given email or ip for an ammount of time
	 * 
	 * @param string|int $time Takes a string, "+1 day", or a number of seconds
	 * @param null|string|true $ip Null to ignore IP, string to specify the ip, true to automatically load the ip
	 * @param null|string $email 
	 */
	public function ban($time, $ip = null, $email = null)
	{
		if ($ip == null && $email == null)
		{
			throw new \InvalidArgumentException('Both IP and Email cannot be null');
		}

		//Load the right IP
		if ($ip && !is_string($ip))
		{
			$ip = \Input::ip();
		}

		//Create a correct expire time
		$expireTime = 0;
		if (is_string($time))
		{
			$expireTime = strtotime($time);
		}
		else
		{
			$expireTime = time() + $time;
		}

		$model = new Model_Ban;
		$model->ip = $ip;
		$model->email = $email;
		$model->expires = $expireTime;
		$model->save();
	}

	public function attempt_number($email)
	{
		$ip = \Input::ip();

		//Check the number of log in attempts for this user and this ip
		$lastGood = Model_Log_In_Attempt::query()
			->select('time')
			->where('status', Model_Log_In_Attempt::$ATTEMPT_GOOD)
			->and_where_open()
			->where('email', $email)
			->or_where('ip', $ip)
			->and_where_close()
			->order_by('time', 'DESC')
			->limit(1);

		$attempts = Model_Log_In_Attempt::query()
			->where('time', '>', $lastGood->get_query(false))
			->and_where_open()
			->where('email', $email)
			->or_where('ip', $ip)
			->and_where_close()
			->order_by('time', 'DESC')
			->get();

		if (count($attempts) == 0)
		{
			//There was no good last login so get all of them instead
			$attempts = Model_Log_In_Attempt::find('all', array(
					'where' => array(
						'or' => array(
							array('ip', $ip),
							array('email', $email),
						),
					),
					'order_by' => array(
						array('time', 'DESC'),
					),
				));
		}

		return count($attempts);
	}

	/**
	 * Calculates a ban time and creates a ban for the given email and the current
	 * IP address.
	 * 
	 * @param string $email
	 */
	public function auto_ban($email)
	{
		$attemptNumber = $this->attempt_number($email);

		$scaleFactor = \Config::get('ethanol.log_in_delay_scale');
		$initalBanTime = \Config::get('ethanol.log_in_inital_delay');

		$delay = (($attemptNumber - 1) * $scaleFactor) * $initalBanTime;

		//Check that the delay is not above the max delay
		$maxDelay = \Config::get('ethanol.log_in_max_delay');
		if($delay > $maxDelay)
		{
			//if so set to be the max delay.
			$delay = $maxDelay;
		}
		
		$this->ban($delay, true, $email);
	}

}
