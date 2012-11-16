<?php
return array(
	//Set to true to make users validate their email address before being able to log in
	'activate_emails' => true,
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
);