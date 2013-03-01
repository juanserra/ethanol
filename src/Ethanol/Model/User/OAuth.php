<?php

namespace Ethanol;

/**
 * 
 *
 * @author Steve "uru" West <uruwolf@gmail.com>
 */
class Model_User_Oauth extends \Orm\Model
{

	protected static $_table_name = 'ethanol_user_oauth';
	protected static $_properties = array(
		'id',
		'driver',
		'email',
		'user_id',
	);
	protected static $_belongs_to = array(
		'user' => array(
			'key_from' => 'user_id',
			'model_to' => '\Ethanol\Model_User',
			'key_to' => 'id',
		),
	);

}
