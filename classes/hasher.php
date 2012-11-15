<?php

namespace Ethanol;

/**
 * Will controll the ability to use difernent hashing/random libraries
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Hasher
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
		$this->config = \Arr::get(\Config::load('ethanol'), 'hashing');
	}

	/**
	 * 
	 * @param string $string The string to hash
	 * @param string $salt The salt to add to the hash
	 * @param string $driver The driver to use, or null for the default hash driver
	 * @return string The hashed string.
	 */
	public function hash($string, $salt = '', $driver = null)
	{
		if (!$driverInstance = \Arr::get($this->driver_instances, $driver, false))
		{
			$driverClass = \Arr::get($this->config, 'default_driver');

			$driverInstance = $this->driver_instances[$driverClass] = new $driverClass;
		}

		return $driverInstance->hash($string, $salt);
	}

}
