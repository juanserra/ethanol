<?php

//Make sure orm is loaded first as we need this
\Fuel\Core\Package::load('orm');

//For fuel v1 add to the finder path
if(  class_exists('\Finder') )
{
	\Fuel\Core\Finder::instance()->add_path(__DIR__.DS.'..'.DS.'..');
}

\Fuel\Core\Config::load('ethanol', true);
\Fuel\Core\Config::load('ethanol_permissions', true);
\Fuel\Core\Lang::load('ethanol', 'ethanol');

Ethanol\Auth::instance()->register_driver(array(
	'database',
	'facebook',
));
