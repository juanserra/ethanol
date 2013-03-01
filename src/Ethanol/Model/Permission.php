<?php

namespace Ethanol;

/**
 * Defines a single permission for a group.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Model_Permission extends \Orm\Model
{

	protected static $_table_name = 'ethanol_group_permissions';
	protected static $_properties = array(
		'id',
		'identifier',
		'group_id',
	);
	protected static $_belongs_to = array(
		//Permissions
		'groups' => array(
			'key_from' => 'group_id',
			'model_to' => '\Ethanol\Model_User_Group',
			'key_to' => 'id',
		),
	);

}
