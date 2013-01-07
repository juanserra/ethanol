<?php

namespace Ethanol;

/**
 * Provides an interface for interacting with authorisation drivers.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Auth
{

	private static $instance = null;
	private $driver_instances = array();
	private $avaliable_drivers = array();

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
	 * Registers the given auth driver 
	 * 
	 * @param string|array $drivers
	 */
	public function register_driver($drivers)
	{
		$drivers = (array) $drivers;
		foreach ($drivers as $driver)
		{
			$this->avaliable_drivers[] = $driver;
		}
	}

	/**
	 * Translates a driver name to a class name
	 * 
	 * @param string $name Name of the driver (eg, 'facebook')
	 * @return string 'Ethanol\Auth_Driver_Facebook'
	 */
	public function translate_driver_name($name)
	{
		return 'Ethanol\Auth_Driver_' . \Inflector::words_to_upper($name);
	}

	/**
	 * Gets an instance of the given driver name.
	 * 
	 * @param string $name The name of the driver to load.
	 * @return \Ethanol\class
	 */
	public function get_driver($name)
	{
		$class = $this->translate_driver_name($name);

		//Check if there is already an instance of this class. If not create it
		if (!$instance = \Arr::get($this->driver_instances, $class, false))
		{
			$instance = $this->driver_instances[$class] = new $class;
		}

		return $instance;
	}

	/**
	 * Creates a user with the given driver
	 * 
	 * @param string $driver Name of the driver to use. (eg, 'database')
	 * @param string $email The email address to identify this user
	 * @param array|string $userdata See individual driver documentation
	 * @return Ethanol\Model_User
	 */
	public function create_user($driver, $email, $userdata)
	{
		return $this->get_driver($driver)->create_user($email, $userdata);
	}

	/**
	 * Activates the user with the given driver
	 * 
	 * @param string $driver Name of the driver to activate.
	 * @param array|string $userdata Data regarding activation. Check individual driver docs
	 * @return boolean True if the user was activated.
	 */
	public function activate_user($driver, $userdata)
	{
		return $this->get_driver($driver)->activate_user($userdata);
	}

	/**
	 * Asks all drivers if a user exists with the given email and returns a list
	 * of drivers that reconise the user.
	 * 
	 * @param type $email
	 * @return array 
	 */
	public function user_exists($email)
	{
		$drivers = array();
		foreach ($this->avaliable_drivers as $driver)
		{
			if ($this->get_driver($driver)->has_user($email))
			{
				$drivers[] = $driver;
			}
		}

		return $drivers;
	}

	/**
	 * Asks each of the given drivers if the passed user credentials are valid.
	 * 
	 * @param string $email The email of the account to check
	 * @param array|string $userdata The extra user data to validate
	 * @param array $drivers List of driver names to try
	 * @return false|Ethanol\Model_User
	 */
	public function validate_user($credentials)
	{
		//Get the requested driver and attempt a login
		$driver = \Arr::get($credentials, 'driver', null);
		if($driver == null)
		{
			//No driver specified so throw an error
			throw new ConfigError('No driver was specified.');
		}
		
		$user = $this->get_driver($driver)->validate_user($credentials);
		if ($user instanceof Model_User)
		{
			return $user;
		}

		return false;
	}

	/**
	 * Gets the login forms for the given drivers. If null is passed then all
	 * forms will be returned. Alternatly an array of names can be passed to get
	 * a select number of login forms or a string for a single login form.
	 * 
	 * @param string|array|null $driver The name(s) of the drivers to get the forms for
	 */
	public function get_form($drivers=null)
	{
		//Work out what form of input we have been given and load the correct
		//driver list for it.
		$driverList = array();
		if(is_string($drivers))
		{
			$driverList = (array) $drivers;
		}
		else if(is_array($drivers))
		{
			$driverList = $drivers;
		}
		else
		{
			$driverList = $this->avaliable_drivers;
		}
		
		//Loop through all the drivers and ask them for their html
		$html = array();
		foreach($driverList as $driver)
		{
			$html[$driver] = $this->get_driver_form_html($driver);
		}
		
		return $html;
	}
	
	/**
	 * Gets the html log in form for the given driver
	 * 
	 * @param string $driver Name of a the driver
	 */
	public function get_driver_form_html($driver)
	{
		$instance = $this->get_driver($driver);
		
		return $instance->get_form();
	}
}
