<?php

//Make sure orm is loaded first as we need this
Package::load('orm');

Autoloader::add_classes(array(
	'Ethanol\Ethanol'              => __DIR__.'/classes/ethanol.php',
	
	'Ethanol\Hasher'               => __DIR__.'/classes/hasher.php',
	
	'Ethanol\Auth_Driver'          => __DIR__.'/classes/auth/driver.php',
	'Ethanol\Auth_Driver_Database' => __DIR__.'/classes/auth/driver/database.php',
	
	'Ethanol\Model_User'           => __DIR__.'/classes/model/user.php',
	'Ethanol\Model_User_Meta'      => __DIR__.'/classes/model/user/meta.php',
	'Ethanol\Model_User_Group'     => __DIR__.'/classes/model/user/group.php',
	'Ethanol\Model_User'           => __DIR__.'/classes/model/permission.php',
));