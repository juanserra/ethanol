<?php

namespace Ethanol;

/**
 * Allows an ip address to be automatically added to a log in log entry.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Observer_LogIp extends \Orm\Observer
{
	
	public function before_insert(\Orm\Model $model)
	{
		$model->ip = \Input::ip();
	}
}
