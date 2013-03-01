<?php

namespace Ethanol;

/**
 * Temp class to contain bootstrapping code
 *
 * @author Steve West
 */
class Bootstrap
{
	
	public static function bootstrap()
	{
		//Make sure orm is loaded first as we need this
		\Fuel\Core\Package::load('orm');

		//For fuel v1 add to the finder path
		if(  class_exists('\Fuel\Core\Finder') )
		{
			\Fuel\Core\Finder::instance()->add_path(__DIR__.DS.'..'.DS.'..');
		}

		\Fuel\Core\Config::load('ethanol', true);
		\Fuel\Core\Config::load('ethanol_permissions', true);
		\Fuel\Core\Lang::load('ethanol', 'ethanol');

		Auth::instance()->register_driver(array(
			'database',
			'facebook',
		));
	}
	
}
