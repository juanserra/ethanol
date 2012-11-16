<?php

namespace Ethanol;

/**
 * 
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Model_User extends \Orm\Model
{

	public static $USER_ACTIVATED = '1';
	public static $USER_INACTIVE  = '0';
	
	protected static $_table_name = 'users';
	protected static $_properties = array(
		'id',
		'username',
		'email',
		'last_login' => array(
			'default' => '0',
		),
		'activated' => array(
			'default' => '',
		),
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
		//Security
		'security' => array(
			'key_from' => 'id',
			'model_to' => 'Ethanol\Model_User_Security',
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
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
			'property' => 'created_at',
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
			'property' => 'updated_at',
		),
	);
	
	public static function _init()
	{
		static::$_properties['activated']['default'] = static::$USER_INACTIVE;
	}

}
