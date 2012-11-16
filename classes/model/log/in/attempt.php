<?php

namespace Ethanol;

/**
 * 
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Model_Log_In_Attempt extends \Orm\Model
{

	public static $ATTEMPT_GOOD = 0;
	public static $ATTEMPT_NO_SUCH_USER = 1;
	public static $ATTEMPT_BAD_CRIDENTIALS = 2;
	
	protected static $_table_name = 'log_in_attempt';
	protected static $_properties = array(
		'id',
		'status',
		'user_id',
		'ip',
		'time',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
			'property' => 'time',
		),
	);

}
