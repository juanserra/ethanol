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
	
	protected $_ip_field;

	public function __construct($class)
	{
		$props = $class::observers(get_class($this));
		$this->_ip_field = isset($props['ip_field']) ? $props['ip_field'] : 'ip';
	}
	
	public function before_insert(\Orm\Model $model)
	{
		$model->{$this->_ip_field} = \Input::ip();
	}
}
