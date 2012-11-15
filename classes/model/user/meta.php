<?php

namespace Ethanol;

/**
 * 
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 */
class Model_User_Meta extends \Orm\Model
{

	protected static $_table_name = 'user_metadata';
	protected static $_properties = array(
		'id',
		'user_id',
	);
	protected static $_belongs_to = array(
		'user' => array(
			'key_from' => 'user_id',
			'model_to' => 'Ethanol\Model_User',
			'key_to' => 'id',
			'cascade_delete' => true,
		),
	);

}
