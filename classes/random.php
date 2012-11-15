<?php

namespace Ethanol;

/**
 * 
 * @author Steve "Uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Random
{

	private static $instance = null;
	private $driver_instances = array();
	private $config = array();

	public static function instance()
	{
		if (static::$instance == null)
		{
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct()
	{
		//Load default hashing driver from config.
		$this->config = \Arr::get(\Config::load('ethanol'), 'random', array());
	}
	
	/**
	 * Generates a random string of the given length with the given driver
	 * 
	 * @param int $length Length of the string to generate. Defaults to 25
	 * @param string $driver Name of the driver to use. Null to use the default
	 * @return string
	 */
	public function random($length=25, $driver = null)
	{
		if (!$driverInstance = \Arr::get($this->driver_instances, $driver, false))
		{
			$driverClass = \Arr::get($this->config, 'default_driver');

			$driverInstance = $this->driver_instances[$driverClass] = new $driverClass;
		}

		return $driverInstance->random($length);
	}

}
