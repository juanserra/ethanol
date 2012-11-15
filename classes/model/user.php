<?php

namespace Ethanol;

/**
 * 
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 */
class Model_User extends \Orm\Model
{

	protected static $_table_name = 'users';
	protected static $_properties = array(
		'id',
		'username',
		'email',
		'activation_key',
		'last_login',
		'activated',
		'created_at',
		'updated_at',
	);
	protected static $_has_one = array(
		//Has one meta data
		'meta' => array(
			'key_from' => 'id',
			'model_to' => 'Ethanol\Model_User_Meta',
			'key_to' => 'user_id',
			'cascade_delete' => true,
		),
	);
	protected static $_many_many = array(
		//Lots of users can be in lots of groups
		'groups' => array(
			'key_from' => 'id',
			'key_through_from' => 'user_id', // column 1 from the table in between, should match a posts.id
			'table_through' => 'groups_users', // both models plural without prefix in alphabetical order
			'key_through_to' => 'group_id', // column 2 from the table in between, should match a users.id
			'model_to' => 'Ethanol\Model_User_Group',
			'key_to' => 'id',
		),
	);

}
