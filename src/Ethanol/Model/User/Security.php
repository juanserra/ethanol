<?php

namespace Ethanol;

/**
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Model_User_Security extends \Orm\Model
{
	protected static $_table_name = 'ethanol_user_security';
	protected static $_properties = array(
		'id',
		'user_id',
		'password',
		'salt',
		'activation_hash',
	);
	protected static $_belongs_to = array(
		'user' => array(
			'key_from' => 'user_id',
			'model_to' => '\Ethanol\Model_User',
			'key_to' => 'id',
			'cascade_delete' => true,
		),
	);
}
