<?php

namespace Ethanol;

/**
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Auth
{
	private static $instance = null;
	private $driver_instances = array();
	
	public static function instance()
	{
		if(static::$instance == null)
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
	 * Translates a driver name to a class name
	 * 
	 * @param string $name Name of the driver (eg, 'facebook')
	 * @return string 'Ethanol\Auth_Driver_Facebook'
	 */
	public function translateDriverName($name)
	{
		return 'Ethanol\Auth_Driver_'.\Inflector::words_to_upper($name);
	}
	
	private function get_driver($name)
	{
		$class = $this->translateDriverName($name);
		
		if(!$instance = \Arr::get($this->driver_instances, $class, false))
		{
			$instance = $this->driver_instances[$class] = new $class;
		}
		
		return $instance;
	}
	
	/**
	 * Creates a user with the given driver
	 */
	public function create_user($driver, $email, $userdata)
	{
		return $this->get_driver($driver)->create_user($email, $userdata);
	}
	
	public function activate_user($driver, $userdata)
	{
		return $this->get_driver($driver)->activate_user($userdata);
	}
	
}
