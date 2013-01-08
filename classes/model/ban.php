<?php

namespace Ethanol;

/**
 * Defines a ban in the database
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Model_Ban extends \Orm\Model
{

	protected static $_table_name = 'ethanol_bans';
	protected static $_properties = array(
		'id',
		'email',
		'ip',
		'created_at',
		'expires',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
			'property' => 'created_at',
		),
	);

}
