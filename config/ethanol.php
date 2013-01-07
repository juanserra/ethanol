<?php
return array(
	
	//Auth settings
	//Default auth driver to use if none specified
	'default_auth_driver' => 'database',
	
	//If log in attempts are logged or not. Disabling this will disable things
	//like max log in attempts. It is recomended that this is enabled.
	'log_log_in_attempts' => true,
	'log_in_inital_delay' => 1, // start with a 1 second delay before being able to log in again
	'log_in_delay_scale' => 2, // After a second failed attempt the delay will be 2 seconds, 4 for the next
	'log_in_max_delay' => 45, // The maximum delay that will be applied between attempts
	
	
	//Set to true to make users validate their email address before being able to log in
	'activate_emails' => false,
	'activation_key_length' => 10,
	//This is the location of the account activation controller
	'activation_path' => 'ethanol/account/activate/:key',
	//The from address to be added to the activation email
	'activation_email_from' => 'activation@mysite.com',
	'activation_email_subject' => 'Welcome to the site!',
	
	//Various settings for the hashing class
	'hashing' => array(
		//Default hashing driver to use if none is specified.
		'default_driver' => 'Ethanol\Hash_Driver_Sha1',
	),
	//Various settings for the random class
	'random' => array(
		//Default random driver to use if none is specified.
		'default_driver' => 'Ethanol\Random_Driver_Simple',
	),
	
	//Facebook driver settings
	'facebook' => array(
		'app_id' => '485563954799508',
		'app_secret' => 'e3769b77baef358d50fda20e0bb448f3',
	),
);