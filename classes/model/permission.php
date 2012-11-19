<?php

namespace Ethanol;

/**
 * 
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Model_Permission extends \Orm\Model
{

	protected static $_table_name = 'permissions';
	protected static $_properties = array(
		'id',
		'identifier',
		'name',
		'description',
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
		'groups' => array(
			'key_from' => 'id',
			'key_through_from' => 'group_id', // column 1 from the table in between, should match a posts.id
			'table_through' => 'groups_permissions', // both models plural without prefix in alphabetical order
			'key_through_to' => 'permission_id', // column 2 from the table in between, should match a users.id
			'model_to' => 'Ethanol\Model_User_Group',
			'key_to' => 'id',
		),
	);

}
