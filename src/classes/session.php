<?php

namespace Ethanol;

/**
 * Allows the session that Ethanol uses to be changed dynamically
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Session
{

	protected static $instance = null;
	protected $session_instances = array();
	protected $default_session_id = '_default_';

	/**
	 * Keeps track of the orrignal default session name so it can be reset later
	 */
	public static $default_instance_name = '_default_';

	public static function instance()
	{
		if ( is_null(static::$instance) )
		{
			static::$instance = new static;
		}

		return static::$instance;
	}

	protected function __construct()
	{
		//Add the default session from fuel
		$this->session_instances[$this->default_session_id] = \Session::instance();
	}

	/**
	 * Adds an instance to the collection. Expects a Fuel Session object as the
	 * instance.
	 * 
	 * @param mixed $instance
	 * @param string $identifier Unique identifier for the session instance
	 */
	public function add_instance($instance, $identifier)
	{
		$this->session_instances[$identifier] = $instance;
	}
	
	/**
	 * Gets the given session instance or returns the default
	 * 
	 * @param string $name
	 */
	public function get_instance($name = null)
	{
		if ( is_null($name) )
		{
			$name = $this->default_session_id;
		}

		return \Arr::get($this->session_instances, $name);
	}
	
	/**
	 * Gets the current default session name
	 * 
	 * @return string
	 */
	public function get_default_name()
	{
		return $this->default_session_id;
	}

	/**
	 * Allows the default instance to be set.
	 * 
	 * @param string|null $name Null to revert to the orrignal default
	 */
	public function set_default_instance($name = null)
	{
		if ( is_null($name) )
		{
			$this->default_session_id = static::$default_instance_name;
		}
		else
		{
			$this->default_session_id = $name;
		}
	}

}
