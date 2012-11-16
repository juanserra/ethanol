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
	
	'Ethanol\Auth_Driver'          => __DIR__.'/classes/auth/driver.php',
	'Ethanol\Auth_Driver_Database' => __DIR__.'/classes/auth/driver/database.php',
	
	//Various orm models
	'Ethanol\Model_User'           => __DIR__.'/classes/model/user.php',
	'Ethanol\Model_User_Meta'      => __DIR__.'/classes/model/user/meta.php',
	'Ethanol\Model_User_Security'  => __DIR__.'/classes/model/user/security.php',
	'Ethanol\Model_User_Group'     => __DIR__.'/classes/model/user/group.php',
	'Ethanol\Model_Permission'     => __DIR__.'/classes/model/permission.php',
));