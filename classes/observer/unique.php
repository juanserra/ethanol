<?php

namespace Ethanol;

/**
 * Ensures that a column in the database is unique.
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Observer_Unique extends \Orm\Observer
{

	protected $_property;

	public function __construct($class)
	{
		$props = $class::observers(get_class($this));
		$this->_property = isset($props['property']) ? $props['property'] : '';
	}

	public function before_save(\Orm\Model $model)
	{
		$groupName = $model->{$this->_property};

		$diff = $model->get_diff();
		
		if(!key_exists($groupName, $diff[0]))
		{
			return;
		}
		
		echo '<pre>';
		print_r($model->get_diff());
		exit;
		
		$modelClass = get_class($model);
		$existing = $modelClass::find('all', array(
				'where' => array(
					array('name', $groupName)
				),
			));
		
		if ($existing)
		{
			throw new ColumnNotUnique(\Lang::get('ethanol.errors.alreadyDefined', array(
					'value' => $groupName,
					'property' => $this->_property,
					)
			));
		}
	}

}

class ColumnNotUnique extends \Exception
{
	
}
