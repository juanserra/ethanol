<?php

//Make sure orm is loaded first as we need this
Package::load('orm');

//For fuel v1 add to the finder path
if(  class_exists('\Finder') )
{
	\Finder::instance()->add_path(__DIR__.DS.'..'.DS.'..');
}

\Config::load('ethanol', true);
\Config::load('ethanol_permissions', true);
\Lang::load('ethanol', 'ethanol');

Ethanol\Auth::instance()->register_driver(array(
	'database',
	'facebook',
));
