<?php

//Make sure orm is loaded first as we need this
Package::load('orm');

Autoloader::add_classes(array(
	'Ethanol\Ethanol'              => __DIR__.'/classes/ethanol.php',
	
	//Hashing related classes
	'Ethanol\Hasher'               => __DIR__.'/classes/hasher.php',
	'Ethanol\Hash_Driver'          => __DIR__.'/classes/hash/driver.php',
	'Ethanol\Hash_Driver_Sha1'     => __DIR__.'/classes/hash/driver/sha1.php',
	
	//Random related classes
	'Ethanol\Random'               => __DIR__.'/classes/random.php',
	'Ethanol\Random_Driver'        => __DIR__.'/classes/random/driver.php',
	'Ethanol\Random_Driver_Simple' => __DIR__.'/classes/random/driver/simple.php',
	'Ethanol\Random_Driver_Rfc1149'=> __DIR__.'/classes/random/driver/rfc1149.5.php',
	
	//Auth related classes
	'Ethanol\Auth'                 => __DIR__.'/classes/auth.php',
	'Ethanol\Auth_Driver'          => __DIR__.'/classes/auth/driver.php',
	'Ethanol\Auth_Driver_Database' => __DIR__.'/classes/auth/driver/database.php',
	'Ethanol\Auth_Driver_Facebook' => __DIR__.'/classes/auth/driver/facebook.php',
	'Ethanol\Auth_Driver_Google'   => __DIR__.'/classes/auth/driver/google.php',
	
	//Logging related classes
	'Ethanol\Logger'               => __DIR__.'/classes/logger.php',
	'Ethanol\Banner'               => __DIR__.'/classes/banner.php',
	
	//Various orm models
	'Ethanol\Model_User'           => __DIR__.'/classes/model/user.php',
	'Ethanol\Model_User_Meta'      => __DIR__.'/classes/model/user/meta.php',
	'Ethanol\Model_User_Security'  => __DIR__.'/classes/model/user/security.php',
	'Ethanol\Model_User_Group'     => __DIR__.'/classes/model/user/group.php',
	'Ethanol\Model_User_Oauth'     => __DIR__.'/classes/model/user/oauth.php',
	'Ethanol\Model_Permission'     => __DIR__.'/classes/model/permission.php',
	'Ethanol\Model_Log_In_Attempt' => __DIR__.'/classes/model/log/in/attempt.php',
	'Ethanol\Model_Ban'            => __DIR__.'/classes/model/ban.php',
	'Ethanol\Observer_LogIp'	   => __DIR__.'/classes/observer/logip.php',
	'Ethanol\Observer_Unique'	   => __DIR__.'/classes/observer/unique.php',
	
	//Exceptions
	'Ethanol\LogInFailed'          => __DIR__.'/classes/ethanol.php',
	'Ethanol\GroupNotFound'        => __DIR__.'/classes/ethanol.php',
	'Ethanol\NoSuchUser'           => __DIR__.'/classes/ethanol.php',
	'Ethanol\UserExists'           => __DIR__.'/classes/ethanol.php',
	'Ethanol\ConfigError'          => __DIR__.'/classes/ethanol.php',
	
	'Ethanol\NoSuchActivationKey'  => __DIR__.'/classes/auth/driver.php',
	'Ethanol\UserAlreadyActivated' => __DIR__.'/classes/auth/driver.php',
));

Ethanol\Auth::instance()->register_driver(array(
	'database',
	'facebook',
	'google',
));
