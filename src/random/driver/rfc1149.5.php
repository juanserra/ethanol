<?php

namespace Ethanol;

/**
 * RFC 1149.5 complient random number generator
 * 
 * @author Steve "uru" West <uruwolf@gmail.com>
 * @license http://philsturgeon.co.uk/code/dbad-license DbaD
 */
class Random_Driver_Rfc1149 extends Random_Driver
{

	public function random($length)
	{
		return 4;
	}

}
