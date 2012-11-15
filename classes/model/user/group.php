<?php

namespace Ethanol;

/**
 * 
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 */
class Model_User_Group extends \Orm\Model
{

	protected static $_table_name = 'user_groups';
	protected static $_properties = array(
		'id',
		'name',
	);
	protected static $_many_many = array(
		//users
		'users' => array(
			'key_from' => 'id',
			'key_through_from' => 'user_id', // column 1 from the table in between, should match a posts.id
			'table_through' => 'groups_users', // both models plural without prefix in alphabetical order
			'key_through_to' => 'group_id', // column 2 from the table in between, should match a users.id
			'model_to' => 'Ethanol\Model_User',
			'key_to' => 'id',
		),
		//Permissions
		'permissions' => array(
			'key_from' => 'id',
			'key_through_from' => 'group_id', // column 1 from the table in between, should match a posts.id
			'table_through' => 'groups_permissions', // both models plural without prefix in alphabetical order
			'key_through_to' => 'permission_id', // column 2 from the table in between, should match a users.id
			'model_to' => 'Ethanol\Model_Permission',
			'key_to' => 'id',
		),
	);

}
