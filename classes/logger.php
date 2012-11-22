<?php

namespace Ethanol;

/**
 * Provides an interface for interacting with various logging related things.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Logger
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
	 * Logs an attempt to log in in the database so things like the numner of
	 * log in attempts can be recorded.
	 * 
	 * @param int $status One of $ATTEMPT_GOOD, $ATTEMPT_NO_SUCH_USER or $ATTEMPT_BAD_CRIDENTIALS from Model_Log_In_Attempt
	 * @param string $email The email that's trying to log in.
	 */
	public function log_log_in_attempt($status, $email)
	{
		if (!$this->logging_enabled())
		{
			return;
		}
		$logEntry = new Model_Log_In_Attempt;
		$logEntry->email = $email;
		$logEntry->status = $status;

		$logEntry->save();
		
		//If the entry failed then add a ban too
		if($status != Model_Log_In_Attempt::$ATTEMPT_GOOD)
		{
			Banner::instance()->auto_ban($email);
		}
	}

	/**
	 * Returns the status of the log_log_in_attempts config entry
	 * 
	 * @return boolean
	 */
	public function logging_enabled()
	{
		return \Config::get('ethanol.log_log_in_attempts');
	}

}
