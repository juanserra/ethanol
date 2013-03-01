<?php

namespace Ethanol;

/**
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Random_Driver_Simple extends Random_Driver
{

	public function random($length)
	{
		$original_string = array_merge(range(0,9), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
		
        return substr(str_shuffle($original_string), 0, $length);
	}

}
